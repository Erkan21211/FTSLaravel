<nav class="bg-gray-800 text-white border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-white" />
                </a>
            </div>

            <!-- Burger Menu Button -->
            <div class="md:hidden flex items-center">
                <button
                    class="text-white focus:outline-none"
                    id="burgerButton"
                    onclick="toggleMenu()"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

            <!-- Full Menu -->
            <div
                id="navMenu"
                class="hidden md:flex md:flex-row md:space-x-4 items-center"
            >
                <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                    {{ __('Home') }}
                </x-nav-link>
                <x-nav-link :href="route('reizen.guest')" :active="request()->routeIs('reizen.guest')">
                    {{ __('Reizen') }}
                </x-nav-link>
                <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                    {{ __('Contact') }}
                </x-nav-link>
                @auth
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profiel') }}
                    </x-nav-link>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white">Logout</button>
                    </form>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log In') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden flex flex-col space-y-2 bg-gray-700 p-4">
        <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
            {{ __('Home') }}
        </x-nav-link>
        <x-nav-link :href="route('reizen.guest')" :active="request()->routeIs('reizen.guest')">
            {{ __('Reizen') }}
        </x-nav-link>
        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
            {{ __('Contact') }}
        </x-nav-link>
        @auth
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('Profiel') }}
            </x-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-300 hover:text-white">Logout</button>
            </form>
        @else
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Log In') }}
            </x-nav-link>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Register') }}
            </x-nav-link>
        @endauth
    </div>
</nav>

<script>
    function toggleMenu() {
        const mobileMenu = document.getElementById("mobileMenu");
        mobileMenu.classList.toggle("hidden");
    }
</script>
