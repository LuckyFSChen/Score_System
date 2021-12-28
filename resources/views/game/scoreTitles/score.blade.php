<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h4 class="font-semi bold text-2xl text-gray-800 leading-tight">
                {{ __('比賽列表 > 成績欄位') }}

            </h4>
            <form method="post" action="{{ route("scoreTitles.store",['game_id' => $id]) }}">
                @csrf
                <input class="ml-6 px-2 py-2 rounded" type="text" name="name"  placeholder="請輸入欄位名稱..." value="" />
                <input class="ml-6 px-2 py-2 rounded" type="number" name="percentage" placeholder="請輸入百分比...(不含%)" value="" />(%)
                <button class="ml-4 px-4 py-4 bg-gray-200 rounded" type="submit">
                    新增成績欄位
                </button>
            </form>

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

    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 py-2">

        @foreach($scores as $score)
            <div class="mt-4 flex bg-white overflow-hidden shadow-xl sm:rounded-lg items-center">
                <div class="p-6">
                    <p class="font-sans ">{{ $score->name }}</p>
                    <p class="font-sans ">{{ $score->percentage }}%</p>
                </div>
                <div class="">

                    <form action="{{ route('scoreTitles.destroy',$score->id) }}" method="post">
                        @csrf
                        @method('delete')

                        <a class="text-sm p-2 bg-gray-500 rounded ml-4" href="{{ route('scoreTitles.edit',['game_id' => $id , 'id' => $score->id]) }}">修改</a>
                        <button type="submit" class="text-sm p-2 bg-red-600 rounded ml-4">刪除</button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
