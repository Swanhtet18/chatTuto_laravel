<div class="h-[90%] ">
    @if($selectedConversation)
    <div class="border-b border-gray-200 h-[11%] flex justify-between px-3 items-center">
        <div class="flex gap-4 items-center">
            <i class="fa-sharp fa-solid fa-arrow-left return select-none"></i>
            <img class="rounded-full w-10 h-10"
                src="https://ui-avatars.com/api/?background=random&name={{ $receiverInstance->name }}" alt="">
            <p>{{ $receiverInstance->name }}</p>
        </div>
        <div class="flex gap-6">
            <i class="fa-solid fa-phone text-lg"></i>
            <i class="fa-regular fa-image text-lg"></i>
            <i class="fa-sharp fa-solid fa-circle-info text-lg"></i>
        </div>
    </div>
    <div class=" w-full h-[89%] overflow-y-auto flex flex-col body">
        @foreach ($messages as $message)

        <div
            class="rounded-xl p-2 max-w-[60%] m-2 max-w-max
            {{ auth()->id() == $message->sender_id? ' bg-gray-300 self-end text-gray-600' : 'bg-blue-500 text-white self-start' }}  ">
            <p>{{ $message->body }}</p>
            <p class="mt-2 text-xs text-right">{{ $message->created_at->format('m: i a') }}
                <span>
                    @php
                    if($message->user->id === auth()->id())
                    {
                    if($message->read == 0){
                    echo'<i class="fa-solid fa-check text-xs text-gray-400 tick"></i>';
                    } else {
                    echo'<i class="fa-solid fa-check-double text-xs text-gray-400"></i>';
                    }
                    }
                    @endphp

                </span>
            </p>
        </div>
        @endforeach
    </div>
    <script>
        $('.body').on('scroll',function(){
            var top = $('.body').scrollTop();
            if(top == 0){
            window.livewire.emit('loadmore')
            }
        })
           
    </script>
    <script>
        window.addEventListener('updatedHeight',event=>{
        let old = event.detail.height;
        let newHeight = $('.body')[0].scrollHeight;
        let height = $('.body').scrollTop(newHeight - old);
        
        window.livewire.emit('updateHeight',{
        height:height
        });
        });
    </script>
    @else <div class="text-center pt-16 font-semibold">No Conversation Selected</div>
    @endif

    <script>
        window.addEventListener('rowChatToBottom',event=>{

            $('.body').scrollTop($('.body')[0].scrollHeight);
        }); 
    </script>
    <script>
        $(document).on('click','.return',function(){
            window.livewire.emit('resetComponent');
        })
    </script>
    <script>
        window.addEventListener('markMessageAsRead',event=>{
            var value = document.querySelectorAll('.tick');
            value.array.forEach(element, index => {
                element.classList.remove('fa-solid fa-check');
                element.classList.add('fa-solid fa-check-double')
            });
        })
    </script>
</div>