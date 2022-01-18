<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __($game_name.' > 評分') }}

            </h4>

        </div>
    </x-slot>

    <script>
        function compute(team_id){
            var sum = 0;
            @foreach($percentage as $percentKey => $percentValue)
                sum += document.getElementById(team_id+"-"+"{{ $percentKey }}").value * {{$percentValue}} / 100
            @endforeach
            document.getElementById("count_"+team_id).value = sum.toFixed(4);
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
                        <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">
                            <div>
                                {{$title->name}}
                            </div>                            
                            <div>
                                
                            </div>
                        </th>
                        
                    @endforeach
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">總分</th>
                    
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                @foreach($teams as $team)
                <tr>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->serial_num }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->name }}</td>
                    @foreach($titles as $title)
                        <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                            <input class="max-w-md border rounded border-gray-300 min-w-24 w-full px-1 " onchange="compute({{ $team->id }})" type="number" name="{{ $team->id.'-'.$title->id }}" id="{{ $team->id.'-'.$title->id }}" required placeholder="輸入 0 - 100" min="0.0000" max="100.0000" step="0.0001" value="{{ $scores[$team->id.'-'.$title->id] }}" id="">
                            
                        </td>
                    @endforeach
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                        <input class="max-w-md border rounded border-gray-300 min-w-24 w-full px-1 text-center"  type="number" name="{{ 'count_'.$team->id }}" id="{{ 'count_'.$team->id }}" step="0.0001" value="0" readonly>
                        <script> compute({{ $team->id }})</script>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mx-auto flex justify-center">
                <button onclick="" class="my-6 mx-8 border border-gray-300 p-2 rounded font-bold text-xl bg-sky-500 ">儲存</button>
                <button type="submit" class="my-6 mx-8 border border-gray-300 p-2 rounded font-bold text-xl bg-green-500 ">送出</button>
            </div>
            
        </form>
    </div>
    

</x-app-layout>
