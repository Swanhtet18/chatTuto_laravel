<div class="w-[95%] left-2 xs:left-4  sm:left-6 mt-2 border border-gray-500 fixed h-[87%] flex rounded-xl ">
    <div class="w-full sm:border-r border-gray-500 sm:w-[25%] h-full  chat_list">
        @livewire('chat.chat-list')
    </div>
    <div class="hidden sm:block w-full sm:w-[75%] h-full chat_box">
        @livewire('chat.chatbox')
        @livewire('chat.send-message')
    </div>

    <script>
        window.addEventListener('chatSelected',event=>{
            if(window.innerWidth < 640) {
                $('.chat_list').hide();
                $('.chat_box').show(); 
            }
            $('.chat_box').show();

            $('.body').scrollTop($('.body')[0].scrollHeight);

            var height = $('.body')[0].scrollHeight;
            window.livewire.emit('updateHeight',{
                height:height
            })
           
        });

        $(window).resize(function(){
            if(window.innerWidth > 640 ) {
                $('.chat_list').show();
                $('.chat_box').show();
            }
        });

        $(document).on('click','.return',function(){
        $('.chat_list').show();
        $('.chat_box').hide();
        });

       

      
    </script>
</div>