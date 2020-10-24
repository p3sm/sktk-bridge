<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjkLpjkDetail extends Model
{
  protected $table = 'pjk_lpjk_detail';
    
  public function parent()
  {
    return $this->belongsTo('App\PjkLpjk', 'pjk_lpjk_id');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'provinsi_id');
  }
    
  public function jenisUsaha()
  {
    return $this->belongsTo('App\JenisUsaha', 'jenis_usaha_id');
  }
}
