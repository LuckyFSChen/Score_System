<x-app-layout>
    <x-slot name="header">
        <div class="items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ '比賽列表 > '.$game_name.' > '.$adjudicator->user()->first()->name }}

            </h4>
        </div>
    </x-slot>


    @if (session()->has('notice'))
        <div class="bg-red-500 text-center">
            <p class="text-gray-200">{{ session()->get('notice') }}</p>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">

        @foreach($teamList as $team)
            <div class="mt-4 flex bg-white overflow-hidden shadow-xl sm:rounded-lg items-center">

                <div class="p-6">
                    <div class="font-semibold text-lg">隊伍名稱</div>
                    <div class="font-semibold">{{ $team->name }}</div>
                </div>
                <div class="p-6">
                    @if($teamActivate->where('team_id',$team->id)->count() > 0)
                        <a class="text-sm p-2 bg-gray-200 rounded ml-4 bg-rose-500 text-white" href="{{ route('adjudicator.close',[$game_id,$adjudicator->id,$team->id]) }}">停用評分</a>
                    @else
                        <a class="text-sm p-2 bg-gray-200 rounded ml-4 bg-emerald-500 text-white" href="{{ route('adjudicator.open',[$game_id,$adjudicator->id,$team->id]) }}">啟用評分</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
