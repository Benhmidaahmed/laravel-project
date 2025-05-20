<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'senderId' => 'required|exists:utilisateur,id',
            'receiverId' => 'required|exists:utilisateur,id',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message = Message::create([
            'sender_id' => $request->senderId,
            'receiver_id' => $request->receiverId,
            'content' => $request->message,
            'timestamp' => Carbon::now(),
        ]);

        return response()->json($message, 201);
    }

    public function getConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user1Id' => 'required|exists:utilisateur,id',
            'user2Id' => 'required|exists:utilisateur,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $messages = Message::where(function ($query) use ($request) {
                $query->where('sender_id', $request->user1Id)
                      ->where('receiver_id', $request->user2Id);
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->user2Id)
                      ->where('receiver_id', $request->user1Id);
            })
            ->orderBy('timestamp', 'asc')
            ->get();

        return response()->json($messages);
    }
}
