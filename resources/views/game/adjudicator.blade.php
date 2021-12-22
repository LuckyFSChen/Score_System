<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('隊伍資訊') }}

            </h4>
            <div class="ml-6 bg-gray-200 rounded">
                <a class="text-sm p-2" href="{{ route('game_add_page') }}">創建比賽</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @foreach($games as $game)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
                <div class="flex bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <p class="font-sans ">{{ $game->name }}</p>
                        <div class="w-auto py-2 ml-6 mt-2">
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('games.edit_page',$game->id) }}">比賽資訊</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('games.score_page',$game->id) }}">成績欄位</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('games.adjudicator_page',$game->id) }}">評審人員</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('games.team_page',$game->id) }}">隊伍資訊</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="max-w-7xl mx-auto">
        {{ $games->links() }}

    </div>

</x-app-layout>
