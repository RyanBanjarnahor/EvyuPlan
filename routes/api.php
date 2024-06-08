<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login, register, logout
Route::post('/login', 'App\Http\Controllers\api\AuthController@login');
Route::post('/register', 'App\Http\Controllers\api\AuthController@register');
// Route::post('/logout', 'App\Http\Controllers\api\AuthController@logout'); 

// Event API
// get all events
Route::get('/events', 'App\Http\Controllers\api\EventController@getAllEvents');
// get event by id
Route::get('/events/{id}', 'App\Http\Controllers\api\EventController@getEventById');
// create event 
Route::post('/events', 'App\Http\Controllers\api\EventController@createEvent');
// update event
Route::put('/events/{id}', 'App\Http\Controllers\api\EventController@updateEvent');
// delete event
Route::delete('/events/{id}', 'App\Http\Controllers\api\EventController@deleteEvent');
// get all events by applicant name
Route::get('/events/applicant/{applicant}', 'App\Http\Controllers\api\EventController@getAllEventsByApplicant');
// get all events by keyword
Route::get('/events/keyword/{keyword}', 'App\Http\Controllers\api\EventController@getAllEventsByKeyword');
// get all events by location
Route::get('/events/location/{location}', 'App\Http\Controllers\api\EventController@getAllEventsByLocation');
// get all events in this month
Route::get('/events/this-month', 'App\Http\Controllers\api\EventController@getAllEventsInThisMonth');
// get all events in this week
Route::get('/events/this-week', 'App\Http\Controllers\api\EventController@getAllEventsInThisWeek');
// get all events in this day
Route::get('/events/this-day', 'App\Http\Controllers\api\EventController@getAllEventsInThisDay');
// get all events in this year
Route::get('/events/this-year', 'App\Http\Controllers\api\EventController@getAllEventsInThisYear');
// get all events pagination
Route::get('/events/pagination', 'App\Http\Controllers\api\EventController@getAllEventsPagination');

// Event Request API

// get all event requests
Route::get('/event-requests', 'App\Http\Controllers\api\EventRequestController@getAllEventRequests');
// get event request by id
Route::get('/event-requests/{id}', 'App\Http\Controllers\api\EventRequestController@getEventRequestById');
// create event request
Route::post('/event-requests', 'App\Http\Controllers\api\EventRequestController@createEventRequest');
// update event request
Route::put('/event-requests/update', 'App\Http\Controllers\api\EventRequestController@updateEventRequest');
// delete event request\
Route::delete('/event-requests/{id}', 'App\Http\Controllers\api\EventRequestController@deleteEventRequest');
// get all event requests by applicant
Route::get('/event-requests/applicant/{applicant}', 'App\Http\Controllers\api\EventRequestController@getAllEventRequestsByApplicant');
// get all event requests by keyword
Route::get('/event-requests/keyword/{keyword}', 'App\Http\Controllers\api\EventRequestController@getAllEventRequestsByKeyword');
// get all event requests pagination
Route::get('/event-requests/pagination', 'App\Http\Controllers\api\EventRequestController@getAllEventRequestsPagination');
// get all event requests pagination pagevalue
Route::get('/event-requests/pagination/{value}', 'App\Http\Controllers\api\EventRequestController@getAllEventRequestsPaginationByValue');
