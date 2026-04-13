<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $guarded = [];

    // Relasi ke Pengirim (Bisa Siswa atau Guru)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relasi ke Penerima
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
