<?php

namespace App\Models;

use App\Enums\TypeMessage;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'type',
        'file_path',
        'is_read'
    ];


    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function casts(): array
    {
        return [
            'type' => TypeMessage::class,
        ];
    }
}