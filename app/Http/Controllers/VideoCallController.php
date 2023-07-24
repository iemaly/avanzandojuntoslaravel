<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use App\Helpers\Role;
use App\Models\VideoCall;

class VideoCallController extends Controller
{
    /**
     * Create a new video call room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createRoom(Request $request)
    {
        $roomId = uniqid();
        return response()->json(['room_id' => $roomId], 200);
    }

    /**
     * Generate an Agora token for a user to join a video call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateToken(Request $request)
    {
        // Perform any necessary validation on the request data
        $request->validate([
            'user_id' => 'required|string',
            'carehome_id' => 'required|string',
        ]);

        $appId = '0e18b1d7625c4462bbbca340fa83f116'; // Replace with your Agora App ID
        $appCertificate = '9541e69897d44ed7a4e793a510dac46b'; // Replace with your Agora App Certificate

        $user = $request->input('user_id');
        $carehomeId = $request->input('carehome_id');
        $room = uniqid();

        // Token expiration time (1 hour)
        $expirationTimeInSeconds = 3600;
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expirationTimeInSeconds;

        // Token payload
        $payload = [
            'iss' => $appId,
            'exp' => $privilegeExpiredTs,
            'sub' => $room,
            'userId' => $user,
            'carehomeId' => $carehomeId,
            'role' => Role::PUBLISHER, // Use PUBLISHER role for generating tokens
        ];

        // Generate the token using HMAC SHA256 algorithm
        $token = JWT::encode($payload, $appCertificate, 'HS256');
        VideoCall::create(['room_id'=>$room, 'token'=>$token, 'user_id'=>$user, 'carehome_id'=>$carehomeId]);

        // Return the token as the response
        return response()->json(['token' => $token, 'room_id'=>$room], 200);
    }
}
