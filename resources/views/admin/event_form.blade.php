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
@section('disclaimer')
    <div class="alert alert-primary text-black" role="alert">
        <p>Disclaimer untuk poster Maks (8mb dan 3 poster)</p>
        Jika Kembali tidak ada alert maka <span class="text-danger font-bold">(input data tidak berhasil)</span>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <form action="" form></form>
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header pb-3">{{ __($title) }}</h5>
                <div class="card-body">

                     {{-- poster --}}
                     @isset($posters)
                     @if ($posters->count() > 0)
                     <label for="end_date" class="form-label mt-3">Poster Event</label>
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

                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'enctype' => 'multipart/form-data', 'id' => 'submit-form']) !!}

                      {{-- Penyelenggara --}}
                    <div class="mb-3 mt-3">
                        <label for="user_id" class="form-label">Applicant</label>
                        {!! Form::select('user_id', $penyelenggara, null, [
                            'class' => 'form-control select2',
                            'placeholder' => 'Select Applicant',
                        ]) !!}
                    </div>

                    {{-- Title --}}
                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">Title</label>
                        {!! Form::text('title', null, ['class' => 'form-control', 'autofocus']) !!}
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        {{-- <input id="x" type="hidden" name="description">
                        <trix-editor input="x"></trix-editor> --}}
                        {!! Form::textarea('description', null, [
                            'class' => 'form-control',
                            'style' => 'resize: none; height: 150px;',
                            'minlength' => '10', // Minimum length
                            'maxlength' => '200', // Maximum length
                        ]) !!}
                    </div>

                    {{-- Categories --}}                   
                    <div class="mb-3 mt-3">
                        <label for="categories[]" class="form-label">Category Type <span class="text-red">(max: 3 categories)</span></label>
                        {!! Form::select('categories[]', $categories, null, [
                            'class' => 'form-control select2-multiple',
                            'placeholder' => 'Select Applicant',
                            'multiple' => 'multiple',
                        ]) !!}
                    </div>
                      

                    {{-- Location --}}
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        {!! Form::text('location', null, ['class' => 'form-control']) !!}
                    </div>

                    {{-- Start Date --}}
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
                    </div>

                    {{-- End Date --}}
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
                    </div>                   

                    @if (\Route::is('admin.event.create'))
                        {{-- Poster 1 --}}
                        <div class="mb-3">
                            <label for="poster" class="form-label">Poster &nbsp;<span class="text-danger">Max : (8mb dan 3
                                    poster)</span></label>
                            <div class="card d-none mb-3" id="poster-card">
                                <div class="card-body">
                                    <div class="row" id="preview-container">

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                {{-- Form input file dengan multiple attribute --}}
                                <div class="d-flex">
                                    {!! Form::file('poster[]', ['class' => 'form-control mt-1', 'multiple', 'id' => 'poster']) !!}
                                </div>
                            </div>
                        </div>
                    @else
                        @if ($posters->count() < 3)
                             {{-- Poster 1 --}}
                        <div class="mb-3">
                            <label for="poster" class="form-label">Poster &nbsp;<span class="text-danger">Disclaimer : (8mb dan Max 3, Sisa: {{ 3 - $posters->count()  }}
                                    poster)</span></label>
                            <div class="card d-none mb-3" id="poster-card">
                                <div class="card-body">
                                    <div class="row" id="preview-container">


                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                {{-- Form input file dengan multiple attribute --}}
                                <div class="d-flex">
                                    {!! Form::file('poster[]', ['class' => 'form-control mt-1', 'multiple', 'id' => 'poster']) !!}
                                </div>
                            </div>
                        </div>
                        @endif                        
                    @endif


                    {!! Form::submit($button, ['class' => 'btn btn-primary mb-3', 'id' => 'submitButton']) !!}
                    {!! Form::close() !!}                    
                </div>
            </div>

        </div>
    </div>
    @push('datatables')   
    <script>
         $('.select2-multiple').select2();
    </script>     
        <script>
            // Ambil tombol submit
    const submitButton = document.getElementById('submitButton');

// Tambahkan event listener ke tombol submit
submitButton.addEventListener('click', function(e) {
    // Cegah perilaku default dari tombol submit
    e.preventDefault();

    // Temukan form menggunakan ID
    const form = document.getElementById('submit-form');

    // Submit form secara manual
    form.submit();
});

            let previousFiles = new DataTransfer();
            let dataTransfer = new DataTransfer();

            // add event listener for the file input change event
            document.getElementById('poster').addEventListener('change', function(event) {

                let newFiles = event.target.files;

                if (previousFiles) {
                    // add files from previousFiles
                    Array.from(newFiles).forEach(file => {
                        let duplicateFile = Array.from(previousFiles.files).find(f => f.name == file.name);
                        if (!duplicateFile) {
                            previousFiles.items.add(file);
                        }
                    });

                    // set the new DataTransfer object as the files
                    event.target.files = previousFiles.files;
                } else {
                    // if there are no previous files, set the new files as the previous files
                    Array.from(newFiles).forEach(file => {
                        previousFiles.items.add(file);
                    });

                    console.log(previousFiles.files)
                }


                // get the preview container
                let previewContainer = document.getElementById('preview-container');
                let posterCard = document.getElementById('poster-card');
                // clear the previous content
                posterCard.classList.remove('d-none');
                previewContainer.innerHTML = '';

                // get the selected files
                let files = event.target.files;

                // convert the FileList object into an array
                let filesArray = Array.from(files);

                for (let i = 0; i < files.length; i++) {
                    // get the file
                    let file = files[i];

                    // create a new FileReader
                    let reader = new FileReader();

                    // event handler for when the file reader loads the image
                    reader.onload = function(e) {
                        // create a new image
                        let img = document.createElement('img');
                        img.src = e.target.result; // the image source
                        img.style.width = '100%';
                        // img.style.height = '50%';

                        // create a new div element
                        let previewItem = document.createElement('div');
                        previewItem.classList.add('col-md-3', 'position-relative', 'mb-3');
                        previewItem.appendChild(img);

                        // Create a delete button
                        let deleteButton = document.createElement('button');
                        deleteButton.innerHTML = 'X';
                        deleteButton.classList.add('btn', 'btn-danger', 'position-absolute', 'top-0', 'end-0');

                        // Add an event listener for the delete button
                        deleteButton.addEventListener('click', function() {
                            previewItem.remove();

                            // Get the unique identifier (e.g., file name)
                            let identifier = file.name;

                            // Remove the file from the array based on the identifier
                            filesArray = filesArray.filter(function(item) {
                                return item.name !== identifier;
                            });

                            // Create a new FileList from the modified array
                            let newFileList = new DataTransfer();
                            previousFiles = new DataTransfer();
                            filesArray.forEach(function(file) {
                                newFileList.items.add(file);
                                previousFiles.items.add(file);
                            });

                            // Overwrite the existing input files
                            event.target.files = newFileList.files;

                            if (event.target.files.length == 0) {
                                posterCard.classList.add('d-none');
                            }

                        });

                        previewItem.appendChild(deleteButton);

                        // Add a unique identifier to the file for future reference
                        file.identifier = file.name;

                        // Add the preview item to the container
                        previewContainer.appendChild(previewItem);
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>
        <script>
            $(document).on('trix-file-accept', function(e) {
                e.preventDefault();
            });
        </script>       
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
