<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Pusher\Pusher;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversation = ConversationParticipant::with('conversations', 'carehome', 'user')->where('user_id', auth('user_api')->id())->orderBy('id', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$conversation]);
    }

    public function indexForCarehome()
    {
        $conversation = ConversationParticipant::with('conversations', 'carehome', 'user')->where('carehome_id', auth('carehome_api')->id())->orderBy('id', 'desc')->get();
        return response()->json(['status'=>true, 'data'=>$conversation]);
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
     * @param  \App\Http\Requests\StoreConversationRequest  $request
     * @return \Illuminate\Http\Response
     */
    function store(StoreConversationRequest $request)
    {
        $request = $request->all();
        
        try {
            $conversation = Conversation::create($request);
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );
            
            $participant = ConversationParticipant::find($request['participant_id']);
            if($request['sender_type']=='user') $pusher->trigger('carehome-receive-message-'.$participant->carehome_id, 'user-send-message', ['message' => $request['body']]);
            else $pusher->trigger('user-receive-message-'.$participant->user_id, 'carehome-send-message', ['message' => $request['body']]);
            return response()->json(['status'=>true, 'response'=>'Message Sent']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    public function show($participant)
    {
        $conversations = Conversation::with('participant.user', 'participant.carehome')->where('participant_id', $participant)->get();
        return response()->json(['status'=>true, 'data'=>$conversations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    public function update($participant, $senderType)
    {
        return Conversation::where(['participant_id'=>$participant, 'sender_type'=>$senderType])->update(['status'=>1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
