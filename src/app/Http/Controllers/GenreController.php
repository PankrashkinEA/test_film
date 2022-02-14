<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::with('films')->get();
        return response(GenreResource::collection($genres));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
    {
        $validated = $request->validated();
        $genre = Genre::create(request()->all());
        return response()->json(['New genre created', new GenreResource($genre)],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        if (is_null($genre)) {
            return response()->json('not found', 404);
        }
        return response()->json([new GenreResource($genre)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, Genre $genre)
    {
        $validated = $request->validated();
        $genre->update(request()->all());
        return response()->json(['Genre updated.', new GenreResource($genre)],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        response()->json('genre deleted', 204);
    }
}
