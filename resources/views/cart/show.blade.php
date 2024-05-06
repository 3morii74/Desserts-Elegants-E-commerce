<link href="{{ mix('css/app.css') }}" rel="stylesheet">


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container p-8 mx-auto mt-12">
        <div class="w-full overflow-x-auto">
            <div class="my-2">
                <h3 class="text-xl font-bold tracking-wider">Shopping Cart {{ count($items) }} item</h3>
            </div>
            <table class="w-full shadow-inner">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 font-bold whitespace-nowrap">Image</th>
                        <th class="px-6 py-3 font-bold whitespace-nowrap">Product</th>
                        <th class="px-6 py-3 font-bold whitespace-nowrap">Qty</th>
                        <th class="px-6 py-3 font-bold whitespace-nowrap">Price</th>
                        <th class="px-6 py-3 font-bold whitespace-nowrap">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr data-price="{{ $item['price'] }}">
                            <td>
                                <div class="flex justify-center">
                                    <img src="{{ Storage::url($item['image']) }}"
                                        class="object-cover h-28 w-28 rounded-2xl" alt="image" />
                                </div>
                            </td>
                            <td class="p-4 px-6 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center justify-center">
                                    <h3>{{ $item['item'] }}</h3>
                                </div>
                            </td>
                            <td class="p-4 px-6 text-center whitespace-nowrap">
                                <div>
                                    <button onclick="decrementQuantity({{ $item['id'] }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex w-6 h-6 text-red-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <input id="qty_{{ $item['id'] }}" type="text" name="qty"
                                        value="{{ $item['quantity'] }}"
                                        class="w-12 text-center bg-gray-100 outline-none"
                                        onchange="updateSubtotal({{ $item['id'] }})" />
                                    <button onclick="incrementQuantity({{ $item['id'] }})">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="inline-flex w-6 h-6 text-green-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td id="subtotal_{{ $item['id'] }}">${{ $item['price'] * $item['quantity'] }}</td>
                            <td class="p-4 px-6 text-center whitespace-nowrap">
                                <form method="POST" action="{{ route('item.delete', ['item' => $item['item']]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>



                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="lg:w-2/4">
                <div class="mt-4">
                    <div class="px-4 py-4 rounded-md">
                        <label for="coupon code" class="font-semibold text-gray-600">Coupon Code</label>
                        <input type="text" placeholder="coupon code" value=""
                            class="
                  w-full
                  px-2
                  py-2
                  border border-blue-600
                  rounded-md
                  outline-none
                " />
                        {{-- <span class="block text-green-600">Coupon code applied successfully</span> --}}
                        <button
                            class="
                  px-6
                  py-2
                  mt-2
                  text-sm text-indigo-100
                  bg-indigo-600
                  rounded-md
                  hover:bg-indigo-700
                ">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="py-4 rounded-md shadow">
                    <h3 class="text-xl font-bold text-blue-600">Order Summary</h3>
                    <div class="flex justify-between px-4">
                        <span class="font-bold">Subtotal</span>
                        <span id="total">${{ $subtotal }}</span>
                    </div>
                    <div class="flex justify-between px-4">
                        <span class="font-bold">Discount</span>
                        <span class="font-bold text-red-600">- $0.00</span>
                    </div>
                    <div class="flex justify-between px-4">
                        <span class="font-bold">Sales Tax</span>
                        <span class="font-bold">$0.00</span>
                    </div>
                    <div
                        class="
                flex
                items-center
                justify-between
                px-4
                py-2
                mt-3
                border-t-2
              ">
                        <span class="text-xl font-bold">Total</span>
                        <span id="total2" class="text-2xl font-bold">${{ $subtotal }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <form method="POST" action="{{ route('item.checkOut') }}">
                    @csrf
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="items" value="{{ json_encode($items) }}">
                    <button type="submit"
                        class="w-full py-2 text-center text-white bg-blue-500 rounded-md shadow hover:bg-blue-600">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    function decrementQuantity(itemId) {
        var input = document.getElementById('qty_' + itemId);
        var currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            updateSubtotal(itemId);
        }
    }

    function incrementQuantity(itemId) {
        var input = document.getElementById('qty_' + itemId);
        var currentValue = parseInt(input.value);
        input.value = currentValue + 1;
        updateSubtotal(itemId);
    }

    function updateSubtotal(itemId) {
        var quantity = parseInt(document.getElementById('qty_' + itemId).value);
        var price = parseFloat(document.querySelector('#subtotal_' + itemId).parentNode.dataset.price);
        var subtotal = quantity * price;
        document.getElementById('subtotal_' + itemId).textContent = '$' + subtotal.toFixed(2);

        // Calculate total
        var total = 0;
        @foreach ($items as $item)
            var qty = parseInt(document.getElementById('qty_' + {{ $item['id'] }}).value);
            var itemPrice = parseFloat(document.querySelector('#subtotal_' + {{ $item['id'] }}).parentNode.dataset
                .price);
            total += qty * itemPrice;
        @endforeach
        document.getElementById('total').textContent = '$' + total.toFixed(2);
        document.getElementById('total2').textContent = '$' + total.toFixed(2);

    }
</script>
