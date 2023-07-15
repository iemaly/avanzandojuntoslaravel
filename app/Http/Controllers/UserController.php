<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookBedRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\BookBed;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $users = User::get();
        return response()->json(['status'=>true, 'data'=>$users]);
    }

    function show($user)
    {
        $user = User::find($user);
        return response()->json(['status'=>true, 'data'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $request = $request->validated();
        
        try {
            $request['password'] = bcrypt($request['password']);
            if (!empty($request['image'])) 
            {
                $imageName = $request['image']->getClientOriginalName().'.'.$request['image']->extension();
                $request['image']->move(public_path('uploads/user/images'), $imageName);
                $request['image']=$imageName;
            }
            $user = User::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$user]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    function activate($user)
    {
        $user = User::find($user);
        if($user->status == 0)
        {
            $user->update(['status'=>1]);

            Mail::raw("https://avanzandojuntos.dev-bt.xyz/login", function ($message) use ($user) 
            {
                $message->to($user->email)->subject('Account Approved');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status'=>true, 'response'=>"Account approved and mail sent to professional"]);
        }
        $user->update(['status'=>0]);
        return response()->json(['status'=>true, 'response'=>"Account deactivated"]);
    }

    // BED BOOKING
    public function bookBed(StoreBookBedRequest $request)
    {
        $request = $request->validated();
        
        try {
            $request['user_id'] = auth('user_api')->id();
            $booking = BookBed::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$booking]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function findBedByDate()
    {
        $date = request()->date;
        $careHomeId = request()->carehome_id;

        $availableBeds = DB::table('beds')
            ->leftJoin('book_beds', function ($join) use ($date) {
                $join->on('beds.id', '=', 'book_beds.bed_id')
                    ->where('book_beds.date', '=', $date);
            })
            ->leftJoin('floors', 'beds.floor_id', '=', 'floors.id')
            ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
            ->where('buildings.carehome_id', '=', $careHomeId)
            ->whereNull('book_beds.bed_id')
            ->select('beds.*')
            ->get();

        return response()->json(['status'=>true, 'data'=>$availableBeds]);
    }

    function findBeds()
    {
        $date = request()->date;
        $startTime = request()->start_time;
        $endTime = request()->end_time;
        $careHomeId = request()->carehome_id;

        $availableBeds = DB::table('beds')
            ->leftJoin('book_beds', function ($join) use ($date, $startTime, $endTime) {
                $join->on('beds.id', '=', 'book_beds.bed_id')
                    ->where('book_beds.date', '=', $date)
                    ->where(function ($query) use ($startTime, $endTime) {
                        $query->where(function ($q) use ($startTime, $endTime) {
                            $q->where('book_beds.start_time', '<', $startTime)
                                ->where('book_beds.end_time', '>', $startTime);
                        })
                        ->orWhere(function ($q) use ($startTime, $endTime) {
                            $q->where('book_beds.start_time', '<', $endTime)
                                ->where('book_beds.end_time', '>', $endTime);
                        })
                        ->orWhere(function ($q) use ($startTime, $endTime) {
                            $q->whereBetween('book_beds.start_time', [$startTime, $endTime])
                                ->orWhereBetween('book_beds.end_time', [$startTime, $endTime]);
                        });
                    });
            })
            ->leftJoin('floors', 'beds.floor_id', '=', 'floors.id')
            ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
            ->where('buildings.carehome_id', '=', $careHomeId)
            ->whereNull('book_beds.bed_id')
            ->select('beds.*')
            ->get();

        return response()->json(['status'=>true, 'data'=>$availableBeds]);
    }

    function myBookings()
    {
        $bookings = BookBed::with('user', 'bed.floor.building.carehome')->where('user_id', auth('user_api')->id())->get();
        return response()->json(['status'=>true, 'data'=>$bookings]);
    }
}
