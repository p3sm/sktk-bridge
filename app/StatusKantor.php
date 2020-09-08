<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusKantor extends Model
{
  use SoftDeletes;

  protected $connection = 'mysql';
  protected $table = 'master_status_comp';
}
