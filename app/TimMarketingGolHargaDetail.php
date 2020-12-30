<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimMarketingGolHargaDetail extends Model
{
  protected $connection = 'mysql';
  protected $table = 'tim_marketing_gol_harga_detail';
  protected $primaryKey = 'id';
    
  public function head()
  {
    return $this->belongsTo('App\TimMarketingGolHarga', 'gol_harga_id');
  }
}
