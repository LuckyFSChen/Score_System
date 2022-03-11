<x-app-layout>
    <x-slot name="header">
        <script>
            function upload(e) {
                var file = e.files[0];
                if (!file) {
                    return;
                } else {
                    document.getElementById("import").submit();
                }
            }
        </script>
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表 > 隊伍資訊') }}

            </h4>
            <div class="ml-6 bg-gray-200 rounded">
                <form action="{{ route('team.import',$game_id) }}" id="import" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="text-sm px-4" onclick="document.getElementById('file').click()">匯入隊伍</label>
                    <input type="file" name="file" id="file" onchange="upload(this);" hidden>
                </form>


            </div>
            <form action="{{ route('team.clear',$game_id)}}" method="post">
                @csrf
                <button class="ml-6 bg-gray-200 rounded px-4" type="submit">清除隊伍</button>
            </form>

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

    @if (session()->has('notice'))
        <div class="bg-red-500 text-center">
            <p class="text-gray-200">{{ session()->get('notice') }}</p>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">

        <table class="border-collapse table-fixed w-full text-sm">
            <thead>
            <tr>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-left">隊伍編號</th>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-left">隊伍名稱</th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
            @foreach($teams as $team)
            <tr>
                <td class="border-b border-gray-100 dark:border-gray-700 px-4 py-4 text-xl pl-8 text-gray-500 dark:text-gray-400">{{ $team->serial_num }}</td>
                <td class="border-b border-gray-100 dark:border-gray-700 px-4 py-4 text-xl pl-8 text-gray-500 dark:text-gray-400">{{ $team->name }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
