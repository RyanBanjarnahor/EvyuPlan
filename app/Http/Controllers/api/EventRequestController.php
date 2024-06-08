<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;
use Illuminate\Http\Request;

class EventRequestController extends Controller
{
    public function getAllEventRequests() {
        try {
            $eventRequests = EventRequest::with('user')->get();
            return response()->json([
                'message' => 'Successfully got all event requests',
                'status' => 'success',
                'data' => $eventRequests,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting event requests',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getEventRequestById($id) {
        try {
            $eventRequest = EventRequest::find($id);
            return response()->json([
                'message' => 'Successfully got event request by id',
                'status' => 'success',
                'data' => $eventRequest,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting event request by id',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function createEventRequest(Request $request) {
        try {
            $eventRequest = EventRequest::create($request->all());
            return response()->json([
                'message' => 'Successfully created event request',
                'status' => 'success',
                'data' => $eventRequest,                
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while creating event request',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function updateEventRequest(Request $request) {
        try {
            $eventRequest = EventRequest::find($request->id);
            $eventRequest->update($request->all());
            return response()->json([
                'message' => 'Successfully updated event request',
                'status' => 'success',
                'data' => $eventRequest,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while updating event request',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function deleteEventRequest($id) {
        try {
            $eventRequest = EventRequest::find($id);
            $eventRequest->delete();
            return response()->json([
                'message' => 'Successfully deleted event request',
                'status' => 'success',
                'data' => $eventRequest,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while deleting event request',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventRequestsByApplicant($applicant) {
        try {
            $eventRequests = EventRequest::where('applicant', $applicant)->get();
            return response()->json([
                'message' => 'Successfully got all event requests by applicant',
                'status' => 'success',
                'data' => $eventRequests,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all event requests by applicant',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventRequestsByKeyword($keyword) {
        try {
            $eventRequests = EventRequest::where('title', 'like', '%'.$keyword.'%')->get();
            return response()->json([
                'message' => 'Successfully got all event requests by keyword',
                'status' => 'success',
                'data' => $eventRequests,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all event requests by keyword',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventRequestsPagination(){
        try {
            $eventRequests = EventRequest::latest()->paginate(10);
            return response()->json([
                'message' => 'Successfully got all event requests pagination',
                'status' => 'success',
                'data' => $eventRequests,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all event requests pagination',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }

    public function getAllEventRequestsPaginationByValue($value){
        try {
            $eventRequests = EventRequest::latest()->paginate($value);
            return response()->json([
                'message' => 'Successfully got all event requests pagination by value',
                'status' => 'success',
                'data' => $eventRequests,                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while getting all event requests pagination by value',
                'status' => 'error',
                'data' => [],
                "error" => $e->getMessage()
            ], 500);
       }
    }   
}
