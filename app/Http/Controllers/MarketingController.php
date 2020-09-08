<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Asosiasi;
use App\BadanUsaha;
use App\BentukUsaha;
use App\JenisUsaha;
use App\PjkLpjk;
use App\Bank;
use App\Team;
use App\TimProduksi;
use App\TimProduksiLevel;
use App\TimMarketing;
use App\TimMarketingLevel;
use App\TimMarketingGolHarga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
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

      $model = new TimMarketing();

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

    	return view('team/marketing/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["teams"] = Team::all()->sortBy("name");
      $data['tim_produksi'] = TimProduksi::all()->sortBy("name");
      $data["tim_produksi_level"] = TimProduksiLevel::all();
      $data['tim_marketing'] = TimMarketing::where("parent_id", null)->get()->sortBy("name");
      $data["tim_marketing_level"] = TimMarketingLevel::all();
      $data["tim_marketing_gol_harga"] = TimMarketingGolHarga::all()->sortBy("gol_harga");
      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["badan_usaha"] = BadanUsaha::all();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["pjk_lpjk"] = PjkLpjk::all();
      $data["banks"] = Bank::all();

      return view('team/marketing/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $produksi = TimProduksi::find($request->tim_produksi_id);

      if($request->parent_id == null){
        $existing = TimMarketing::where("parent_id", null)->where("tim_produksi_id", $request->tim_produksi_id)->get();
        $kode = $produksi->kode . "." . (count($existing) + 1);
      } else {
        $parent = TimMarketing::find($request->parent_id);
        $existing = TimMarketing::where("parent_id", $request->parent_id)->where("tim_produksi_id", $request->tim_produksi_id)->get();
        $kode = $parent->kode . "." . (count($existing) + 1);
      }

      // dd($kode);
      // dd($existing);

      $timProduksi = new TimMarketing();

      $timProduksi->tim_produksi_id = $request->tim_produksi_id;
      $timProduksi->parent_id = $request->level_id == 1 ? null : $request->parent_id;
      // $timProduksi->pjk_lpjk_id = $request->pjk3;
      $timProduksi->jenis_usaha_id = $request->jenis_usaha;
      $timProduksi->badan_usaha_id = $request->badan_usaha;
      $timProduksi->bentuk_usaha_id = $request->bentuk_usaha;
      $timProduksi->level_id = $request->level;
      $timProduksi->kualifikasi_type = $request->kualifikasi_type;
      $timProduksi->gol_harga_id = NULL;
      // $timProduksi->gol_harga = $request->gol_harga;
      $timProduksi->kode = $kode;
      $timProduksi->nama = $request->nama;
      $timProduksi->singkatan = $request->nama_singkat;
      $timProduksi->provinsi_id = $request->provinsi_id;
      $timProduksi->kota_id = $request->kota_id;
      $timProduksi->alamat = $request->alamat;
      $timProduksi->no_tlp = $request->no_telp;
      $timProduksi->email = $request->email;
      $timProduksi->web = $request->web;
      $timProduksi->instansi = $request->instansi;
      $timProduksi->pimpinan_nama = $request->pimpinan;
      $timProduksi->pimpinan_jabatan = $request->pimpinan_jabatan;
      $timProduksi->pimpinan_hp = $request->pimpinan_no;
      $timProduksi->pimpinan_email = $request->pimpinan_email;
      $timProduksi->kontak_p = $request->pic;
      $timProduksi->no_kontak_p = $request->pic_no;
      $timProduksi->jab_kontak_p = $request->pic_jabatan;
      $timProduksi->email_kontak_p = $request->pic_email;
      $timProduksi->npwp = $request->npwp;
      $timProduksi->npwp_pdf = $request->npwp_file;
      $timProduksi->rekening_no = $request->rek;
      $timProduksi->rekening_nama = $request->rek_name;
      $timProduksi->rekening_bank = $request->bank;
      $timProduksi->keterangan = $request->keterangan;
      $timProduksi->is_active = 1;
      $timProduksi->created_by = Auth::id();
      $timProduksi->updated_by = Auth::id();

      // dd($timProduksi);

      $timProduksi->save();

      return redirect('/marketing')->with('success', 'User berhasil dibuat');

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
