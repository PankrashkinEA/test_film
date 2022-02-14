<?php

namespace App\Http\Controllers;

use App\Filters\ActorFilter;
use App\Http\Requests\FilmRequest;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $result = QueryBuilder::for(Film::class)
            ->allowedSorts('title')
            ->allowedFilters([
                'genre_id',
                AllowedFilter::custom('actors', new ActorFilter())])
            ->get();
        return response(FilmResource::collection($result));
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

        $film = Film::create(request()->all());
        return response()->json(['New film created', new FilmResource($film)],200);
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
        return response()->json([new FilmResource($film)],200);
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
        $film->update(request()->all());
        return response()->json(['Film updated.', new FilmResource($film)],200);
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
        response()->json('film deleted', 200);
    }
}
