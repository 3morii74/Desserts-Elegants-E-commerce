<x-guest-layout>
    <!-- Main Hero Content -->
    @if(session('success'))
    <div id="successMessage" style="background-color: #d4edda; color: #155724; border-color: #c3e6cb; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;">
        {{ session('success') }}
    </div><script>
        // Hide the success message after 5 seconds
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 1000);
    </script>
@endif
    <div class="container text-center mb-5 max-w-lg px-4 py-60 mx-auto bg-center bg-no-repeat bg-cover md:max-w-none md:text-center" style="background-image: url('/images/marshmallow.jpeg');">
        <div class="mx-auto text-white mt-2 md:text-center lg:text-lg cookie-regular">
            satisfy your sweet cravings with our delicious delights
        </div>
    </div>
    <section class="mt-8 bg-white ">
        <div class="mt-4 text-center">
            <div class="mt-4 lines uppercase letter-spacing">
                <h2 class="text-2xl font-bold text-teal-600">
                    Best Sellers
                </h2>
            </div>
        </div>
        <div class="container w-full px-5 py-6 mx-auto ">
            <div class="flex justify-center">
                <div class="grid lg:grid-cols-4 gap-y-6 px-10 py-12 bg-gray-100 rounded-lg">
                    @foreach ($specials as $menu) <!-- BEST SELLERS -->
                    <div class="max-w-xs mx-4 mb-3 mt-4 rounded-lg shadow-lg hover:shadow ">
                        <img class="w-full h-48" src="{{ Storage::url($menu->image) }}" alt="Image" />
                        <div class="px-6 py-4">
                            <h4 class="mb-3 text-2xl font-semibold tracking-tight text-teal-600 uppercase">
                                <a href="{{ route('categories.show', $menu->id) }}">{{ $menu->name }}</a>
                            </h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="mt-10 bg-white ">
        <div class="mt-4 text-center lines uppercase letter-spacing mb-3">
            <h2 class="text-2xl font-bold text-teal-600">
                Categories
            </h2>
        </div>
        <!--CATEGORIES in HOME PAGE-->
        <div class="container w-full px-5 py-6 mx-auto mb-3">
            <div class="flex justify-center">
                <div class="grid lg:grid-cols-3 gap-y-6 gap-5">
                    @foreach ($specials as $menu)
                    <div class="w-60 h-60 max-w-xs mx-4 mb-5 rounded-full shadow-lg bg-purple-50 hover:shadow">
                        <a href="{{ route('categories.show', $menu->id) }}"><img class="w-48 h-48 rounded-full" src="{{ Storage::url($menu->image) }}" alt="Image" /></a>
                        <a href="{{ route('categories.show', $menu->id) }}">
                            <div class="px-6 py-4">
                                <h4 class="mb-3 text-2xl font-semibold tracking-tight text-teal-600 uppercase text-center">
                                    <a href="{{ route('categories.show', $menu->id) }}">{{ $menu->name }}</a>
                                </h4>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div style="background-color: #f9f9f9; border: 1px solid #ddd; padding: 20px; border-radius: 10px; width: 100%; box-sizing: border-box; text-align: center; font-family: Arial, sans-serif;">
            <p style="color: #333; font-size: 14px; margin-bottom: 20px;">Click the button below to register notifications when a new item is added</p>
            @if ($isSubscipe == 0)

                <button style="background-color: #115e59; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border: none; border-radius: 12px;">
                    <a href="{{route('subscribe')}}">Turn Notifications On
                    </button>
            @elseif ($isSubscipe == 1)
            <button style="background-color: #03e4d5; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border: none; border-radius: 12px;">
                <a href="{{route('unsubscribe')}}">Turn Notifications off
                </button>
            @endif
        </div>
    </section>
</x-guest-layout>
