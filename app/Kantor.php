<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
  protected $table = 'kantor';
  protected $fillable = [
    'nama',
    ];
}
