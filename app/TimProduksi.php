<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimProduksi extends Model
{
  protected $connection = 'mysql';
  protected $table = 'tim_produksi';
  protected $primaryKey = 'id';
    
  public function parent()
  {
    return $this->belongsTo('App\TimProduksi', 'parent_id');
  }
}
