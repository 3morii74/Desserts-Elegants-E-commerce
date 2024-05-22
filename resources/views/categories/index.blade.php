<!-- CATEGORIES PAGE -->
<x-guest-layout>
    <div class="container w-1\/2 px-10 py-6 mx-auto">
        <div class="grid lg:grid-cols-3 gap-y-6">
            @foreach ($categories as $category)
            <div class="w-1\/2 max-w-xs mx-4 mb-2  shadow-lg">
                <img class="w-full h-auto max-w-xs" src="{{ Storage::url($category->getCategory()['image']) }}" alt="Image" />
                <div class="px-6 py-4">
                    <a href="{{ route('categories.show', $category->getCategory()['id']) }}">
                        <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 hover:text-green-400 uppercase">
                            {{ $category->getCategory()['name'] }}
                        </h4>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</x-guest-layout>
