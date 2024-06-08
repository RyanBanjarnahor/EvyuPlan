@extends('layouts.app_sneat')
@push('css')
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">

    {{-- Trix Editor --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script> --}}
    {{-- <style>
       trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }   
    </style> --}}
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ __($title) }}</h5>
                <div class="card-body">          
                    {{-- <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary mt-2 mb-2 btn-sm">Tambah Data</a>         --}}
                    <div class="table-responsive">                       
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td width="15%">ID</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td width="15%">Name</td>
                                    <td>: {{ $model->name }}</td>
                                </tr>                                                                         
                            </thead>                            
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection
