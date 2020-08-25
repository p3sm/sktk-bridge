<?php

namespace App\Http\Controllers;

use App\Provinsi;
use App\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiMasterController extends Controller
{
  public function provinsi(Request $request)
  {      
    $model = Provinsi::all();
    return response()->json($model, 200);
  }

  public function kota(Request $request)
  {      
    $model = Kota::where("provinsi_id", $request->provinsi)->get();
    return response()->json($model, 200);
  }
}
