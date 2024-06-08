@extends('layouts.app_sneat')
@push('css')
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
@endpush
@section('content')
    <div class="row justify-content-center">
        <form action="" form></form>
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header pb-3">{{ __($title) }}</h5>
                <div class="card-body">
                    {!! Form::model($model, [
                        'route' => $route,
                        'method' => $method,
                        'enctype' => 'multipart/form-data',
                        'id' => 'eventForm',
                    ]) !!}

                    {{-- Name --}}
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Applicant</label>
                       {!! Form::text("name", null, [
                        "class" => "form-control",
                        "placeholder" => "Name",
                       ]) !!}
                    </div>                    

                    {{-- Email --}}
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email</label>
                        {!! Form::text("email", null, [
                            "class" => "form-control",
                            "placeholder" => "Email",
                        ]) !!}
                    </div>

                    {{-- Password --}}
                    <div class="mb-3 mt-3">
                        <label for="password" class="form-label">Password</label>
                        {!! Form::password("password", [
                            "class" => "form-control",
                            "placeholder" => "Password",
                        ]) !!}
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="mb-3 mt-3">
                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                        {!! Form::password("password_confirmation", [
                            "class" => "form-control",
                            "placeholder" => "Password Confirmation",
                        ]) !!}
                    </div>

                    {{-- Role --}}
                    <div class="mb-3 mt-3">
                        <label for="role" class="form-label">Role</label>
                        {!! Form::select("role", [
                            "admin" => "Admin",
                            "user" => "User",                        
                        ], null, [
                            "class" => "form-control",
                            "placeholder" => "Select Role",
                        ]) !!}
                    </div>

                    {!! Form::submit($button, ['class' => 'btn btn-primary mb-3', 'id' => 'submitButton']) !!}

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    @push('select2')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get the "Make Event" button
                const makeEventButton = document.querySelector('.make-event');

                // Add click event listener to the button
                makeEventButton.addEventListener('click', function() {

                    // Get the form element
                    const form = document.getElementById('eventForm');

                    const methodInput = form.querySelector('input[name="_method"]');
                    methodInput.value = 'POST';


                    // Change the form method to POST
                    form.method = 'POST';

                    // Change the form action attribute
                    form.action = '{{ route('admin.eventRequest.approve') }}';

                    // Submit the form
                    form.submit();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection
