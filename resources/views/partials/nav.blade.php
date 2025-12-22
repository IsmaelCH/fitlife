<nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50 transition-colors duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="font-bold text-xl tracking-tight text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300 transition-colors">FitLife</a>
        <div class="flex items-center space-x-6 text-sm font-medium text-gray-600 dark:text-gray-300">
            <a href="{{ route('news.index') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">News</a>
            <a href="{{ route('faq.index') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">FAQ</a>
            <a href="{{ route('contact.form') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">Contact</a>

            @auth
                <a href="{{ route('profiles.show', auth()->user()) }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">My Profile</a>
                @can('admin')
                    <a href="{{ route('admin.users.index') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">Admin</a>
                    <a href="{{ route('admin.contacts.index') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">Contacts</a>

                @endcan
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-gray-900 dark:hover:text-white transition-colors">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">Login</a>
                <a href="{{ route('register') }}" class="bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">Register</a>
            @endauth

            <button
                type="button"
                x-data="{
                    theme: localStorage.getItem('color-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
                    toggle() {
                        this.theme = this.theme === 'dark' ? 'light' : 'dark';
                        localStorage.setItem('color-theme', this.theme);
                        if (this.theme === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    }
                }"
                @click="toggle()"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors"
            >
                <svg x-show="theme === 'dark'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg x-show="theme === 'light'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    </div>
</nav>
