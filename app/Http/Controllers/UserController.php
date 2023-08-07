<?php

namespace App\Http\Controllers;

use App\Events\CarehomeBookingNotifyEvent;
use App\Events\SendUserEmailVerificationEvent;
use App\Http\Requests\StoreBookBedRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\BookBed;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ConversationParticipantController;
use App\Http\Controllers\ConversationController;
use App\Http\Requests\StoreConversationParticipantRequest;
use App\Http\Requests\StoreConversationRequest;
use App\Models\Bed;

class UserController extends Controller
{
    // public $ali;

    protected $conversationParticipantController;
    protected $conversationController;

    public function __construct(
        ConversationParticipantController $conversationParticipantController,
        ConversationController $conversationController
    ) {
        $this->conversationParticipantController = $conversationParticipantController;
        $this->conversationController = $conversationController;
    }

    // function inherit(UserLoginRequest $request)
    // {
    //     return $this->login($request);
    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::orderBy('id', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$users]);
    }

    function show($user)
    {
        $this->authorize('view', User::class);
        
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
        $this->authorize('create', User::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        
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
            $user['role'] = 'user';

            event(new SendUserEmailVerificationEvent($user));
            return response()->json(['status'=>true, 'response'=>'Welcome To Avanzando Juntos. Now please verify your email so admin will make your account active.', 'data'=>$user]);
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

    public function update(UpdateUserRequest $request, $id)
    {
        $this->authorize('update', User::class);

        $request = $request->validated();
        
        try {
            $request['password'] = bcrypt($request['password']);
            $user = User::findOrFail($id);
            $user->update($request);
            $user['role'] = 'user';

            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$user]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);
    }

    function activate($user)
    {
        $this->authorize('update', User::class);
        
        $user = User::find($user);
        if($user->status == 0)
        {
            $user->update(['status'=>1]);

            Mail::raw(env('USER_URL'), function ($message) use ($user) 
            {
                $message->to($user->email)->subject('Account Approved');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return response()->json(['status'=>true, 'response'=>"Account approved and mail sent to user"]);
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
            $bed = Bed::find($booking->bed_id);
            $data['body'] = 'Greetings.. Bed #'.$bed->title.' is booked discuss the further details with user';
            $data['carehome'] = $bed->floor->building->carehome;

            // INITIATING CHAT
            $participant = $this->conversationParticipantController->store(new StoreConversationParticipantRequest(['user_id'=>$booking->user_id,'carehome_id'=>$bed->floor->building->carehome->id]));
            $this->conversationController->store(new StoreConversationRequest(['participant_id'=>$participant->id, 'sender_type'=>'user', 'body'=>$data['body']]));

            // EMAIL
            event(new CarehomeBookingNotifyEvent($data));
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
        $endDate = request()->end_date;
        $startTime = request()->start_time;
        $endTime = request()->end_time;
        $careHomeId = request()->carehome_id;

        $availableBeds = DB::table('beds')
            ->leftJoin('book_beds', function ($join) use ($date, $endDate, $startTime, $endTime) {
                $join->on('beds.id', '=', 'book_beds.bed_id')
                    ->where(function ($query) use ($date, $endDate, $startTime, $endTime) {
                        $query->where(function ($query) use ($date, $endDate, $startTime, $endTime) {
                            $query->whereRaw("CONCAT(book_beds.`end_date`, ' ', book_beds.`end_time`) BETWEEN ? AND ?", [
                                \Carbon\Carbon::parse($date)->format("Y-m-d") . " " . $startTime,
                                \Carbon\Carbon::parse($endDate)->format("Y-m-d") . " " . $endTime
                            ])->orWhereRaw("CONCAT(book_beds.`date`, ' ', book_beds.`start_time`) BETWEEN ? AND ?", [
                                \Carbon\Carbon::parse($date)->format("Y-m-d") . " " . $startTime,
                                \Carbon\Carbon::parse($endDate)->format("Y-m-d") . " " . $endTime
                            ]);
                        });
                    });
            })
            ->leftJoin('floors', 'beds.floor_id', '=', 'floors.id')
            ->leftJoin('buildings', 'floors.building_id', '=', 'buildings.id')
            ->where('buildings.carehome_id', '=', $careHomeId)
            ->whereNull('book_beds.bed_id')
            ->select('beds.*', 'floors.title as floor_title')
            ->get();

        return response()->json(['status' => true, 'data' => $availableBeds]);
    }

    function myBookings()
    {
        $bookings = BookBed::with('user', 'bed.floor.blueprint', 'bed.floor.building.carehome')->where('user_id', auth('user_api')->id())->get();
        return response()->json(['status'=>true, 'data'=>$bookings]);
    }
}
