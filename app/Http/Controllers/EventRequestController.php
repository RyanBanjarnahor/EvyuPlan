<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequestRequest;
use App\Http\Requests\UpdateEventRequestRequest;
use App\Http\Requests\UploadPosterRequest;
use App\Models\Category;
use App\Models\Event;
use \App\Models\EventRequest as Model;
use App\Models\Poster;
use App\Models\User;
use Carbon\Carbon;
use COM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventRequestController extends Controller
{
    private $viewIndex = 'eventRequest_index';
    private $viewCreate = 'eventRequest_form';
    private $viewEdit = 'eventRequest_form';
    private $viewShow = 'eventRequest_show';
    private $routePrefix = 'eventRequest';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.' . $this->viewIndex, [
            'models' => Model::latest()->get(),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Event Requests'
        ]);
    }

    public function indexUser()
    {
        return view('user.' . $this->viewIndex, [
            'models' => Model::latest()->get(),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Event Requests'
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
            'title' => 'FORM DATA EVENT REQUEST',
            'penyelenggara' => User::select(DB::raw('CONCAT(name, " - ", id) as name, id'))->pluck('name', 'id'),
            'categories' => \App\Models\CategoryType::pluck('name', 'id'),
        ];
        return view('admin.' . $this->viewCreate, $data);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function createFromUser()
    {
        
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA EVENT REQUEST',    
            'categories' => \App\Models\CategoryType::pluck('name', 'id'),        
        ];
        return view('user.eventRequest_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequestRequest $request)
    {
        DB::beginTransaction();
        try {

            $eventRequest = Model::create([
                'user_id' => $request['user_id'],
                'date_submission' => Carbon::now(),
                'status' => 'pending',
                'title' => $request['title'],
                'comment' => $request['comment'],
                'description' => $request['description'],
                'location' => $request['location'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ]);

            DB::commit();
            session()->flash('success', 'EventRequest Berhasil Ditambahkan');
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            session()->flash('error2', 'EventRequest Gagal Ditambahkan');
            flash('Data gagal ditambahkan')->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $eventRequest)
    {
        $eventRequestShow = Model::findOrFail($eventRequest->id);
        $eventRequestShow->date_submission = \Carbon\Carbon::parse($eventRequestShow->date_submission)->toDateString();
        $eventRequestShow->start_date = \Carbon\Carbon::parse($eventRequestShow->start_date)->toDateString();
        $eventRequestShow->end_date = \Carbon\Carbon::parse($eventRequestShow->end_date)->toDateString();
        
        return view('admin.' . $this->viewShow, [
            'model' => $eventRequestShow,
            'title' => 'Detail Data Event Request',               
        ]);
    }


    public function showFromUser(Model $eventRequest)
    {
        $eventRequestShow = Model::findOrFail($eventRequest->id);
        $eventRequestShow->date_submission = \Carbon\Carbon::parse($eventRequestShow->date_submission)->toDateString();
        $eventRequestShow->start_date = \Carbon\Carbon::parse($eventRequestShow->start_date)->toDateString();
        $eventRequestShow->end_date = \Carbon\Carbon::parse($eventRequestShow->end_date)->toDateString();
        
        return view('user.' . $this->viewShow, [
            'model' => $eventRequestShow,
            'title' => 'Detail Data Event Request',               
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model $eventRequest)
    {
        $eventRequest = Model::findOrFail($eventRequest->id);
        // If you want to update the model with the parsed dates
        $eventRequest->date_submission = \Carbon\Carbon::parse($eventRequest->date_submission)->toDateString();
        $eventRequest->start_date = \Carbon\Carbon::parse($eventRequest->start_date)->toDateString();
        $eventRequest->end_date = \Carbon\Carbon::parse($eventRequest->end_date)->toDateString();  
        
        $eventIsMade = Event::where('title', $eventRequest->title)->exists();

        $data = [
            'model' => $eventRequest,
            'method' => 'PUT',
            'route' => ['admin.' . $this->routePrefix . '.update', $eventRequest->id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA EVENT REQUEST EDIT',            
            'penyelenggara' => User::select(DB::raw('CONCAT(name, " - ", id) as name, id'))->pluck('name', 'id'),
            'eventIsMade' => $eventIsMade ?? null,
            'categories' => \App\Models\CategoryType::pluck('name', 'id'),
        ];
        return view('admin.' . $this->viewEdit, $data);
    }

    public function editFromUser(Model $eventRequest)
    {        
        $eventRequest = Model::find($eventRequest->id);        
        // If you want to update the model with the parsed dates
        $eventRequest->date_submission = \Carbon\Carbon::parse($eventRequest->date_submission)->toDateString();
        $eventRequest->start_date = \Carbon\Carbon::parse($eventRequest->start_date)->toDateString();
        $eventRequest->end_date = \Carbon\Carbon::parse($eventRequest->end_date)->toDateString();  

        $data = [
            'model' => $eventRequest,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $eventRequest->id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA EVENT REQUEST EDIT',            
            'penyelenggara' => User::select(DB::raw('CONCAT(name, " - ", id) as name, id'))->pluck('name', 'id'),
            'categories' => \App\Models\CategoryType::pluck('name', 'id'),
        ];
        return view('user.eventRequest_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequestRequest $request, Model $eventRequest)
    {
        DB::beginTransaction();
        try {

            $eventRequestUpdate = [
                'user_id' => $request['user_id'],
                'date_submission' => Carbon::now(),                
                'status' => $request['status'],
                'title' => $request['title'],
                'comment' => $request['comment'],
                'description' => $request['description'],
                'location' => $request['location'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ];
            $model = Model::findOrFail($eventRequest->id);
            $model->update($eventRequestUpdate);

            DB::commit();
            session()->flash('success', 'EventRequest Berhasil Diupdate');
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            session()->flash('error2', 'EventRequest Gagal Diupdate');
            flash('Data gagal ditambahkan')->error();
            return back();
        }
    }

    public function updateFromUser(UpdateEventRequestRequest $request, Model $eventRequest)
    {
        DB::beginTransaction();
        try {

            $eventRequestUpdate = [
                'user_id' => $request['user_id'],
                'date_submission' => Carbon::now(),                
                'status' => $request['status'],
                'title' => $request['title'],
                'comment' => $request['comment'],
                'description' => $request['description'],
                'location' => $request['location'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ];
            $model = Model::findOrFail($eventRequest->id);
            $model->update($eventRequestUpdate);

            DB::commit();
            session()->flash('success', 'EventRequest Berhasil Diupdate');
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            session()->flash('error2', 'EventRequest Gagal Diupdate');
            flash('Data gagal ditambahkan')->error();
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $eventRequest)
    {
        DB::beginTransaction();
        try {
            Model::findOrFail($eventRequest->id)->delete();            
            DB::commit();
            session()->flash('success', 'Event Request Berhasil Dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'EventRequest Gagal Dihapus');
            return redirect()->back();
        }
    }

    public function proofPayment(Request $request ,Model $eventRequest)
    {    
        DB::beginTransaction();
        try {
            $eventRequest->update([                
                'proof_payment' => $request->proof_payment->store('public/' . $eventRequest->title),
                'status' => 'pending',
            ]);
            DB::commit();
            session()->flash('success', 'Bukti Pembayaran Berhasil Diupload');
            return redirect()->route('eventRequest.index');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Bukti Pembayaran Gagal Diupload');
            return redirect()->back();
        }
    }

    public function uploadPoster(UploadPosterRequest $request ,Model $eventRequest)
    {                   
        DB::beginTransaction();
        try {
            $event = Event::where('title', $eventRequest->title)->first();     

           $eventRequest->update([                
                'status' => 'approved',
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
            session()->flash('success', 'Upload Poster Berhasil Diupload');
            return redirect()->route('eventRequest.index');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', $e);
            session()->flash('error2', 'Upload Poster Gagal Diupload');
            return redirect()->back();
        }
    }
}
