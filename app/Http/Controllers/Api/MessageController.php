<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Models\Message;
use App\Traits\ApiResponse;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    use ApiResponse;
    public function getUserConversations(Request $request)
    {
        $userId = auth()->id(); // حسب لو كان API أو Dashboard

        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['messages' => function ($q) use ($userId) {
                $q->latest();
            }])
            ->get()
            ->map(function ($conversation) use ($userId) {
                $lastMessage = $conversation->messages()
                    ->orderBy('id', 'DESC')
                    ->first();
                $unreadCount = $conversation->messages()
                    ->where('is_read', false)
                    ->where('sender_id', '!=', $userId)
                    ->count();

                return [
                    'conversation_id' => $conversation->id,
                    'with_user' => new UserResource($conversation->otherUser($userId)),
                    // 'last_message' => new MessageResource($lastMessage),
                    'last_message' => $lastMessage,
                    'unread_messages_count' => $unreadCount,
                ];
            });

        return $this->returnData($conversations);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id', // الشخص اللي هنبعتله
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $fromUserId = auth()->id();
        $toUserId = $request->to_user_id;

        $conversation = Conversation::where(function ($q) use ($fromUserId, $toUserId) {
            $q->where('user_one_id', $fromUserId)
                ->where('user_two_id', $toUserId);
        })->orWhere(function ($q) use ($fromUserId, $toUserId) {
            $q->where('user_one_id', $toUserId)
                ->where('user_two_id', $fromUserId);
        })->first();


        // 2️⃣ لو مش موجودة، نعمل واحدة جديدة
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $fromUserId,
                'user_two_id' => $toUserId,
            ]);
        }

        $path = null;
        $type = 'text';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = store_file($file, 'chats');
            $extension = $file->getClientOriginalExtension();

            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                $type = 'image';
            } else {
                $type = 'file';
            }
        }

        // 4️⃣ إرسال الرسالة
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $fromUserId,
            'message' => $request->message,
            'file_path' => $path,
            'type' => $type,
        ]);

        event(new MessageSent($message));
        $data = new MessageResource($message);
        return $this->returnData($data);
    }



    public function unreadConversationsCount()
    {
        $userId = auth()->id();
        $conversations = Conversation::where(function ($q) use ($userId) {
            $q->where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId);
        })->whereHas('messages', function ($q) use ($userId) {
            $q->where('is_read', false)
                ->where('sender_id', '!=', $userId);
        })->get()
            ->map(function ($conversation) use ($userId) {
                $lastMessage = $conversation->messages()
                    ->orderBy('id', 'DESC')
                    ->first();
                $unreadCount = $conversation->messages()
                    ->where('is_read', false)
                    ->where('sender_id', '!=', $userId)
                    ->count();

                return [
                    'conversation_id' => $conversation->id,
                    'with_user' => new UserResource($conversation->otherUser($userId)),
                    // 'last_message' => new MessageResource($lastMessage),
                    'last_message' => $lastMessage,
                    'unread_messages_count' => $unreadCount,
                ];
            });


        $data = [
            'conversations' => $conversations,
            'count' => count($conversations),
        ];
        return $this->returnData($data);
        return response()->json(['unread_conversations' => $count]);
    }

    public function messages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)->get();
        return $this->returnData(MessageResource::collection($messages));
    }
    public function markAsRead($conversationId)
    {
        $userId = auth()->id();
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return $this->returnSuccessMessage('تم القراءه بنجاح');
    }
}
