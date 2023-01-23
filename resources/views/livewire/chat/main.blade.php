<div class="w-[95%] left-2 xs:left-4  sm:left-6 mt-2 border border-gray-500 fixed h-[87%] flex rounded-xl ">
    <div class="hidden border-r border-gray-500 w-[25%] h-full sm:block ">
        @livewire('chat.chat-list')
    </div>
    <div class="w-full sm:w-[75%] h-full ">
        @livewire('chat.chatbox')

        @livewire('chat.send-message')
    </div>
</div>