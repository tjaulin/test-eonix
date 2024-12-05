<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Personne extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['prenom', 'nom'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
