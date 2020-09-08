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

class BadanUsahaController extends Controller
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

      $model = new BadanUsaha();

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

    	return view('badanusaha/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data["teams"] = Team::all()->sortBy("name");
      $data['tim_produksi'] = TimProduksi::where("parent_id", null)->get()->sortBy("name");
      $data["tim_produksi_gol_harga"] = TimProduksiGolHarga::all()->sortBy("gol_harga");
      $data["tim_produksi_level"] = TimProduksiLevel::all();
      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["badan_usaha"] = BadanUsaha::all();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["pjk_lpjk"] = PjkLpjk::all();
      $data["banks"] = Bank::all();
      $data["status_kantor"] = StatusKantor::all();

      return view('badanusaha/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $bu = new BadanUsaha();

      $bu->jenis_usaha_id = $request->jenis_usaha;
      $bu->asosiasi_id = $request->asosiasi;
      $bu->status_kantor_proyek = $request->status_kantor;
      $bu->bentuk_usaha_id = $request->bentuk_usaha;
      $bu->nama = $request->nama;
      $bu->singkatan = $request->nama_singkat;
      $bu->provinsi_id = $request->provinsi_id;
      $bu->kota_id = $request->kota_id;
      $bu->alamat = $request->alamat;
      $bu->no_tlp = $request->no_telp;
      $bu->email = $request->email;
      $bu->web = $request->web;
      $bu->instansi = $request->instansi;
      $bu->pimpinan_nama = $request->pimpinan;
      $bu->pimpinan_jabatan = $request->pimpinan_jabatan;
      $bu->pimpinan_hp = $request->pimpinan_no;
      $bu->pimpinan_email = $request->pimpinan_email;
      $bu->kontak_p = $request->pic;
      $bu->no_kontak_p = $request->pic_no;
      $bu->jab_kontak_p = $request->pic_jabatan;
      $bu->email_kontak_p = $request->pic_email;
      $bu->npwp = $request->npwp;
      $bu->npwp_pdf = $request->npwp_file;
      $bu->rekening_no = $request->rek;
      $bu->rekening_nama = $request->rek_name;
      $bu->rekening_bank = $request->bank;
      $bu->keterangan = $request->keterangan;
      $bu->is_active = 1;
      $bu->created_by = Auth::id();
      $bu->updated_by = Auth::id();

      $bu->save();

      return redirect('/master_badanusaha')->with('success', 'Badan Usaha berhasil dibuat');

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
