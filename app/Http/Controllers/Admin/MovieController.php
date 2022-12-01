<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.movies', [
            'movies' => $movies
        ]);
    }

    public function create()
    {
        return view('admin.movies.movie-create');
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $request->validate([
            'title' => 'required|string|min:3', //|regex:/^[a-zA-Z]+$/u
            'small_thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:10540',
            'large_thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:10540',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required',
        ]);
        // if ($request->hasFile('small_thumbnail')) {
        //     $data['small_thumbnail'] = $request->file('small_thumbnail')->store('thumbnail');
        // }
        // if ($request->hasFile('large_thumbnail')) {
        //     $data['large_thumbnail'] = $request->file('large_thumbnail')->store('thumbnail');
        // }
        $smallThumbnail = $request->small_thumbnail;
        $largeThumbnail = $request->large_thumbnail;

        $sthumbnailName = Str::random(10) . $smallThumbnail->getClientOriginalName();
        $lthumbnailName = Str::random(10) . $largeThumbnail->getClientOriginalName();

        $smallThumbnail->storeAs('public/thumbnail', $sthumbnailName);
        $largeThumbnail->storeAs('public/thumbnail', $lthumbnailName);

        $data['small_thumbnail'] = $sthumbnailName;
        $data['large_thumbnail'] = $lthumbnailName;

        Movie::create($data);
        return redirect()->route('admin.movie')->with('success', 'Movie Created');
    }
    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('admin.movies.movie-edit', [
            'movie' => $movie
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $request->validate([
            'title' => 'required|string|min:3', //|regex:/^[a-zA-Z]+$/u
            'small_thumbnail' => 'image|mimes:png,jpg,jpeg|max:10540',
            'large_thumbnail' => 'image|mimes:png,jpg,jpeg|max:10540',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required',
        ]);
        $movie = Movie::find($id);
        if ($request->small_thumbnail) {
            // save new image
            $smallThumbnail = $request->small_thumbnail;
            $sthumbnailName = Str::random(10) . $smallThumbnail->getClientOriginalName();
            $smallThumbnail->storeAs('public/thumbnail/', $sthumbnailName);
            $data['small_thumbnail'] = $sthumbnailName;
            // delete old image
            Storage::delete('public/thumbnail/' . $movie->small_thumbnail);
        }
        if ($request->large_thumbnail) {
            // save new image
            $largeThumbnail = $request->large_thumbnail;
            $sthumbnailName = Str::random(10) . $largeThumbnail->getClientOriginalName();
            $largeThumbnail->storeAs('public/thumbnail/', $sthumbnailName);
            $data['large_thumbnail'] = $sthumbnailName;
            // delete old image
            Storage::delete('public/thumbnail/' . $movie->large_thumbnail);
        }
        $movie->update($data);

        return redirect()->route('admin.movie')->with('success', 'Movie Updated');
    }
    public function destroy($id)
    {
        Movie::find($id)->delete();
        // menghapus data tanpa bisa dipanggil lagi atau permanent
        // if ($movie->small_thumbnail) {
        //     Storage::delete('public/thumbnail/' . $movie->small_thumbnail);
        // }
        // if ($movie->large_thumbnail) {
        //     Storage::delete('public/thumbnail/' . $movie->large_thumbnail);
        // }
        // Movie::destroy($movie->id);
        return redirect('/admin/movie')->with('success', 'Movie Deleted!');
    }
}
