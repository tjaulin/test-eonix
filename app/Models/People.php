<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class People extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'people';
    protected $keyType = 'string';

    protected $fillable = ['first_name', 'last_name'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
