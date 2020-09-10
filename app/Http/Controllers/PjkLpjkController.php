<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Asosiasi;
use App\BadanUsaha;
use App\BentukUsaha;
use App\JenisUsaha;
use App\TimProduksiLevel;
use App\PjkLpjk;
use App\Bank;
use App\Team;
use App\TimProduksi;
use App\TimProduksiGolHarga;
use App\StatusKantor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PjkLpjkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
      $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
      $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
      $provinsi = $request->prv;
      $tim = $request->tim;
      $asosiasi = $request->aso;

      $model = new PjkLpjk();

      if($request->prv) $model = $model->where("id_propinsi_reg", $request->prv);
      if($request->aso) $model = $model->where("id_asosiasi_profesi", $request->aso);
      if($request->tim) $model = $model->where("team_id", $request->tim);
      if($request->kua) $model = $model->where("id_kualifikasi", $request->kua);

      $data['from'] = $from;
      $data['to'] = $to;
      $data['asosiasi'] = $asosiasi;
      $data['provinsi'] = $provinsi;
      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();

    	return view('pjklpjk/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["badan_usaha"] = BadanUsaha::all();

      return view('pjklpjk/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $pj = new PjkLpjk();

      $pj->badan_usaha_id = $request->badan_usaha;
      $pj->no_sk = $request->no_sk;
      $pj->tgl_sk = Carbon::createFromFormat("d/m/Y", $request->tgl_sk);
      $pj->tgl_sk_akhir = Carbon::createFromFormat("d/m/Y", $request->tgl_sk_akhir);
      $pj->keterangan = $request->keterangan;
      $pj->is_active = 1;
      $pj->created_by = Auth::id();
      $pj->updated_by = Auth::id();

      $pj->save();

      return redirect('/master_pjklpjk')->with('success', 'PJS LPJK berhasil dibuat');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data['kontribusi'] = TeamKontribusiTa::find($id);

      return view('team/kontribusi_ta/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $data = TeamKontribusiTa::find($id);
      $data->kontribusi = $request->kontribusi;
      
      if($data->save())
        return redirect()->back()->with('success', "Edited successfully");
      else {
        return redirect()->back()->with('error', "An error occurred");
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
