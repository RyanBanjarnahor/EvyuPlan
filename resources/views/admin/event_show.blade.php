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
                                    <td>Title</td>
                                    <td>: {{ $model->title }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>: {{ $model->description }}</td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td>: {{ $model->location }}</td>
                                </tr>
                                <tr>
                                    <td>Start Date</td>
                                    <td>: {{ $model->start_date }}</td> 
                                </tr>
                                <tr>
                                    <td>End Date</td>
                                    <td>: {{ $model->end_date }}</td>
                                </tr>                                                               
                            </thead>                            
                        </table>
                          {{-- poster --}}
                     @isset($posters)
                     @if ($posters->count() > 0)
                     <label for="end_date" class="form-label mt-4 pl-4">Poster Event</label>
                     <div class="card mb-3">
                         <div class="card-body">
                             <div class="row">                                                                 
                                 @foreach ($posters as $poster)
                                     <div class="col-md-3 position-relative">
                                         <form action="{{ route('admin.poster.destroy', $poster) }}" method="POST"
                                             class="delete-form">
                                             @csrf
                                             @method('DELETE')
                                             <img src="{{ \Storage::url($model->name . $poster->poster_path) }}"
                                                 style="width: 100%;" alt="">
                                             <button type="button"
                                                 class="btn btn-danger position-absolute top-0 end-0 delete-button">X</button>
                                         </form>
                                     </div>
                                 @endforeach
                             </div>
                         </div>
                     </div>                                                                      
                     @endif
                 @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('datatables')
    <script>
        // Ambil semua tombol hapus
        const deleteButtons = document.querySelectorAll('.delete-button');

        // Tambahkan event listener ke setiap tombol hapus
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                // Tampilkan konfirmasi SweetAlert
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                }).then((result) => {
                    // Jika pengguna menekan "Ya", submit form
                    if (result.isConfirmed) {
                        const form = button.closest('.delete-form');
                        console.log(form)
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush
@endsection
