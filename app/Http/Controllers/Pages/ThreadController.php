<?php

namespace App\Http\Controllers\Pages;

use App\Models\Tag;
use App\Models\Thread;
use App\Models\Category;
use App\Jobs\CreateThread;
use App\Jobs\UpdateThread;
use App\Policies\ThreadPolicy;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\ThreadStoreRequest;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Sentiment\Analyzer;


class ThreadController extends Controller
{
    public function __construct()
    {
        return $this->middleware([Authenticate::class, EnsureEmailIsVerified::class])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.threads.index', [
            'threads'   => Thread::orderBy('id', 'desc')->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.threads.create', [
            'categories'    => Category::all(),
            'tags'          => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadStoreRequest $request)
    {
        $analyzer=new Analyzer();
        $title=$analyzer->getSentiment($request->title);
        $description=$analyzer->getSentiment(strip_tags( $request->body ));

        if($title['neg']<0.5 && $description['neg']<0.5)
        {
            $this->dispatchSync(CreateThread::fromRequest($request));
            return redirect()->route('threads.index')->with('success', 'Thread Created!');
        }
        else
        {
            return redirect()->route('threads.index')->with('error', 'There is negativity in the thread you are trying to post!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Thread $thread)
    {
        $expireAt = now()->addHours(1);

        views($thread)
            ->cooldown($expireAt)
            ->record();

        return view('pages.threads.show', compact('thread', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        $this->authorize(ThreadPolicy::UPDATE, $thread);

        $oldTags = $thread->tags()->pluck('id')->toArray();
        $selectedCategory = $thread->category;

        return view('pages.threads.edit', [
            'thread'            => $thread,
            'tags'              => Tag::all(),
            'oldTags'           => $oldTags,
            'categories'        => Category::all(),
            'selectedCategory'  => $selectedCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadStoreRequest $request, Thread $thread)
    {
        $analyzer=new Analyzer();
        $title=$analyzer->getSentiment($request->title);
        $description=$analyzer->getSentiment( strip_tags( $request->body ));

        if($title['neg']<0.5 && $description['neg']<0.5)
        {
            $this->authorize(ThreadPolicy::UPDATE, $thread);
            $this->dispatchSync(UpdateThread::fromRequest( $thread, $request ));
            return redirect()->route('threads.index')->with('success', 'Thread Updated!');
        }
        else
        {
            return redirect()->route('threads.index')->with('error', 'Update has negativity!');
        }

    }
}
