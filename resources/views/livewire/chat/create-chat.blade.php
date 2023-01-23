<div class="flex w-full h-full justify-center mt-6">
    <table class="border-separate border-spacing-2  w-[80%] ">
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="border border-gray-300 py-2 px-4 hover:bg-gray-200"
                    wire:click='checkConversation({{ $user->id }})'>{{ $user->name }}</td>
            </tr>
            @endforeach


        </tbody>
    </table>
</div>