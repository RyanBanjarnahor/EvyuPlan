<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryTypeRequest;
use App\Http\Requests\UpdateCategoryTypeRequest;
use App\Models\CategoryType as Model;
use Illuminate\Support\Facades\DB;

class CategoryTypeController extends Controller
{
    private $viewIndex = 'categoryType_index';
    private $viewCreate = 'categoryType_form';
    private $viewEdit = 'categoryType_form';
    private $viewShow = 'categoryType_show';
    private $routePrefix = 'admin.categoryType';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.' . $this->viewIndex, [
            'models' => Model::latest()->get(),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Tipe Kategori'
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
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA TIPE KATEGORI',            
        ];
        return view('admin.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryTypeRequest $request)
    {        
        DB::beginTransaction();
        try {

            $categoryTypeStore = Model::create([
                'name' => $request['name'],               
            ]);           

            DB::commit();
            session()->flash('success', 'Tipe Kategori Berhasil Ditambahkan');
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            session()->flash('error2', 'Tipe Kategori Gagal Ditambahkan');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Model $categoryType)
    {
        return view('admin.' . $this->viewShow, [
            'model' => Model::findOrFail($categoryType->id),
            'title' => 'Detail Data Tipe Kategori',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model $categoryType)
    {
        $userEdit = Model::findOrFail($categoryType->id);

        $data = [
            'model' => $userEdit,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $categoryType->id],
            'button' => 'UPDATE',
            'title' => 'FORM DATA EDIT TIPE KATEGORI',
        ];
        return view('admin.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryTypeRequest $request, string $categoryType)
    {        
        DB::beginTransaction();
        try {

            $categoryTypeUpdate = [
                'name' => $request['name'],               
            ];

            $updateUser = Model::findOrFail($categoryType);        
            $updateUser->update($categoryTypeUpdate);            

            DB::commit();
            session()->flash('success', 'Tipe Kategori Berhasil Diupdate');
            return back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            session()->flash('error2', 'Tipe Kategori Gagal Diupdate');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $categoryType)
    {
        DB::beginTransaction();
        try {
            Model::findOrFail($categoryType->id)->delete();           
            DB::commit();
            session()->flash('success', 'Tipe Kategori Berhasil Dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();            
            session()->flash('error2', 'Tipe Kategori Gagal Dihapus');
            return redirect()->back();
        }
    }
}
