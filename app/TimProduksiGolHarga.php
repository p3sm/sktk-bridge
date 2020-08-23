<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimProduksiGolHarga extends Model
{
  protected $connection = 'mysql';
  protected $table = 'tim_produksi_gol_harga';
  protected $primaryKey = 'id';
}
