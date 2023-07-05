<aside class="col-span-1 space-y-6 text-gray-600">

    <?php
        $tags       = App\Models\Tag::all();
        $categories = App\Models\Category::all();
        $threads    = App\Models\Thread::all();
    ?>

    <div class="p-4 space-y-4 bg-white shadow">
        <div class="p-1">

            {{-- Start Discusson Button --}}
            <a href="{{ route('threads.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-blue-500 border border-transparent rounded hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25" }}>
                {{ __('Start a new discussion') }}
            </a>

        </div>
    </div>

    {{-- Categories --}}
    <div class="p-4 space-y-4 bg-white shadow">
        <div class="pb-4 mb-4 border-b border-gray-200">
            <h2 class="font-bold uppercase">Categories</h2>
        </div>

        <ul class="space-y-4">
            @foreach ($categories as $category)
                <li class="flex items-center justify-between">
                    {{ $category->name() }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="p-4 space-y-4 bg-white shadow">
        <div class="pb-4 mb-4 border-b border-gray-200">
            <h2 class="font-bold uppercase">Tags</h2>
        </div>

        <ul class="space-y-4 text-gray-500">
            @foreach ($tags as $tag)
                <li class="flex items-center justify-between">
                    <a href="{{ route('threads.tags.index', $tag->slug()) }}" class="p-1 text-xs text-white bg-green-400 rounded">
                        {{ $tag->name() }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>


</aside>
