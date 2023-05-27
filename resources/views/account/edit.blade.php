
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('帳戶中心 > 修改資訊') }}

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
            <form method="POST" action="{{ route('account.edit',$id) }}">
                @csrf
                <div>
                    <x-jet-label for="name" value="{{ __('會員名稱') }}" />
                    <x-jet-input id="name" class="block mt-2 w-full" type="text" name="name" :value="$user->name" required autofocus />
                    
                    <x-jet-label for="email" value="{{ __('email') }}" />
                    <x-jet-input id="email" class="block mt-2 w-full" type="email" name="email" :value="$user->email" required autofocus />

                    
                   
                </div>


                <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('修改') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
