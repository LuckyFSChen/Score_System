<x-app-layout>
    <x-slot name="header">
        <div class="items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ '比賽列表 > '.$game_name.' > 評審人員' }}

            </h4>
            <div class="mt-4 flex">
                <form  method="POST" action="{{ route('adjudicator.find',$id) }}">
                    @csrf
                    <input type="text" class="px-2 py-2 rounded border border-gray-400" placeholder="請輸入評審name..." name="name" id="name">
                    <button type="submit" class="ml-4 px-4 py-4 bg-gray-300 rounded">尋找評審並新增</button>
                </form>
                <form  method="GET" action="{{ route('adjudicator.create',$id) }}">
                    @csrf
                    <button type="submit" class="ml-4 px-4 py-4 bg-gray-300 rounded">新增評審帳號</button>
                </form>
            </div>
        </div>
    </x-slot>

    <script>
        function del_sure(name){
            var conf = confirm("你確定要刪除" + name + "嗎?");

            if (conf){
                return true;
            }else{
                return false;
            }
        }
    </script>

    @if (session()->has('notice'))
        <div class="bg-red-500 text-center">
            <p class="text-gray-200">{{ session()->get('notice') }}</p>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">

        @foreach($adjudicators as $adjudicator)
            <div class="mt-4 flex bg-white overflow-hidden shadow-xl sm:rounded-lg items-center">

                <div class="p-6">
                    <div class="font-semibold text-lg">使用者名稱</div>
                    <div class="font-semibold">{{ $adjudicator->user()->first()->name }}</div>
                </div>
                {{-- <div class="p-6 ">
                    <div class="font-semibold text-lg">Email</div>
                    <div class="font-semibold">{{ $adjudicator->user()->first()->email }}</div>
                </div> --}}


                <div class="">

                    <form action="{{ route('adjudicator.destroy',['id'=>$adjudicator->id,'game_id'=>$id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="text-sm p-2 bg-red-600 text-white rounded ml-4">刪除</button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
