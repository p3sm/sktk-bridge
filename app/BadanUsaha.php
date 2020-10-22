<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BadanUsaha extends Model
{
  protected $table = 'badan_usaha';
    
  public function asosiasi()
  {
    return $this->belongsTo('App\Asosiasi', 'asosiasi_id');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'provinsi_id');
  }
    
  public function kota()
  {
    return $this->belongsTo('App\Kota', 'kota_id');
  }
    
  public function bentuk_usaha()
  {
    return $this->belongsTo('App\BentukUsaha', 'bentuk_usaha_id');
  }
    
  public function status_kantor()
  {
    return $this->belongsTo('App\StatusKantor', 'status_kantor_proyek');
  }
    
  public function bank()
  {
    return $this->belongsTo('App\Bank', 'rekening_bank');
  }
}
