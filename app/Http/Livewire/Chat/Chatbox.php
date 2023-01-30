<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;


class Chatbox extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $messages_count;
    public $messages;
    public $paginateVar = 10;
    public $height;


    // protected $listeners = ['loadConversation', 'pushMessage', 'loadmore', 'updateHeight'];

    public function getListeners()
    {
        $auth_id = \auth()->user()->id;
        return
            [
                "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
                "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
                'loadConversation', 'pushMessage', 'loadmore', 'updateHeight', 'broadcastMessageRead', 'resetComponent'
            ];
    }

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
    }

    function broadcastedMessageRead($event)
    {
        if ($this->selectedConversation) {
            if ((int) $this->selectedConversation->id === (int) $event['conversation_id']) {
                $this->dispatchBrowserEvent('markMessageAsRead');
            }
        }
    }

    function broadcastedMessageReceived($event)
    {

        $this->emitTo('chat.chat-list', 'refresh');

        $broadcastedMessage = Message::find($event['message_id']);

        if ($this->selectedConversation) {
            if ((int) $this->selectedConversation->id === (int)$event['conversation_id']) {
                $broadcastedMessage->read = 1;
                $broadcastedMessage->save();

                $this->pushMessage($broadcastedMessage->id);

                $this->emitSelf('broadcastMessageRead');
            }
        }
    }

    public function broadcastMessageRead()
    {
        \broadcast(new MessageRead($this->selectedConversation->id, $this->receiverInstance->id));
    }

    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');
    }

    public function loadmore()
    {
        $this->paginateVar += 10;

        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;

        $this->dispatchBrowserEvent('updatedHeight', ($height));
    }

    public function updateHeight($height)
    {
        $this->height = $height;
    }

    public function loadConversation(Conversation $conversation, User $receiver)
    {

        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;

        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)->get();

        $this->dispatchBrowserEvent('chatSelected');

        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', auth()->user()->id)->update(['read' => 1]);

        $this->emitSelf('broadcastMessageRead');
    }
    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
