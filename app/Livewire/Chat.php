<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use Livewire\WithFileUploads;

class Chat extends Component
{

    use WithFileUploads;
    public $conversationId, $conversation, $show_conversation = false,  $messages = [];
    public $user, $unread = false;
    public  $message, $file, $user_id, $search;
    public $new_chat = false, $new_user = false;


    protected $listeners = ['refreshChat'];
    public function refreshChat()
    {
        if ($this->show_conversation && $this->conversationId) {
            $this->showConversation($this->conversationId);
        }
    }



    public function mount()
    {
        $this->user = auth()->user();
    }



    public function AddNewChat($id)
    {
        $this->new_user = User::find($id);
        $this->show_conversation = true;
        $this->messages = [];
    }


    public function showConversation($id)
    {
        $this->show_conversation = true;
        $this->conversationId = $id;
        $this->conversation = Conversation::find($id);
        $this->messages = Message::where('conversation_id', $id)->get();
        Message::where('conversation_id', $id)
            ->where('sender_id', '!=', $this->user->id)
            ->where('is_read', 0)
            ->update(['is_read' => true]);
    }



    public function sendMessage($id)
    {
        $fromUserId = auth()->id();
        $toUserId = $id;

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

        if ($this->file) {
            $path = store_file($this->file, 'chats');
            $extension = $this->file->getClientOriginalExtension();

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
            'message' => $this->message,
            'file_path' => $path,
            'type' => $type,
        ]);

        $this->reset(['message', 'file']);
        $this->showConversation($conversation->id);
    }


    public function render()
    {
        $userId = auth()->id();

        $conversations = Conversation::with(['messages', 'userTwo', 'userOne'])
            ->where(function ($q) use ($userId) {
                $q->where('user_one_id', $userId)
                    ->orWhere('user_two_id', $userId);
            })
            ->when($this->unread, function ($q) use ($userId) {
                $q->whereHas('messages', function ($q) use ($userId) {
                    $q->where('is_read', false)->where('sender_id', '!=', $userId);
                });
            })->when($this->search, function ($q) use ($userId) {
                $q->where(function ($q) use ($userId) {
                    $q->whereHas('userOne', function ($q2) use ($userId) {
                        $q2->where('id', '!=', $userId)
                            ->where('name', 'like', '%' . $this->search . '%');
                    })->orWhereHas('userTwo', function ($q2) use ($userId) {
                        $q2->where('id', '!=', $userId)
                            ->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->get();

        $contactedUserIds = Conversation::with(['messages', 'userTwo', 'userOne'])
            ->where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->get()
            ->flatMap(function ($conv) use ($userId) {
                return [$conv->user_one_id, $conv->user_two_id];
            })
            ->reject(function ($id) use ($userId) {
                return $id == $userId;
            })
            ->unique()
            ->values();

        // الخطوة 2: رجّع كل المستخدمين ما عدا اللي حصلت معاهم محادثة
        $usersWithoutConversation = User::where('id', '!=', $userId)
            ->whereNotIn('id', $contactedUserIds)->when($this->search, function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->select('id', 'name', 'email', 'image')->get();
        return view('livewire.chat', compact('conversations', 'usersWithoutConversation'));
    }
}
