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

                    {{-- Penyelenggara --}}
                    <div class="mb-3 mt-3">
                        <label for="user_id" class="form-label">Applicant</label>
                        {!! Form::select('user_id', $penyelenggara, null, [
                            'class' => 'form-control select2',
                            'placeholder' => 'Select Applicant',
                        ]) !!}
                    </div>

                    @if (\Route::is('admin.eventRequest.edit'))
                        {{-- Status --}}
                        <div class="mb-3 mt-3">
                            <label for="status" class="form-label">Status</label>
                            {!! Form::select(
                                'status',
                                [
                                    'pending' => 'Pending',
                                    'approved' => 'Approved',
                                    'decline' => 'Decline',
                                    'revision' => 'Revision',
                                    'waiting for payment' => 'Waiting for payment',
                                ],
                                null,
                                [
                                    'class' => 'form-control select2',
                                    'placeholder' => 'Select Status',
                                ],
                            ) !!}
                        </div>
                    @endif


                    {{-- Title --}}
                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">Title</label>
                        {!! Form::text('title', null, ['class' => 'form-control', 'autofocus']) !!}
                    </div>

                    {{-- Comment --}}
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        {{-- <input id="x" type="hidden" name="description">
                        <trix-editor input="x"></trix-editor> --}}
                        {!! Form::textarea('comment', null, [
                            'class' => 'form-control',
                            'style' => 'resize: none; height: 150px;',
                            'minlength' => '10', // Minimum length
                            'maxlength' => '200', // Maximum length
                        ]) !!}
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


                    <div class="d-flex gap-2">
                        {!! Form::submit($button, ['class' => 'btn btn-primary mb-3']) !!}
                        @isset($eventIsMade)
                            @if (!$eventIsMade)
                                {!! Form::hidden('id', null, ['']) !!}
                                <button type="button" class="btn btn-dark mb-3 make-event">Make Event</button>
                            @endif
                        @endisset
                    </div>

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
