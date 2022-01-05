<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表') }}

            </h4>

        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        @foreach($games as $game)
            <div class="bg">
                {{$game->id}}
            </div>

        @endforeach

    </div>
    <div class="max-w-7xl mx-auto">
{{--        {{ $games->links() }}--}}

    </div>

</x-app-layout>
