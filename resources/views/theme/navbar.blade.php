<nav
    class="flex justify-between bg-white px-8 py-4 rounded-t fixed max-w-3xl w-full inset-x-0 mx-auto bottom-0 border-t-2 z-50">
    <a href="{{ route('app') }}" class="{{ request()->routeIs('app') ? 'active' : null }}">
        <i class="fas fa-xl fa-home text-xl"></i>
        <small class="text-xs block">Home</small>
    </a>
    <a href="{{ route('app.cart') }}"
        class="{{ request()->routeIs('app.cart.*') || request()->routeIs('app.cart') ? 'active' : null }}">
        <i class="fas fa-xl fa-receipt text-xl"></i>
        <small class="text-xs block">Cart</small>
    </a>
    <a href="https://wa.me/{{$setting->no_wa}}?text=Selamat%20Datang%20Di%20{{$setting->name}}%20Ada%20yang%20bisa%20kami%20bantu%20%3F"
        class="">
        <i class="fab fa-xl fa-whatsapp text-xl"></i>
        <small class="text-xs block">Whatsapp</small>
    </a>
    @auth
        <a href="{{ route('app.profile') }}" class="{{ request()->routeIs('app.profile') ? 'active' : null }}">
            <i class="fas fa-xl fa-user text-xl"></i>
            <small class="text-xs block">Profile</small>
        </a>
    @else
        <a href="{{ route('login') }}"
            class="{{ request()->routeIs('login') ? 'active' : (request()->routeIs('register') ? 'active' : null) }}">
            <i class="fas fa-xl fa-sign-in-alt text-xl"></i>
            <small class="text-xs block">Login</small>
        </a>
    @endauth
</nav>
