<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryTypeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRequestController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\CategoryType;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {   
      // Assuming today is the first day of the week (Sunday)
      $startOfWeek = now()->startOfWeek(); // Adjust as needed
      $endOfWeek = now()->endOfWeek(); // Adjust as needed
  
      $eventsThisWeek = Event::with('user')->whereBetween('start_date', [$startOfWeek, $endOfWeek])->get();
  
      $startOfMonth = now()->startOfMonth();
      $endOfMonth = now()->endOfMonth();
  
      $eventsThisMonth = Event::with('user')->whereBetween('start_date', [$startOfMonth, $endOfMonth])->get();
  
  
      $data = [
          'eventsThisWeek' => $eventsThisWeek,
          'eventsThisMonth' => $eventsThisMonth
      ];    
      return view('welcome', $data);
})->name('welcome');

Route::get('/detail-event/{event}', function ($event) {      
    $eventDetail = Event::with('user')->findOrFail($event);
    return view('detail', ['event' => $eventDetail]);
})->name('detail-event');

Route::get('/dashboard', function () {
    // Assuming today is the first day of the week (Sunday)
    $startOfWeek = now()->startOfWeek(); // Adjust as needed
    $endOfWeek = now()->endOfWeek(); // Adjust as needed

    $eventsThisWeek = Event::with('user')->whereBetween('start_date', [$startOfWeek, $endOfWeek])->get();

    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    $eventsThisMonth = Event::with('user')->whereBetween('start_date', [$startOfMonth, $endOfMonth])->get();


    $data = [
        'eventsThisWeek' => $eventsThisWeek,
        'eventsThisMonth' => $eventsThisMonth
    ];    
    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search', [EventController::class, "search"])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/eventRequest/create', [EventRequestController::class, 'createFromUser'])->name('eventRequest.create.fromUser');
    Route::get('/eventRequest/{eventRequest}/edit', [EventRequestController::class, 'editFromUser'])->name('eventRequest.edit');
    Route::put('/eventRequest/{eventRequest}', [EventRequestController::class, 'updateFromUser'])->name('eventRequest.update');
    Route::get('/eventRequest', [EventRequestController::class, 'indexUser'])->name('eventRequest.index');
    Route::get('/myevents', [EventController::class, 'myEvent'])->name('myEvent');    
    Route::get('/myevents/{event}', [EventController::class, 'destroy'])->name('deleteMyEvent');    
    Route::post('/eventRequest', [EventRequestController::class, 'store'])->name('eventRequest.store');
    Route::get('/eventRequest/{eventRequest}/show', [EventRequestController::class, 'showFromUser'])->name('eventRequest.show');
    Route::delete('/eventRequest/{eventRequest}', [EventRequestController::class, 'destroy'])->name('eventRequest.destroy');

    Route::patch('/eventRequest/{eventRequest}/prove-payment', [EventRequestController::class, 'proofPayment'])->name('eventRequest.payment_proof');
    Route::post('/eventRequest/{eventRequest}/upload-poster', [EventRequestController::class, 'uploadPoster'])->name('eventRequest.upload_poster');    
});



Route::middleware(['auth', 'CheckRoles:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('home_index');
        Route::post('/eventRequest/approve', [EventController::class, 'approve'])->name('eventRequest.approve');
        Route::resource('event', EventController::class);
        Route::resource('eventRequest', EventRequestController::class);
        Route::resource('poster', PosterController::class);
        Route::resource('user', UserController::class);
        Route::resource('categoryType', CategoryTypeController::class);
        
        
        // Route::get('event/{event:title}/edit', [EventController::class, 'edit'])->name('event.edit');
    });

Route::get("send", function () {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => '081216616938',
            'delay' => '2',
            'message' => 'test wa uhuy badjingan',
            'countryCode' => '62', //optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Z39aiQ052SCuXvY346-6' //change TOKEN to your actual token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
});

require __DIR__ . '/auth.php';
