<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\ThreadResource;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $threads = Thread::published()
            ->withOrder($request->order ?? "node_id", $request->ascending == 'true' ? 'asc' : 'desc')
            ->orderByDesc('pinned_at')
            ->orderByDesc('excellent_at')
            ->orderByDesc('published_at')
            // ->filter($request->all())
            ->paginate($request->get('per_page', 20));

        if ($request->order) {
            $threads->appends(['order' => $request->order]);
        }
        if ($request->ascending) {
            $threads->appends(['ascending' => $request->ascending]);
        }
        return ThreadResource::collection($threads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Thread::class);

        $this->validate($request, [
            'title' => 'required|min:6',
            // 'type' => 'in:markdown,html',
            // 'content.body' => 'required_if:type,html',
            // 'content.markdown' => 'required_if:type,markdown',
            'is_draft' => 'boolean',
        ]);

        return new ThreadResource(Thread::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        $thread->loadMissing('content');
        $thread->update(['cache->views_count' => $thread->cache['views_count'] + 1]);
        return new ThreadResource($thread);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $rules = [
            'title' => 'required|min:6',
            'type' => 'in:markdown,html',
            'content.body' => 'required_if:type,html',
            'content.markdown' => 'required_if:type:markdown',
            'is_draft' => 'boolean',
        ];

        $this->validate($request, $rules);

        $thread->update($request->all());

        return new ThreadResource($thread);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return response('', 204);
    }
}
