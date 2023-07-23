<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
 //para mostrar para o laravel q o items e um array nao uma string para acrescentar cadeira cerveja//

       protected $casts = [
        'items' => 'array'
       ];


       protected $dates = ['date'];

       protected $guarded = [];//tudo q foi enviado pelo post pode ser atualizado


      public function user(){
        return $this->belongsTo('App\Models\User');
       }

       public function users(){
        return $this->belongsToMany('App\Models\User');
       }
}
