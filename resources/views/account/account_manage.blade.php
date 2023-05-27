<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semi bold text-xl text-gray-800 leading-tight">
            {{ __('帳戶中心') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="py-6">
            <div class="text-gray-600 text-2xl text-bold">
                評審名單
            </div>
        </div>
        <table class="border-collapse table-fixed w-full text-sm" id="Total">
            <thead>
            <tr>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">評審名稱</th>
                <th class="border-b dark:border-gray-600 font-medium px-4 py-4 text-2xl pl-8 pt-0 pb-3 text-gray-400 dark:text-gray-200 text-center">功能</th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                @foreach($users as $user)
                <tr>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">{{ $user->name }}</td>
                    <td class="border-b border-gray-100 dark:border-gray-700 py-4 text-lg text-center items-center text-gray-500 dark:text-gray-400">
                        <div class="flex justify-center">
                        <a class="text-sm p-2 bg-gray-200 rounded ml-4 bg-blue-400 text-white" href="{{ route('account.edit_page',$user->id) }}">修改資訊</a>

                            {{-- <form method="post" class="" action="{{ route('account.destroy',$user->id) }}">
                                @csrf
                                <button class="text-sm p-2 bg-gray-200 rounded ml-4 bg-red-400 text-white" type="submit">移除帳號</button>
                            </form> --}}
                        </div>
                        
                    </td>
                        
                    </td>
                </tr>
                @endforeach
                
                

            </tbody>
        </table>
    </div>
</x-app-layout>