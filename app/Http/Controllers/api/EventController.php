<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = Event::paginate(10);
        return response()->json([
            'event' => $event,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date_format:"Y-m-d H:i:s"',
            'end_time' => 'required|date_format:"Y-m-d H:i:s"',
            'location' => 'required',
            'total_seats' => 'required',
            'available_seats' => 'required',
        ]);
        if($validation){
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'total_seats' => $request->total_seats,
                'available_seats' => $request->total_seats, // auto-set
            ]);
            return response()->json([
                'data' => $validation,
                'message' => 'data is store',
            ],200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::where('id',$id)->first();
        return response()->json([
            'event' => $event,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validation = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date_format:"Y-m-d H:i:s"',
            'end_time' => 'required|date_format:"Y-m-d H:i:s"',
            'location' => 'required',
            'total_seats' => 'required',
            'available_seats' => 'required',
        ]);

        Event::where('id',$id)->update($validation);
        return response()->json([
            'data' => $validation,
            'message' => 'data is updated',

        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::findOrFail($id)->delete(); 

        return response()->json([
            'message' => 'data is deleted of id:' . $id,
        ]);
    }
}
