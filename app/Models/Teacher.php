<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['nom', 'prenom', 'email', 'specialite'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}

