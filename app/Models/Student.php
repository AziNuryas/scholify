<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students'; // Sesuai nama tabel di SQL tadi
    protected $guarded = [];       // Biar gampang buat input data

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function disciplinaryRecords()
    {
        return $this->hasMany(DisciplinaryRecord::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}