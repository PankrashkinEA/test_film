<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActorRequest;
use App\Http\Resources\ActorResource;
use App\Models\Actor;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actors = Actor::with('films')->get();
        return response(ActorResource::collection($actors));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {
        $validated = $request->validated();
        $actor = Actor::create(request()->all());
        return response()->json(['New actor created', new ActorResource($actor)],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Actor::find($id);
        if (is_null($actor)) {
            return response()->json('not found', 404);
        }
        return response()->json([new ActorResource($actor)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActorRequest $request, Actor $actor)
    {
        $validated = $request->validated();
        $actor->update(request()->all());
        return response()->json(['Actor updated.', new ActorResource($actor)],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();
        response()->json('actor deleted', 204);
    }
}
