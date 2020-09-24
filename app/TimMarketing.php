<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TimMarketing extends Model
{
  use SoftDeletes;

  protected $connection = 'mysql';
  protected $table = 'tim_marketing';
  protected $primaryKey = 'id';

  public static function boot() {
    parent::boot();
    
    static::deleted(function($obj) {
      $obj->deleted_by = Auth::id();
      $obj->save();
    });
  }
    
  public function parent()
  {
    return $this->belongsTo('App\TimMarketing', 'parent_id');
  }
    
  public function provinsi()
  {
    return $this->belongsTo('App\Provinsi', 'provinsi_id');
  }
    
  public function produksi()
  {
    return $this->belongsTo('App\TimProduksi', 'tim_produksi_id');
  }
    
  public function kota()
  {
    return $this->belongsTo('App\Kota', 'kota_id');
  }
    
  public function golHarga()
  {
    return $this->belongsTo('App\TimMarketingGolHarga', 'gol_harga_id');
  }
    
  public function users()
  {
    return $this->hasMany('App\User', 'marketing_id');
  }

  public function jenis_usaha()
  {
    return $this->belongsTo('App\JenisUsaha', 'jenis_usaha_id');
  }
    
  public function level()
  {
    return $this->belongsTo('App\TimMarketingLevel', 'level_id');
  }
}
