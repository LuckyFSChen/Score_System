<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __($game_name.' > 管理員成績清單') }}

            </h4>

        </div>
    </x-slot>

    <script>
        $(document).ready(function () {
        $('#Total').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    messageTop: '{{ $game_name }}'
                },
                {
                    extend: 'excel',
                    messageTop: '{{ $game_name }}'
                },
                {
                    extend: 'print',
                    messageTop: '{{ $game_name }}'
                },
                
            ]
        });
        $('#Total2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    messageTop: '{{ $game_name }}'
                },
                {
                    extend: 'excel',
                    messageTop: '{{ $game_name }}'
                },
                {
                    extend: 'print',
                    messageTop: '{{ $game_name }}'
                }
            ]
        });
    });
    </script>

    

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">
        <div class="text-center text-3xl my-6">總成績清單</div>
        <table class="border-collapse table-fixed w-full text-sm" id="Total">
            <thead>
            <tr>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">隊伍編號</th>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">報告順序</th>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">隊伍名稱</th>
                @foreach($titles as $title)
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">{{$title->name}}</th>
                @endforeach
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">總分</th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                @foreach($teams as $team)
                <tr>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->serial_num }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->report_num }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->name }}</td>
                    @foreach($titles as $title)
                        <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                            {{ $scores[$team->id.'-'.$title->id.'-sum'] }}
                        </td>
                    @endforeach
                    <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                        {{ $scores[$team->id.'-team_sum'] }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">

        <div class="text-center text-3xl my-6">歷史成績</div>

        <table class="border-collapse table-fixed w-full text-sm" id="Total2">
            <thead>
            <tr>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">評審姓名</th>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">隊伍名稱</th>
                @foreach($titles as $title)
                    <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">{{$title->name}}</th>
                @endforeach
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">總分</th>

            </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                @foreach($adjudicators as $adjudicator)
                    @foreach($teams as $team)
                    <tr>
                        <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $adjudicator->user()->first()->name }}</td>
                        <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $team->name }}</td>
                        @foreach($titles as $title)
                            <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                                {{ $scores[$adjudicator->id.'-'.$team->id . '-'. $title->id]}}
                            </td>
                    
                        
                        @endforeach
                        <td class="border-b border-gray-100 dark:border-gray-700 px-2 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                            {{ $scores['sub-'.$adjudicator->id.'-'.$team->id.'-sum']}}
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
