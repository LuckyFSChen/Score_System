<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表 > 創建比賽') }}

            </h4>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-2 lg:px-8">
            @if($errors->any())
                <div class="bg-red-500 text-red-100 font-thin rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('game.edit') }}">
                @csrf

                <div>
                    <x-jet-label for="name" value="{{ __('比賽名稱') }}" />
                    <x-jet-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus />
                </div>


                <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('創建') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
