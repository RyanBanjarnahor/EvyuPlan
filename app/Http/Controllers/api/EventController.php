<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getAllEvents() {
       try {
            $events = Event::with('posters')->latest()->get();
            return response()->json([
                'message' => 'Successfully got all events',
                'status' => 'success',
                'data' => $events,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting events',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getEventById($id) {
        try {
            $event = Event::with('posters')->find($id);
            return response()->json([
                'message' => 'Successfully got event by id',
                'status' => 'success',
                'data' => $event,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting event by id',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function createEvent(Request $request) {
        try {
            $event = Event::with('posters')->create([
                'applicant' => $request->applicant,
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return response()->json([
                'message' => 'Successfully created event',
                'status' => 'success',
                'data' => $event,                
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while creating event',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function updateEvent(Request $request, $id) {
        try {
            $event = Event::with('posters')->find($id);
            $event->update([
                'applicant' => $request->applicant,
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return response()->json([
                'message' => 'Successfully updated event',
                'status' => 'success',
                'data' => $event,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while updating event',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function deleteEvent($id) {
        try {
            $event = Event::with('posters')->find($id);
            $event->delete();
            return response()->json([
                'message' => 'Successfully deleted event',
                'status' => 'success',
                'data' => $event,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while deleting event',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventsByApplicant($applicant) {
        try {
            $applicant = User::where('name', $applicant)->first();
            $events = Event::with('posters')->where('applicant', $applicant->id)->get();
            return response()->json([
                'message' => 'Successfully got all events by applicant',
                'status' => 'success',
                'data' => $events,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all events by applicant',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventsByKeyword($keyword) {
        try {        
            $events = Event::with('posters')->search($keyword)->get();            
            return response()->json([
                'message' => 'Successfully got all events by keyword',
                'status' => 'success',
                'data' => $events,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all events by keyword',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

   public function getAllEventsByDate(Request $request){    
      return response()->json([
        'request' => $request->all(),               
      ], 200);
   }

    public function getAllEventsByRangeDate(Request $request) {
        try {
            $events = Event::with('posters')->whereBetween('start_date', [$request->start_date, $request->end_date])->get();
            return response()->json([
                'message' => 'Successfully got all events by range date',
                'status' => 'success',
                'data' => $events,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all events by range date',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventsByLocation($location) {
        try {
            $events = Event::with('posters')->where('location', $location)->get();
            return response()->json([
                'message' => 'Successfully got all events by location',
                'status' => 'success',
                'data' => $events,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all events by location',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventsInThisMonth() {
          try {
                $events = Event::with('posters')->whereMonth('start_date', date('m'))->get();
                return response()->json([
                 'message' => 'Successfully got all events in this month',
                 'status' => 'success',
                 'data' => $events,                
                ], 200);
          } catch (\Exception $e) {
              return response()->json([
                 'message' => 'Error occurred while getting all events in this month',
                 'status' => 'error',
                 'data' => [],
                 "error" => $e->getMessage()
                ], 500);
          }
        }

    public function getAllEventsInThisWeek() {
          try {
                $events = Event::with('posters')->whereBetween('start_date', [date('Y-m-d'), date('Y-m-d', strtotime('+7 days'))])->get();
                return response()->json([
                 'message' => 'Successfully got all events in this week',
                 'status' => 'success',
                 'data' => $events,                
                ], 200);
          } catch (\Exception $e) {
              return response()->json([
                 'message' => 'Error occurred while getting all events in this week',
                 'status' => 'error',
                 'data' => [],
                 "error" => $e->getMessage()
                ], 500);
          }
        }

    public function getAllEventsInThisDay() {
          try {
                $events = Event::with('posters')->whereDate('start_date', date('Y-m-d'))->get();
                return response()->json([
                 'message' => 'Successfully got all events in this day',
                 'status' => 'success',
                 'data' => $events,                
                ], 200);
          } catch (\Exception $e) {
              return response()->json([
                 'message' => 'Error occurred while getting all events in this day',
                 'status' => 'error',
                 'data' => [],
                 "error" => $e->getMessage()
                ], 500);
          }
        }

    public function getAllEventsInThisYear() {
          try {
                $events = Event::with('posters')->whereYear('start_date', date('Y'))->get();
                return response()->json([
                 'message' => 'Successfully got all events in this year',
                 'status' => 'success',
                 'data' => $events,                
                ], 200);
          } catch (\Exception $e) {
              return response()->json([
                 'message' => 'Error occurred while getting all events in this year',
                 'status' => 'error',
                 'data' => [],
                 "error" => $e->getMessage()
                ], 500);
          }
        }

    public function getAllEventsPagination() {
          try {
                $events = Event::with('posters')->latest()->paginate(10);
                return response()->json([
                 'message' => 'Successfully got all events pagination',
                 'status' => 'success',
                 'data' => $events,                
                ], 200);
          } catch (\Exception $e) {
              return response()->json([
                 'message' => 'Error occurred while getting all events pagination',
                 'status' => 'error',
                 'data' => [],
                 "error" => $e->getMessage()
                ], 500);
          }
        }
}
