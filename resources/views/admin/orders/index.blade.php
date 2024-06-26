<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-3">
            <div class="flex justify-end p-2">
                <a href="{{ route('admin.orders.create') }}" class="px-4 py-2 bg-purple-800 hover:bg-purple-500 rounded-lg text-white">New Order</a>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-2 lg:px-3">
                        <div class="overflow-hidden shadow-md sm:rounded-lg">
                            <table class="min-w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Order ID
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Name
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Email
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Phone Number
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Address
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Date
                                        </th>
                                        <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Order Items
                                        </th>

                                        <th scope="col" class="relative py-3 px-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($orders , $items); --}}
                                    @foreach ($orders as $order)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $order->getOrder()['id'] }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $order->getOrder()['name']  }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $order->getOrder()['email'] }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $order->getOrder()['phone_number'] }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $order->getOrder()['address'] }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $order->getOrder()['created_at'] }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            @php
                                            $allItems = collect();
                                            foreach ($items as $item) {
                                            if ($item->getId() == $order->getId()) {
                                            $allItems = $allItems->merge([$item]);
                                            }
                                            }
                                            // $productname =$allItems->product_name;
                                            @endphp

                                            @foreach ($allItems as $item)
                                            - {{ $item->product_name }} ({{$item->quantity}}) : {{(int)$item->price}} L.E <br>
                                            @endforeach
                                        </td>
                                        <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                {{-- <form
                                                        class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-white"
                                                        method="POST"
                                                        action="{{route('admin.orders.done', ['order' => $order->getOrder()['name']id]) }}"
                                                @csrf
                                                <button type="submit">Done</button>
                                                </form> --}}
                                                <form class="px-4 py-2 bg-teal-800 hover:bg-teal-600 rounded-lg text-white" method="POST" action="{{ route('admin.orders.done', ["id" =>$order->getOrder()['id']]) }}">
                                                    @csrf
                                                    {{-- @method('DELETE') --}}
                                                    <button type="submit">Done</button>
                                                </form>
                                                <form class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white" method="POST" action="{{ route('admin.orders.destroy', ["id"=>$order->getOrder()['id']]) }}" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Cancel</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
