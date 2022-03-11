<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表') }}

            </h4>

        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        @foreach($games as $game)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
            <div class="flex bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <p class="font-sans ">{{ $game->name }}</p>
                    <div class="w-auto py-2 ml-6 mt-2 flex">
                        <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('score.score',[ 'game_id' => $game->id]) }}">評分</a>
                        <a class="text-sm p-2 bg-gray-200 rounded ml-4" href="{{ route('adjudicator_score.list',[ 'game_id' => $game->id]) }}">查詢結果</a>

                        <a class="text-sm p-2 ml-4"> 建立時間 {{ $game->created_at }} / 更新時間 {{ $game->updated_at }} </a>

                    </div>

                </div>
            </div>
        </div>

        @endforeach

    </div>
    <div class="max-w-7xl mx-auto">
{{--        {{ $games->links() }}--}}

    </div>

</x-app-layout>
