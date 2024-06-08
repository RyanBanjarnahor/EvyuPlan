<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventApprovetRequest;
use App\Http\Requests\StoreEventFromEventRequestRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use \App\Models\Event as Model;
use App\Models\Event;
use App\Models\EventRequest;
use App\Models\Poster;
use App\Models\User;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    private $viewIndex = 'event_index';
    private $viewCreate = 'event_form';
    private $viewEdit = 'event_form';
    private $viewShow = 'event_show';
    private $routePrefix = 'event';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.' . $this->viewIndex, [
            'models' => Model::latest()->get(),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Events'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => 'admin.' . $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA EVENT',
            'categories' => \App\Models\CategoryType::pluck('name', 'id'),
            'penyelenggara' => User::select(DB::raw('CONCAT(name, " - ", id) as name, id'))->pluck('name', 'id'),
        ];
        return view('admin.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $event = Model::create([
                'title' => $request['title'],
                'applicant' => $request['user_id'],
                'description' => $request['description'],
                'location' => $request['location'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ]);

            if ($request->has('poster') && is_array($request->poster)) {
                foreach ($request->file('poster') as $index => $file) {
                    Poster::create([
                        'event_id' => $event->id,
                        'poster_path' => $file->store('public/' . $request['title']),
                    ]);
                }
            }

            if ($request->has('categories') && is_array($request->categories)) {
                foreach ($request->categories as $index => $file) {
                    Category::create([
                        'event_id' => $event->id,
                        'category_type_id' => $file,
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Event Berhasil Ditambahkan');
            return back();
        } catch (\Exception $e) {
            dd($e); 
            DB::rollback();
            session()->flash('error2', 'Event Gagal Ditambahkan');
            flash('Data gagal ditambahkan')->error();
            return back();
        }
    }

    public function approve(StoreEventApprovetRequest $request)
    {        
        // dd($request->poster);
        DB::beginTransaction();
        try {

            $event = Model::create([
                'title' => $request['title'],
                'applicant' => $request['user_id'],
                'description' => $request['description'],
                'location' => $request['location'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ]);  
            
            EventRequest::findOrFail($request['id'])->update([
                'status' => 'revision',
            ]);

            DB::commit();
            session()->flash('success', 'Event Berhasil Ditambahkan');
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error2', 'Event Gagal Ditambahkan');
            flash('Data gagal ditambahkan')->error();
            return back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Model $event)
    {
        return view('admin.' . $this->viewShow, [
            'model' => Model::findOrFail($event->id),
            'title' => 'Detail Data Event',   
            'posters' => Poster::where('event_id', $event->id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model $event)
    {
        $event = Model::findOrFail($event->id);
        // If you want to update the model with the parsed dates
        $event->start_date = \Carbon\Carbon::parse($event->start_date)->toDateString();
        $event->end_date = \Carbon\Carbon::parse($event->end_date)->toDateString();

        $data = [
            'model' => $event,
            'method' => 'PUT',
            'route' => ['admin.' . $this->routePrefix . '.update', $event->id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA EVENT EDIT',
            'posters' => Poster::where('event_id', $event->id)->get(),
            'categories' => \App\Models\CategoryType::pluck('name', 'id'),
            'penyelenggara' => User::select(DB::raw('CONCAT(name, " - ", id) as name, id'))->pluck('name', 'id'),
        ];
        return view('admin.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Model $event)
    {
        // dd($request->poster);
        DB::beginTransaction();
        try {
            $eventUpdate = [
                'title' => $request['title'],
                'description' => $request['description'],
                'location' => $request['location'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ];
            $model = Model::findOrFail($event->id);

            
            if ($request['title'] != $model->title) {
                $posters = Poster::where('event_id', $event->id)->get();
            
                // Create a new directory for the updated title
                $newDirectory = "public/{$request['title']}";
                Storage::makeDirectory($newDirectory);                            
                foreach ($posters as $poster) {                    
                    // Build the new path for each poster in the updated directory
                    $newPosterPath = "{$newDirectory}/" . pathinfo($poster->poster_path, PATHINFO_BASENAME);
                    
                    // Move the poster to the new directory
                    Storage::move($poster->poster_path, $newPosterPath);
            
                    // Update the poster_path in the database
                    $poster->update(['poster_path' => $newPosterPath]);
                }
                Storage::deleteDirectory("public/{$model->title}");
            }

            $posters = Poster::where('event_id', $event->id)->get();
            if ($posters->count() < 3) {
                if ($request->has('poster') && is_array($request->poster)) {
                    foreach ($request->file('poster') as $index => $file) {
                        if ($posters->count() < 3) {
                            Poster::create([
                                'event_id' => $event->id,
                                'poster_path' => $file->store('public/' . $request['title']),
                            ]);
                            $posters = Poster::where('event_id', $event->id)->get();
                        } else {
                            DB::rollback();
                            session()->flash('error', 'Poster gagal ditambahkan, maksimal 3 poster');
                            session()->flash('error2', 'Poster gagal ditambahkan');
                            return back();
                        }
                    }
                }
            }

            $model->update($eventUpdate);
            $model->save();
            DB::commit();
            session()->flash('success', 'Event Berhasil Diupdate');
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            session()->flash('error2', 'Event gagal diupdate');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $event)
    {
        DB::beginTransaction();
        try {
            Model::findOrFail($event->id)->delete();
            Storage::deleteDirectory("public/{$event->title}");
            DB::commit();
            session()->flash('success', 'Event Berhasil Dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Event Gagal Dihapus');
            return redirect()->back();
        }
    }

    public function search(Request $request)
{
    $query = $request->input('query');

    // Melakukan pencarian pada model Event
    $events = Event::with('posters')->search($query)->get();

    // Handle dan return hasil pencarian bersama dengan satu poster
    return response()->json(['events' => $events]);
}

    public function myEvent()
    {
        $events = Event::where('applicant', Auth::user()->id)->get();
        return view('user.event_index', ['models' => $events, 'routePrefix' => $this->routePrefix,]);
    }
}
