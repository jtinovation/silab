<x-slot name="content">
    <!-- Authentication -->
    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <button type="submit" class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            {{ __('Log Out') }}
        </button>
    </form>
</x-slot>