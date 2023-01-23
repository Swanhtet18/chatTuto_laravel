<div class="h-[10%] px-2  border-b border-gray-500 flex justify-between items-center">
    <div>
        Chat
    </div>
    <div>
        <img class="rounded-full" src="https://i.pravatar.cc/50?u=1" alt="">
    </div>

</div>
@if(count($conversations) > 0)

@foreach ($conversations as $conversation)

<div class="bg-gray-200 border border-gray-300 p-1 rounded-lg mt-2 mx-2 flex justify-between items-center hover:bg-gray-300"
    wire:click="$emit('chatUserSelected',{{ $conversation }},{{ $this->getChatUserInstance($conversation,$name='id') }})">
    <div class="flex items-center">
        <div>
            <img class="rounded-full border-gray-300"
                src="https://i.pravatar.cc/50?u={{ $this->getChatUserInstance($conversation,$name='id') }}" alt="img">
        </div>
        <div class="flex flex-col ml-2 ">
            <p class="font-medium">{{ $this->getChatUserInstance($conversation,$name='name') }}</p>
            <p class="text-gray-500 text-sm">{{ $conversation->messages->last()->body ??'None' }}</p>
        </div>
    </div>

    <div class="flex flex-col gap-3 ">
        <span class="text-xs">{{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans()
            }}</span>
        <div>
            <span class="text-xs text-red-500   text-center px-1">44</span>
        </div>

    </div>
</div>

@endforeach

@else
<div>THere is no conversation.</div>

@endif