<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array'
    ];

    protected $dates = ['date'];

    protected $guarded = []; // Indico que tudo que vier pelo post do update, pode ser atualizado, para evitar o erro de Add{token}Fillabe

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
