<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActorRequest;
use App\Http\Resources\ActorResource;
use Illuminate\Http\Request;
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

        if($validated->fails()){
            return response()->json($validated->errors());
        }

        $film = Actor::create([
            'name' => $request->name
        ]);

        return response()->json(['New actor created', new ActorResource($film)]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
