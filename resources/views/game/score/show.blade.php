<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __($game_name.' > 評分') }}

            </h4>

        </div>
    </x-slot>
    <style>
        table tbody {
            display:block;
            height: 500px;
            overflow-y:scroll;
        }
        table thead, tbody tr {
            display:table;
            width:100%; 
            table-layout:fixed;
        }
        table thead {
            width: calc( 100% - 1em )
        }
      
    </style>
    <script>
        
        window.onload = function() {
            window.setInterval(() => {
                document.getElementById("btnSubmit").click()
            }, 300000);
        }
        function compute(team_id){
            var sum = 0;
            @foreach($percentage as $percentKey => $percentValue)
                sum += document.getElementById(team_id+"-"+"{{ $percentKey }}").value * {{$percentValue}} / 100
            @endforeach
            document.getElementById("count_"+team_id).value = sum.toFixed(2);
        }
    </script>

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">
        <form action="{{ route('score.store',$game_id) }}" id="form" method="POST" class="items-center">
            @csrf
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                <tr>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">隊伍編號</th>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">報告順序</th>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">隊伍名稱</th>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">指導老師</th>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">隊長</th>
                    @foreach($titles as $title)
                        <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">
                            <div>
                                {{$title->name}}
                            </div>                            
                            <div>
                                
                            </div>
                        </th>
                        
                    @endforeach
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">總分</th>
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-400 text-center">詳細介紹</th>
                    
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                @foreach($teams as $team)
                <tr>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->serial_num }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->report_num }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->name }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->teacher }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->captain }}</td>
                    @foreach($titles as $title)
                        <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                            @if(\App\Models\adjudicator_team::where([
                                ['adjudicator_id',auth()->user()->adjudicator()->first()->id],
                                ['team_id',$team->id]    
                            ])->count() > 0)
                                <input class="max-w-md border rounded border-gray-300 min-w-24 w-full px-1 " disabled onchange="compute({{ $team->id }})" type="number" name="{{ $team->id.'-'.$title->id }}" id="{{ $team->id.'-'.$title->id }}" required placeholder="輸入 0 - 100" min="0.00" max="100.00" step="0.01" value="{{ $scores[$team->id.'-'.$title->id] }}" id="">
                            @else
                                <input class="max-w-md border rounded border-gray-300 min-w-24 w-full px-1 " onchange="compute({{ $team->id }})" oninput="validateScore(this)" type="number" name="{{ $team->id.'-'.$title->id }}" id="{{ $team->id.'-'.$title->id }}" required placeholder="輸入 0 - 100" min="0.00" max="100.00" step="0.01" value="{{ $scores[$team->id.'-'.$title->id] }}" id="">
                                <script>
                                    function validateScore(input) {
                                        var scoreValue = parseFloat(input.value);
                                        // 檢查是否超過 100
                                        if (scoreValue > 100) {
                                            alert("成績只能在 0 到 100 之間。請檢查並重新輸入。");
                                            // 將該欄位的值設定為 100
                                            input.value = 100;
                                        }
                                    }
                                </script>
                            @endif
                        </td>
                    @endforeach
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                        @if(\App\Models\adjudicator_team::where([
                            ['adjudicator_id',auth()->user()->adjudicator()->first()->id],
                            ['team_id',$team->id]    
                        ])->count() > 0)
                            <input class="max-w-md border rounded border-gray-300 min-w-24 w-full px-1 text-center" disabled  type="number" name="{{ 'count_'.$team->id }}" id="{{ 'count_'.$team->id }}" step="0.01" value="0" required readonly>
                        @else
                            <input class="max-w-md border rounded border-gray-300 min-w-24 w-full px-1 text-center"  type="number" name="{{ 'count_'.$team->id }}" id="{{ 'count_'.$team->id }}" step="0.01" value="0" required readonly>
                        @endif
                        <script> compute({{ $team->id }})</script>
                    </td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400"><a href="{{route('team_details',$team->id)}}" target="_blank">查看詳細資料</a> </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mx-auto flex justify-center">
                <button type="button" id="btnSubmit" onclick="checkAndSubmit()" class="my-6 mx-8 border border-gray-300 p-2 rounded font-bold text-xl bg-green-500 ">儲存/送出</button>
            </div>

            <script>
                function checkAndSubmit() {
                    // 檢查是否有成績是預設值（0.00）
                    var hasDefaultScores = false;

                    var scoreInputs = document.querySelectorAll('input[type="number"]');
                    scoreInputs.forEach(function(input) {
                        var scoreValue = parseFloat(input.value);
                        if (scoreValue === 0) {
                            hasDefaultScores = true;
                        }
                    });

                    // 如果有預設值，顯示提醒視窗
                    if (hasDefaultScores) {
                        var confirmMsg = "還有欄位沒有填到，確定要儲存隊伍評分嗎？";
                        if (confirm(confirmMsg)) {
                            // 如果確定，提交表單
                            document.getElementById('form').submit();
                        }
                    } else {
                        // 如果沒有預設值，直接提交表單
                        document.getElementById('form').submit();
                        return confirm('確定儲存隊伍評分嗎?');
                    }
                }
            </script>
            
        </form>
    </div>
    

</x-app-layout>