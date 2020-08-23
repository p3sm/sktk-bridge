<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimMarketing extends Model
{
  protected $connection = 'mysql';
  protected $table = 'tim_marketing';
  protected $primaryKey = 'id';
    
  public function parent()
  {
    return $this->belongsTo('App\TimMarketing', 'parent_id');
  }
    
  public function produksi()
  {
    return $this->belongsTo('App\TimProduksi', 'tim_produksi_id');
  }
}
