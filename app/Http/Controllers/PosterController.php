<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosterRequest;
use App\Http\Requests\UpdatePosterRequest;
use App\Models\Event;
use App\Models\Poster as Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePosterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $poster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model $poster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePosterRequest $request, Model $poster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $poster)
    {
        DB::beginTransaction();
        try {
            $sumPoster = Model::where('event_id', $poster->event_id)->count();

            if ($sumPoster == 1) {
                session()->flash('error', 'Poster tidak dapat dihapus karena hanya tersisa satu poster');
                session()->flash('error2', 'Gagal Menghapus Poster');
                return redirect()->back();
            }

            Storage::delete($poster->poster_path);
            Model::findOrFail($poster->id)->delete();
            DB::commit();
            session()->flash('success', 'Berhasil Menghapus Poster');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Gagal Menghapus Poster');
            return redirect()->back();
        }
    }
}
