<div class="h-full ">
    <div class="h-[10%] px-2  border-b border-gray-500 flex justify-between items-center">
        <div>
            Chat
        </div>
        <div>
            <img class="rounded-full w-10 h-10"
                src="https://ui-avatars.com/api/?background=random&name={{ auth()->user()->name }}" alt="">
        </div>

    </div>
    <div class="h-[90%] overflow-y-auto">
        @if(count($conversations) > 0)
        @foreach ($conversations as $conversation)

        <div wire:key='{{ $conversation->id }}'
            class="bg-gray-200 border border-gray-300 p-1 rounded-lg mt-2 mx-2 flex justify-between items-center hover:bg-gray-300"
            wire:click="$emit('chatUserSelected',{{ $conversation }},{{ $this->getChatUserInstance($conversation,$name='id') }})">
            <div class="flex items-center">
                <div>
                    <img class="rounded-full border-gray-300 w-12 h-12"
                        src="https://ui-avatars.com/api/?background=random&name={{ $this->getChatUserInstance($conversation,$name='name') }}"
                        alt="img">
                </div>
                <div class="flex flex-col ml-2 ">
                    <p class="font-medium">{{ $this->getChatUserInstance($conversation,$name='name') }}</p>
                    <p class="text-gray-500 text-sm">{{ $conversation->messages->last()->body ??'None' }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 ">



                @php
                if(count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id)))
                {
                echo '<span
                    class="text-xs text-white text-center px-1 bg-red-600 rounded-full">'.count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id)).'</span>';
                }
                @endphp

            </div>
        </div>

        @endforeach

        @else
        <div
            class="bg-gray-200 border border-gray-300 p-1 rounded-lg mt-2 mx-2 flex justify-between items-center hover:bg-gray-300">
            <p>
                There is no conversation!
            </p>
        </div>

        @endif
    </div>
</div>