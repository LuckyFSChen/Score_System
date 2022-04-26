<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表 > '.$game_name.' > 評審人員 > 新增評審人員帳號') }}

            </h4>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-2 lg:px-8">
            @if(session()->has('notice'))
                <div class="bg-red-500 text-red-100 font-thin rounded">
                    <ul>
                        {{ session()->get('notice') }}
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('adjudicator.register',$id) }}">
                @csrf

                <div>
                    <div>
                        <x-jet-label for="name" value="{{ __('名稱') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
        
        
                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('密碼') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" name="password" type="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4 block">
                        <x-jet-input type="checkbox" onclick="ShowHidePw()" />顯示密碼
                    </div>
                </div>


                <div class="flex items-center justify-center mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('創建') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
    <script>

        function ShowHidePw(){
            var txtPw = $("#password");
            if (txtPw.attr("type") == "text"){
                txtPw.attr("type","password");
            }else{
                txtPw.attr("type","text");
            }
        }

    </script>
</x-app-layout>
