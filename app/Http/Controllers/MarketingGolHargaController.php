<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Asosiasi;
use App\Bidang;
use App\Team;
use App\TimProduksi;
use App\TimMarketingGolHarga;
use App\TimMarketingGolHargaDetail;
use App\JenisUsaha;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingGolHargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
      $gol = $request->gol;
      $asosiasi = $request->aso;
      $master_gol = TimMarketingGolHarga::all();

      $model = new TimMarketingGolHargaDetail();

      if($request->gol) $model = $model->where("gol_harga_id", $request->gol);
      if($request->aso) $model = $model->where("asosiasi_id", $request->aso);

      // $data['from'] = $from;
      $data['master_gol'] = $master_gol;
      $data['asosiasi'] = $asosiasi;
      $data['gol'] = $gol;
      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();

    	return view('team/marketing/gol_harga/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["gol_harga"] = TimMarketingGolHarga::all();
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["bidang"] = Bidang::all();
      $data['asosiasi'] = Asosiasi::all();

      return view('team/marketing/gol_harga/create')->with($data);
    }

    public function createHead()
    {
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");

      return view('team/marketing/gol_harga/create-head')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $timProduksi = new TimMarketingGolHargaDetail();

      $timProduksi->gol_harga_id = $request->gol_harga;
      $timProduksi->asosiasi_id = $request->asosiasi_id;
      $timProduksi->jenis_usaha_id = $request->jenis_usaha;
      $timProduksi->id_permohonan = $request->id_permohonan;
      $timProduksi->klasifikasi = $request->klasifikasi;
      $timProduksi->sub_klasifikasi = $request->sub_klasifikasi;
      $timProduksi->kualifikasi = $request->kualifikasi;
      $timProduksi->sub_kualifikasi = $request->sub_kualifikasi;
      $timProduksi->harga = $request->harga;
      $timProduksi->keterangan = $request->keterangan;
      $timProduksi->is_active = 1;
      $timProduksi->created_by = Auth::id();
      $timProduksi->updated_by = Auth::id();

      // dd($timProduksi);

      $timProduksi->save();

      return redirect('/gol_harga_marketing')->with('success', 'Golongan harga berhasil dibuat');

    }
    public function storeHead(Request $request)
    {
      $timProduksi = new TimMarketingGolHarga();

      $timProduksi->gol_harga = $request->gol_harga;
      $timProduksi->jenis_usaha_id = $request->jenis_usaha;
      $timProduksi->keterangan = $request->keterangan;
      $timProduksi->is_active = 1;
      $timProduksi->created_by = Auth::id();
      $timProduksi->updated_by = Auth::id();

      // dd($timProduksi);

      $timProduksi->save();

      return redirect('/gol_harga_marketing/create')->with('success', 'Golongan harga berhasil dibuat');

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
