<?php

namespace App\Http\Controllers;

use App\Provinsi;
use App\Kota;
use App\Bidang;
use App\BidangSub;
use App\BadanUsaha;
use App\JenisUsaha;
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

  public function bidang(Request $request)
  {      
    $model = Bidang::all();
    return response()->json($model, 200);
  }

  public function bidang_sub(Request $request)
  {      
    $model = BidangSub::where("bidang_id", $request->bidang)->get();
    return response()->json($model, 200);
  }

  public function badan_usaha(Request $request)
  {      
    $model = BadanUsaha::find($request->id);
    return response()->json($model, 200);
  }

  public function jenis_usaha(Request $request)
  {      
    $model = JenisUsaha::all();
    return response()->json($model, 200);
  }
}
