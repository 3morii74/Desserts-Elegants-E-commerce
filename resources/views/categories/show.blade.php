<!-- ITEMS IN CATEGORY -->

<x-guest-layout>
    @if(session('success'))
    <div id="successMessage" style="background-color: #d4edda; color: #155724; border-color: #c3e6cb; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;">
        {{ session('success') }}
    </div><script>
        // Hide the success message after 5 seconds
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 2000);
    </script>
@endif
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="grid lg:grid-cols-4 gap-y-6">
            @foreach ($category as $menu)
            <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg  bg-purple-50">
                <img class="mx-auto mt-6 w-48 h-48 rounded" src="{{ Storage::url($menu->image) }}" alt="Image" />
                <div class="px-6 py-4">
                    <h4 class="mb-3 text-l font-semibold tracking-tight text-teal-800 uppercase">
                        {{ $menu->name }}
                    </h4>
                    <p class="leading-normal text-gray-700 text-sm">{{ $menu->description }}</p>
                </div>
                <form action="{{ route('item.add') }}" method="post">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <input type="hidden" name="price" value="{{ $menu->price }}">
                    <input type="hidden" name="category_id" value="{{ $menu->category_id }}">
                    <div class="flex items-center justify-between p-4">
                        <span class="text-l text-teal-800">{{ $menu->price }} L.E</span>
                    </div>
                    <div class="flex items-center justify-between p-4">
                        <input type="number" name="quantity" min="1" max="10" value="1" class="w-16 px-3 py-2 text-gray-700 rounded-md border border-gray-300 focus:outline-none focus:border-green-500" />
                        <button type="submit" class="ml-2 px-3 py-2 bg-teal-800 text-white rounded-md hover:bg-teal-600">Add to
                            Cart
                        </button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>

    </div>
</x-guest-layout>
