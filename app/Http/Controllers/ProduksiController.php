<?php

namespace App\Http\Controllers;

use App\TeamKontribusiTa;
use App\Provinsi;
use App\Kota;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
      if($request->ubah){
          if($request->pilih_data){
            return redirect('produksi/' . $request->pilih_data[0] . '/edit');
          } else {
            return redirect('produksi')->with('error', 'Pilih data yang akan ubah');
          }
      }

      if($request->hapus){
          if($request->pilih_data){
              foreach($request->pilih_data as $res){
                $del = TimProduksi::findOrFail($res);
                if(!$del->delete()){
                  return redirect('produksi')->with('error', 'Gagal menghapus data');
                }
              }
              return redirect('produksi')->with('success', 'Data berhasil dihapus');
          } else {                
            return redirect('produksi')->with('error', 'Pilih data yang akan dihapus');
          }
      }
      // $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
      // $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();

      $model = new TimProduksi();

      // if($request->ktr) $model = $model->where("id_propinsi_reg", $request->ktr);
      if($request->prd) $model = $model->where(function ($query) use ($request) {
        $query->where("parent_id", $request->prd)
              ->orWhere("id", $request->prd);
      });
      if($request->prv) $model = $model->where("provinsi_id", $request->prv);
      // if($request->ins) $model = $model->where("instansi", $request->ins);
      if($request->pjk) $model = $model->where("pjk_lpjk_id", $request->pjk);
      if($request->lvl) $model = $model->where("level_id", $request->lvl);
      if($request->kot) $model = $model->where("kota_id", $request->kot);
      if($request->jnu) $model = $model->where("jenis_usaha_id", $request->jnu);

      // $data['from'] = $from;
      // $data['to'] = $to;
      $data['tim_produksi'] = TimProduksi::where("parent_id", null)->get()->sortBy("name");
      $data['provinsi'] = Provinsi::all();
      $data['pjklpjk'] = PjkLpjk::all();
      $data['level'] = TimProduksiLevel::all();
      $data['jenis_usaha'] = JenisUsaha::all()->sortBy("nama");
      $data['request'] = $request;
      $data['results'] = $model->get();
      $data['provinsi_data'] = Provinsi::all();

    	return view('team/produksi/index')->with($data);
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

      return view('team/produksi/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->parent_id == null){
        $existing = TimProduksi::where("parent_id", null)->get();
        $kode = (count($existing) + 1) . ".0";
      } else {
        $parent = TimProduksi::find($request->parent_id);
        $existing = TimProduksi::where("parent_id", $request->parent_id)->get();
        $kode = substr($parent->kode, 0, -2) . "." . (count($existing) + 1);
      }

      // dd($kode);
      // dd($existing);

      $timProduksi = new TimProduksi();

      $timProduksi->parent_id = $request->level_id == 1 ? null : $request->parent_id;
      $timProduksi->pjk_lpjk_id = $request->pjk3;
      $timProduksi->jenis_usaha_id = $request->jenis_usaha;
      $timProduksi->badan_usaha_id = $request->badan_usaha;
      $timProduksi->bentuk_usaha_id = $request->bentuk_usaha;
      $timProduksi->level_id = $request->level;
      $timProduksi->gol_harga_id = $request->gol_harga;
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

      return redirect('/produksi')->with('success', 'User berhasil dibuat');

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
      $data['data'] = TimProduksi::find($id);

      $data["teams"] = Team::all()->sortBy("name");
      $data['tim_produksi'] = TimProduksi::where("parent_id", null)->get()->sortBy("name");
      $data["tim_produksi_gol_harga"] = TimProduksiGolHarga::all()->sortBy("gol_harga");
      $data["tim_produksi_level"] = TimProduksiLevel::all();
      $data["asosiasi"] = Asosiasi::all()->sortBy("nama");
      $data["provinsi"] = Provinsi::all();
      $data["kota"] = Kota::where('provinsi_id', $data['data']->provinsi_id)->get();
      $data["badan_usaha"] = BadanUsaha::all();
      $data["bentuk_usaha"] = BentukUsaha::all()->sortBy("nama");
      $data["jenis_usaha"] = JenisUsaha::all()->sortBy("nama");
      $data["pjk_lpjk"] = PjkLpjk::all();
      $data["banks"] = Bank::all();

      return view('team/produksi/edit')->with($data);
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
      $timProduksi = TimProduksi::find($id);

      $timProduksi->parent_id = $request->level_id == 1 ? null : $request->parent_id;
      $timProduksi->pjk_lpjk_id = $request->pjk3;
      $timProduksi->jenis_usaha_id = $request->jenis_usaha;
      $timProduksi->badan_usaha_id = $request->badan_usaha;
      $timProduksi->bentuk_usaha_id = $request->bentuk_usaha;
      $timProduksi->level_id = $request->level;
      $timProduksi->gol_harga_id = $request->gol_harga;
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
      $timProduksi->updated_by = Auth::id();
      
      if($timProduksi->save())
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
        $item = TimProduksi::findOrFail($id);
        $item->delete();

        return redirect('/produksi')->with('success', 'User berhasil dihapus');
    }
}
