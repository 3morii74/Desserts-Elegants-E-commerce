<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="text-2xl py-4 px-6 bg-gray-900 text-black text-center font-bold uppercase">
        Book an Appointment
    </div>
    <form class="py-4 px-6" action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="name">
                Name
            </label>
            <input name="name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="name" type="text" placeholder="Enter your name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="email">
                Email
            </label>
            <input name="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" type="email" placeholder="Enter your email">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="phone">
                Phone Number
            </label>
            <input name="phone_number"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="phone" type="tel" placeholder="Enter your phone number">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="message">
                Address
            </label>
            <textarea name="address"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="message" rows="4" placeholder="Enter any additional information"></textarea>
        </div>
        <!-- Display Total Price as Text -->
        <div class="mb-4">
            <p class="block text-gray-700 font-bold mb-2">Total Price: ${{ $totalPrice }}</p>
        </div>
        <!-- Button to Place Order -->
        <div class="flex items-center justify-center mb-4">
            <button
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-6 border border-blue-900 hover:border-transparent rounded"
                type="submit">
                Place order
            </button>
        </div>
        <input type="hidden" name="items" value="{{ json_encode($items) }}">
        <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
    </form>
</div>
