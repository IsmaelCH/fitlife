<nav class="bg-white shadow mb-6">
    <div class="container mx-auto flex justify-between items-center py-4">
        <a href="{{ url('/') }}" class="font-bold text-xl">FitLife</a>
        <div class="space-x-4">
            <a href="{{ route('news.index') }}">News</a>
            <a href="{{ route('faq.index') }}">FAQ</a>
            <a href="{{ route('contact.form') }}">Contact</a>

            @auth
                <a href="{{ route('profiles.show', auth()->user()) }}">My Profile</a>
                @can('admin')
                    <a href="{{ route('admin.users.index') }}">Admin</a>
                @endcan
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
