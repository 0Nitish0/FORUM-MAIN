<x-guest-layout>
    <main class="wrapper">
        <section class="grid grid-cols-4 gap-8 mt-8">

            <x-partials.sidenav />

            <div class="flex flex-col col-span-3 gap-y-4">
                <a href="{{ route('threads.index') }}">
                    <img src="{{ asset('img/bg/posts.png') }}">
                </a>
            </div>
        </section>
    </main>
</x-guest-layout>
