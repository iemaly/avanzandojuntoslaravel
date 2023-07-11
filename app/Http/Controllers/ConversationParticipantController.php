<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationParticipantRequest;
use App\Http\Requests\UpdateConversationParticipantRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Pusher\Pusher;

class ConversationParticipantController extends Controller
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


    function store(StoreConversationParticipantRequest $request)
    {
        $request = $request->validated();
        
        try {
            $participants = ConversationParticipant::create($request);
            $conversation = Conversation::create(['participant_id'=>$participants->id, 'sender_type'=>'user', 'body'=>'Hey there!']);
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );
            $pusher->trigger('carehome-receive-message-'.$participants->carehome_id, 'user-send-message-'.$participants->user_id, ['message' => 'Hey There!']);
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
     * @param  \App\Http\Requests\UpdateConversationParticipantRequest  $request
     * @param  \App\Models\ConversationParticipant  $conversationParticipant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConversationParticipantRequest $request, ConversationParticipant $conversationParticipant)
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
