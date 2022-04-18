<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __($team_name.' > 詳細資料') }}

            </h4>

        </div>
    </x-slot>


    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">
        
        
        @foreach ($details as $detail)
            <div class="my-4">
                <span class=" text-2xl font-bold my-2 bg-white/75 block">{{ $detail->team_details_title()->first()->name }}</span>
                <div class="p-5 border text-xl border-gray-400 bg-gray-500/25 dark:border-gray-700 dark:bg-gray-900">
                    <p class="mb-2 text-blue-500 dark:text-blue-400">
                        @if (str_contains($detail->content,"http"))
                            <a href="{{ $detail->content }}" target="_blank">{{ $detail->content }}</a>
                        @else
                            {!! $detail->content !!}
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    

</x-app-layout>
