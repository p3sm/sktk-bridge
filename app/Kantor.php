<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
  protected $table = 'kantor';
  protected $fillable = [
    'nama',
    ];

  public function level()
  {
    return $this->belongsTo('App\KantorLevel', 'level_id');
  }

  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'provinsi_id');
  }

  public function kota()
  {
    return $this->belongsTo('App\Kota', 'kota_id');
  }
}
