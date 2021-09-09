<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    use HasFactory;

    protected $fillable = [
        'present', 'totalPresent','totalAbsence', 'holyday','weekend', 'user_id'
    ];

    function users () {
        return $this->belongsTo(User::class);
    }
}
