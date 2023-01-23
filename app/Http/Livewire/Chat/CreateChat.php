<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;

class CreateChat extends Component
{
    public $users;
    public $message = 'hello';


    public function checkConversation($receiverId)
    {
        $checkedConversation = Conversation::where('sender_id', \auth()->user()->id)->where('receiver_id', '$receiverId')->orWhere('receiver_id', \auth()->user()->id)->orWhere('sender_id', '$receiverId')->get();
        if (\count($checkedConversation) == 0) {
            $createdConversation = Conversation::create(
                [
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $receiverId
                ]
            );
            $createdMessage = Message::create([
                'conversation_id' => $createdConversation->id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $receiverId,
                'body' => $this->message
            ]);

            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();
        } else if (\count($checkedConversation) >= 1) {
            dd('conversation exists');
        }
    }


    public function render()
    {
        $this->users = User::where('id', '!=', \auth()->user()->id)->get();
        return view('livewire.chat.create-chat');
    }
}
