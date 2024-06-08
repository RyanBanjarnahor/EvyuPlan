@extends('layouts.app_sneat')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    <style>
        .dataTables_length label select {
            margin-right: 10px;
            margin-left: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header pb-3">{{ __($title) }}</h5>
                <div class="card-body">
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary mt-3 mb-3 btn-sm">Add User</a>
                    <div class="table-responsive">
                        <table id="eventDataTables" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>                           
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>                              
                                        <td>
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')',
                                                'class' => 'd-flex gap-2 delete-form',
                                            ]) !!}
                                            <a href="{{ route($routePrefix . '.edit', $item) }}"
                                                class="btn btn-warning btn-sm ml-2 mr-2 d-flex gap-3 text-white">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                            <a href="{{ route($routePrefix . '.show', $item->id) }}"
                                                class="btn btn-info btn-sm ml-2 mr-2 d-flex gap-3 text-white">
                                                <i class="fa fa-edit"></i> Detail
                                            </a>

                                            {{-- {!! Form::submit("Hapus", ['class' => 'btn btn-danger btn-sm']) !!} --}}
                                            <button type="button" data-event-name="{{ $item->title }}" class="btn btn-danger btn-sm d-flex gap-3 delete-button">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('datatables')
        <script>
            $(document).ready(function() {
                $('#eventDataTables').DataTable({
                    "scrollY": "330px",
        "scrollCollapse": true,
        "paging": true,
                });
                
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

                    const eventName = button.dataset.eventName;

                    Swal.fire({
                        title: 'Konfirmasi',
                        html: `<p>Apakah Anda yakin ingin menghapus</p> <strong>${eventName}</strong>?`,
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
