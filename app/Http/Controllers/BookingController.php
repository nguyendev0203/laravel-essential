<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessBookingJob;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $booking = Booking::paginate(5);
        return view('bookings.index')->with('bookings', $booking);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = DB::table('users')->get()->pluck('name','id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number','id');
        return view('bookings.create')
        ->with('users',$users)
        ->with('booking',(new Booking()))
        ->with('rooms',$rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $booking = Booking::create($request->input());
        DB::table('bookings_users')->insert([
            'booking_id' => $booking->id,
            'user_id'=>$request->input('user_id')
        ]);
        return redirect()->action([BookingController::class,'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
        return view('bookings.show', ['booking' => $booking]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        $bookingsUser = DB::table('bookings_users')->where('booking_id', $booking->id)->first();
        return view('bookings.edit')
            ->with('bookingsUser', $bookingsUser)
            ->with('users', $users)
            ->with('rooms', $rooms)
            ->with('booking', $booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
        ProcessBookingJob::dispatch($booking);
        $validatedData = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'notes' => 'required',
            'start' => 'required',
        ]);
        $booking->fill($validatedData);
        $booking->save();
        DB::table('bookings_users')
        ->where('booking_id', $booking->id)
        ->update([
            'user_id'=>$validatedData['user_id']
        ]);
        return redirect()->action([BookingController::class,'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
        DB::table('bookings_users')->where('booking_id',$booking->id)->delete();
        $booking->delete();
        return redirect()->action([BookingController::class,'index']);
    }
}
