<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalConverstionParticipantRequest;
use App\Http\Requests\UpdateProfessionalConversationParticipantRequest;
use App\Models\ProfessionalConversation;
use App\Models\ProfessionalConverstionParticipant;
use Pusher\Pusher;

class ProfessionalConverstionParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    function store(StoreProfessionalConverstionParticipantRequest $request)
    {
        $request = $request->validated();
        
        try {
            $participants = ProfessionalConverstionParticipant::create($request);
            $conversation = ProfessionalConversation::create(['participant_id'=>$participants->id, 'sender_type'=>'user', 'body'=>'Hey there!']);
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );
            $pusher->trigger('professional-receive-message-'.$participants->professional_id, 'user-send-message-'.$participants->user_id, ['message' => 'Hey There!']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConversationParticipant  $conversationParticipant
     * @return \Illuminate\Http\Response
     */
    public function show(ConversationParticipant $conversationParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConversationParticipant  $conversationParticipant
     * @return \Illuminate\Http\Response
     */
    public function edit(ConversationParticipant $conversationParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessionalConversationParticipantRequest  $request
     * @param  \App\Models\ConversationParticipant  $conversationParticipant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessionalConversationParticipantRequest $request, ConversationParticipant $conversationParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConversationParticipant  $conversationParticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConversationParticipant $conversationParticipant)
    {
        //
    }
}
