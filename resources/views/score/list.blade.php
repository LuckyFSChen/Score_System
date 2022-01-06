<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __($game_name.' > 評分') }}

            </h4>

        </div>
    </x-slot>

    <script>
        function del_sure(name){
            var conf = confirm("你確定要刪除" + name + "嗎?");

            if (conf){
                return true;
            }else{
                return false;
            }
        }
    </script>

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">
        <form action="{{ route('score.store',$game_id) }}" method="POST" class="items-center">
            @csrf
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                <tr>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">隊伍編號</th>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">隊伍名稱</th>
                    @foreach($titles as $title)
                        <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">{{$title->name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                @foreach($teams as $team)
                <tr>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->serial_num }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->name }}</td>
                    @foreach($titles as $title)
                        <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                            {{$scores[$team->id.'-'.$title->id]}}
                        </td>
                    @endforeach
                </tr>
                @endforeach
                </tbody>
            </table>
        </form>
    </div>

</x-app-layout>
