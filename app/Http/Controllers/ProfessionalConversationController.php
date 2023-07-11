<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalConversationRequest;
use App\Http\Requests\UpdateProfessionalConversationRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\ProfessionalConversation;
use App\Models\ProfessionalConverstionParticipant;
use Pusher\Pusher;

class ProfessionalConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversation = ProfessionalConverstionParticipant::with('conversations', 'professional', 'user')->where('user_id', auth('user_api')->id())->get();
        return response()->json(['status'=>true, 'data'=>$conversation]);
    }

    public function indexForProfessional()
    {
        $conversation = ProfessionalConverstionParticipant::with('conversations', 'professional', 'user')->where('professional_id', auth('professional_api')->id())->get();
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
     * @param  \App\Http\Requests\StoreProfessionalConversationRequest  $request
     * @return \Illuminate\Http\Response
     */
    function store(StoreProfessionalConversationRequest $request)
    {
        $request = $request->validated();
        
        try {
            $conversation = ProfessionalConversation::create($request);
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );
            
            $participant = ProfessionalConverstionParticipant::find($request['participant_id']);
            if($request['sender_type']=='user') $pusher->trigger('professional-receive-message-'.$participant->carehome_id, 'user-send-message-'.$participant->user_id, ['message' => $request['body']]);
            else $pusher->trigger('user-receive-message-'.$participant->user_id, 'professional-send-message-'.$participant->carehome_id, ['message' => $request['body']]);
            return response()->json(['status'=>true, 'response'=>'Message Sent']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    public function show($participant)
    {
        $conversations = ProfessionalConversation::with('participant.user', 'participant.professional')->where('participant_id', $participant)->get();
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
