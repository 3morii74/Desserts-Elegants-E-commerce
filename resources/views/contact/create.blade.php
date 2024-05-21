<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<div style="background-image: url('/images/bg-form.jpeg'); background-size: cover; background-repeat: no-repeat;">
    <section class="form-container">
        <div class="w-full flex flex-col items-center justify-center px-10  py-8 mx-auto md:h-screen lg:py-0">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <div class="w-full bg-purple-50 rounded-lg px-10 shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-l text-center font-bold leading-tight tracking-tight text-teal-800 md:text-xl dark:text-white uppercase">
                        Create an account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route('register.store') }}" method="POST">
                        {!! csrf_field() !!}
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-teal-800 dark:text-white">Name</label>
                            <input type="text" name="name" id="name" class="bg-white border border-teal-800 text-purple-800 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" required="">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-teal-800 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-white border border-teal-800 text-purple-800 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-teal-800 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-white border border-teal-800 text-purple-800 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <button type="submit" class="mx-auto w-full text-purple-50 bg-teal-800 hover:bg-teal-600 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create Account</button>
                        <p class="text-sm font-light text-purple-800 dark:text-gray-400">
                            Already have an account? <a href="{{ route('contact.login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
