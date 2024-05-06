<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="grid lg:grid-cols-4 gap-y-6">
            @foreach ($category as $menu)
                <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg">
                    <img class="w-full h-48" src="{{ Storage::url($menu->image) }}" alt="Image" />
                    <div class="px-6 py-4">
                        <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 uppercase">
                            {{ $menu->name }}</h4>
                        <p class="leading-normal text-gray-700">{{ $menu->description }}</p>
                    </div>
                    <form action="{{ route('item.add') }}" method="post">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="price" value="{{ $menu->price }}">
                        <input type="hidden" name="category_id" value="{{ $menu->category_id }}">
                        <div class="flex items-center justify-between p-4">
                            <span class="text-xl text-green-600">${{ $menu->price }}</span>
                            <div class="flex">
                                <input type="number" name="quantity" min="1" max="10" value="1"
                                    class="w-16 px-3 py-1 text-gray-700 rounded-md border border-gray-300 focus:outline-none focus:border-green-500" />
                                <button type="submit"
                                    class="ml-2 px-4 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">Add to
                                    Cart</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

    </div>
</x-guest-layout>
