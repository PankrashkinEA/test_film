<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Http\Resources\FilmResource;
use App\Models\Film;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::with('actors')->get();
        return response(FilmResource::collection($films));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilmRequest $request)
    {
        $validated = $request->validated();

        if($validated->fails()){
            return response()->json($validated->errors());
        }

        $film = Film::create(request()->all());

        return response()->json(['New film created', new FilmResource($film)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);
        if (is_null($film)) {
            return response()->json('not found', 404);
        }
        return response()->json([new FilmResource($film)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilmRequest $request, Film $film)
    {
        $validated = $request->validated();

        if($validated->fails()){
            return response()->json($validated->errors());
        }

        $film->title = $request->title;
        $film->description = $request->description;
        $film->genre_id = $request->genre_id;
        $film->year = $request->year;
        $film->save();

        return response()->json(['Film updated.', new FilmResource($film)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Film $film)
    {
        $film->delete();
        response()->json('film deleted', 204);
    }
}
