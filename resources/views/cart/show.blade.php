<!--CHECKOUT-->
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
                <h3 class="text-xl text-teal-800 font-bold tracking-wider">Shopping Cart | {{ count($items) }} Items
                </h3>
            </div>
            <table class="w-full shadow-inner">
                <thead>
                    <tr class="bg-purple-50 text-teal-800 rounded-md">
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
                                        class="object-cover h-32 w-32 rounded-2xl p-2" alt="image" />
                                </div>
                            </td>
                            <td class="p-4 px-6 text-center text-teal-800 whitespace-nowrap">
                                <div class="flex flex-col items-center justify-center">
                                    <h3>{{ $item['item'] }}</h3>
                                </div>
                            </td>
                            <td class="p-4 px-6 text-center whitespace-nowrap text-teal-800">
                                <div class="flex items-center justify-center">
                                    <form method="POST"
                                        action="{{ route('item.decrement', ['item' => $item['item']]) }}">
                                        @csrf
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="inline-flex w-6 h-6 text-red-600" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>

                                    <input id="qty_{{ $item['id'] }}" type="text" name="qty"
                                        value="{{ $item['quantity'] }}"
                                        class="w-12 text-center text-teal-800 bg-gray-100 outline-none"
                                        onchange="updateSubtotal({{ $item['id'] }})" />

                                    <form method="POST"
                                        action="{{ route('item.increment', ['item' => $item['item']]) }}">
                                        @csrf
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="inline-flex w-6 h-6 text-teal-800" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <td class="p-4 px-6 text-center whitespace-nowrap text-teal-800"
                                id="subtotal_{{ $item['id'] }}">{{ $item['price'] * $item['quantity'] }} L.E</td>
                            <td class="p-4 px-6 text-center text-teal-800 whitespace-nowrap">
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

            <div class="mt-4">
                <div class="py-4 rounded-md shadow">
                    <div class="flex items-center justify-between px-4 py-2 mt-3 border-t-2">
                        <span class="text-2xl text-teal-800 font-bold">Total</span>
                        <span id="total" class="text-2xl text-teal-800 font-bold">{{ $subtotal }} L.E</span>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <form method="POST" action="{{ route('item.checkOut') }}">
                    @csrf
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="items" value="{{ json_encode($items) }}">
                    <button type="submit"
                        class="w-full py-2 text-center text-purple-50 bg-teal-800 rounded-md shadow hover:bg-teal-600">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        </div>
        <a href="{{ route('Home') }}"><button
                class="w-20 py-2 text-center text-purple-50 bg-teal-800 rounded-md shadow hover:bg-teal-600">
                Go Back
            </button></a>
    </div>
</body>

</html>
{{-- <script>
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
        document.getElementById('subtotal_' + itemId).textContent = subtotal.toFixed(0) + ' ' + 'L.E';;

        // Calculate total
        var total = 0;
        @foreach ($items as $item)
            var qty = parseInt(document.getElementById('qty_' + {{ $item['id'] }}).value);
            var itemPrice = parseFloat(document.querySelector('#subtotal_' + {{ $item['id'] }}).parentNode.dataset
                .price);
            total += qty * itemPrice;
        @endforeach
        document.getElementById('total').textContent = total.toFixed(0) + ' ' + 'L.E';
        document.getElementById('total2').textContent = '$' + total.toFixed(0);

    }
</script> --}}
