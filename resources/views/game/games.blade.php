<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表') }}

            </h4>

            <div class="ml-6 bg-gray-200 rounded">
                <a class="text-sm p-2" href="{{ route('games.addPage') }}">創建比賽</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @foreach($games as $game)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
                <div class="flex bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <p class="font-sans ">{{ $game->name }}</p>
                        <div class="w-auto py-2 ml-6 mt-2 flex">
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('games.editPage',[ 'game_id' => $game->id]) }}">比賽資訊</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('scoreTitles.index',$game->id) }}">成績欄位</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('adjudicator.index',$game->id) }}">評審人員</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('team.index',$game->id) }}">隊伍資訊</a>
                            <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('admin_score.list',$game->id) }}">結果查詢</a>
                            @if($game->enabled)
                                <a class="text-sm p-2 bg-gray-200 rounded ml-4 bg-rose-500 text-white" href="{{ route('game.close',$game->id) }}">關閉比賽</a>
                            @else
                                <a class="text-sm p-2 bg-gray-200 rounded ml-4 bg-emerald-500 text-white" href="{{ route('game.open',$game->id) }}">開啟比賽</a>
                            @endif

                            <form method="post" class="" action="{{ route('game.destroy',$game->id) }}">
                                @csrf
                                <button class="text-sm p-2 bg-rose-500 text-white rounded ml-4" type="submit">移除比賽</button>
                            </form>
                            <a class="text-sm p-2 ml-4"> 建立時間 {{ $game->created_at }} / 更新時間 {{ $game->updated_at }} </a>

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
