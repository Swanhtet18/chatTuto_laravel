<div class="h-[10%]">
    @if($selectedConversation)
    <div class="border-t border-gray-300 h-full">
        <form wire:submit.prevent='sendMessage'
            class="w-full h-full flex gap-1 xs:gap-3 lg:gap-6  items-center justify-center " action="" method="post">
            <input wire:model='body'
                class="w-[85%]  focus:outline-none focus:outline-none focus:border-none  bg-gray-300 border-0  rounded-xl"
                type="text">
            <button class="text-blue-500  font-bold">Send</button>
        </form>
    </div>
    @endif

</div>