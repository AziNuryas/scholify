<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaryRecord extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id'); // Reporter
    }
}
