<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\SikiPropinsi;
use App\TeamProvinsi;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApprovalController extends Controller
{
    public $asosiasi_id = 0;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('approval/report/index');
    }

    public function show(Request $request, $id)
    {
      $this->asosiasi_id = $id;
      $user = Auth::user();
      
      $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
      $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();

      $report = [];
      $propinsi = SikiPropinsi::orderBy("ID_Propinsi")->get();

      foreach($propinsi as $pr){
        $obj = new \stdClass;
        $obj->id = $pr->ID_Propinsi;
        $obj->name = $pr->Nama;
        $obj->nick = $pr->Nama_Singkat;
        $obj->team = $this->getTeamProvinsi($pr->ID_Propinsi, $from, $to);

        $report[] = $obj;
      }

      $data['report'] = $report;
      $data['from'] = $from;
      $data['to'] = $to;

    	return view('approval/report/provinsi')->with($data);
    }

    public function detail(Request $request)
    {
      $user = Auth::user();
      
      $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
      $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
      $provinsi = $request->prv;
      $tim = $request->tim;
      $asosiasi = $request->aso;

      if($asosiasi || $provinsi || $tim){
        $model = ApprovalTransaction::whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
        ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'))
        ->orderByDesc("created_at");

        if($asosiasi) $model = $model->where("id_asosiasi_profesi", $asosiasi);
        if($provinsi) $model = $model->where("id_propinsi_reg", $provinsi);
        if($tim) $model = $model->where("team_id", $tim);

        $data['transactions'] = $model->get();
      } else {
        $data['transactions'] = [];
      }

      $data['from'] = $from;
      $data['to'] = $to;
      $data['asosiasi'] = $asosiasi;
      $data['provinsi'] = $provinsi;
      $data['tim'] = $tim;
      $data['tim_data'] = Team::all();
      $data['provinsi_data'] = SikiPropinsi::all();

    	return view('approval/report/list')->with($data);
    }

    private function getTeamProvinsi($id_provinsi, $from, $to){
      $data = [];

      foreach(TeamProvinsi::where("provinsi_id", $id_provinsi)->where("asosiasi_id", $this->asosiasi_id)->get() as $pr){
        $obj = new \stdClass;
        $obj->id = $pr->team_id;
        $obj->name = $pr->team->name;
        $obj->transaction = $this->getTeamTransaction($id_provinsi, $pr->team_id, $from, $to);

        $data[] = $obj;
      }

      return $data;
    }

    private function getTeamTransaction($id_provinsi, $team_id, $from, $to){
      $obj = new \stdClass;
      $obj->ska = $this->getSKATransaction($id_provinsi, $team_id, $from, $to);
      $obj->skt = $this->getSKTTransaction($id_provinsi, $team_id, $from, $to);
      $obj->total = $this->getTotalTransaction($id_provinsi, $team_id, $from, $to);

      return $obj;
    }

    private function getSKATransaction($id_provinsi, $team_id, $from, $to){
      $obj = new \stdClass;
      $obj->pemohon = $this->getJumlahPemohon("SKA", $id_provinsi, $team_id, $from, $to);
      $obj->jumlah = $this->getJumlahPermohonan("SKA", $id_provinsi, $team_id, $from, $to);
      $obj->muda = $this->getJumlahKualifikasi("SKA", $id_provinsi, $team_id, 3, $from, $to);
      $obj->madya = $this->getJumlahKualifikasi("SKA", $id_provinsi, $team_id, 2, $from, $to);
      $obj->utama = $this->getJumlahKualifikasi("SKA", $id_provinsi, $team_id, 1, $from, $to);
      $obj->kontribusi = $this->getKontribusi("SKA", $id_provinsi, $team_id, $from, $to);
      $obj->total = $this->getTotal("SKA", $id_provinsi, $team_id, $from, $to);

      return $obj;
    }

    private function getSKTTransaction($id_provinsi, $team_id, $from, $to){
      $obj = new \stdClass;
      $obj->pemohon = $this->getJumlahPemohon("SKT", $id_provinsi, $team_id, $from, $to);
      $obj->jumlah = $this->getJumlahPermohonan("SKT", $id_provinsi, $team_id, $from, $to);
      $obj->kelas3 = $this->getJumlahKualifikasi("SKT", $id_provinsi, $team_id, 3, $from, $to);
      $obj->kelas2 = $this->getJumlahKualifikasi("SKT", $id_provinsi, $team_id, 2, $from, $to);
      $obj->kelas1 = $this->getJumlahKualifikasi("SKT", $id_provinsi, $team_id, 1, $from, $to);
      $obj->kontribusi = $this->getKontribusi("SKT", $id_provinsi, $team_id, $from, $to);
      $obj->total = $this->getTotal("SKT", $id_provinsi, $team_id, $from, $to);

      return $obj;
    }

    private function getTotalTransaction($id_provinsi, $team_id, $from, $to){
      $obj = new \stdClass;
      $obj->pemohon = $this->getJumlahPemohon("all", $id_provinsi, $team_id, $from, $to);
      $obj->jumlah = $this->getJumlahPermohonan("all", $id_provinsi, $team_id, $from, $to);
      $obj->muda = $this->getJumlahKualifikasi("all", $id_provinsi, $team_id, 3, $from, $to);
      $obj->madya = $this->getJumlahKualifikasi("all", $id_provinsi, $team_id, 2, $from, $to);
      $obj->utama = $this->getJumlahKualifikasi("all", $id_provinsi, $team_id, 1, $from, $to);
      $obj->kontribusi = $this->getKontribusi("all", $id_provinsi, $team_id, $from, $to);
      $obj->total = $this->getTotal("all", $id_provinsi, $team_id, $from, $to);

      return $obj;
    }

    private function getJumlahPemohon($tipe, $id_provinsi, $team_id, $from, $to){
      $model = ApprovalTransaction::where("id_propinsi_reg", $id_provinsi);
      
      if($tipe !== "all")
        $model = $model->where("tipe_sertifikat", $tipe);

      $transaction = $model->where("team_id", $team_id)
                      ->where("id_asosiasi_profesi", $this->asosiasi_id)
                      ->whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
                      ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'))
                      ->groupBy("id_personal")
                      ->get();

      return count($transaction);
    }

    private function getJumlahPermohonan($tipe, $id_provinsi, $team_id, $from, $to){
      $model = ApprovalTransaction::where("id_propinsi_reg", $id_provinsi);
      
      if($tipe !== "all")
        $model = $model->where("tipe_sertifikat", $tipe);

      $transaction = $model->where("team_id", $team_id)
                      ->where("id_asosiasi_profesi", $this->asosiasi_id)
                      ->whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
                      ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'))
                      ->count();

      return $transaction;
    }

    private function getJumlahKualifikasi($tipe, $id_provinsi, $team_id, $kualifikasi_id, $from, $to){
      $model = ApprovalTransaction::where("id_propinsi_reg", $id_provinsi);
      
      if($tipe !== "all")
        $model = $model->where("tipe_sertifikat", $tipe);

      $transaction = $model->where("team_id", $team_id)
                      ->where("id_kualifikasi", $kualifikasi_id)
                      ->where("id_asosiasi_profesi", $this->asosiasi_id)
                      ->whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
                      ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'))
                      ->count();

      return $transaction;
    }

    private function getKontribusi($tipe, $id_provinsi, $team_id, $from, $to){
      $model = ApprovalTransaction::where("id_propinsi_reg", $id_provinsi);
      
      if($tipe !== "all")
        $model = $model->where("tipe_sertifikat", $tipe);

      $transaction = $model->where("team_id", $team_id)
                      ->where("id_asosiasi_profesi", $this->asosiasi_id)
                      ->whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
                      ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'))
                      ->sum("dpp_kontribusi");

      return $transaction;
    }

    private function getTotal($tipe, $id_provinsi, $team_id, $from, $to){
      $model = ApprovalTransaction::where("id_propinsi_reg", $id_provinsi);
      
      if($tipe !== "all")
        $model = $model->where("tipe_sertifikat", $tipe);

      $transaction = $model->where("team_id", $team_id)
                      ->where("id_asosiasi_profesi", $this->asosiasi_id)
                      ->whereDate("tgl_registrasi", ">=", $from->format('Y-m-d'))
                      ->whereDate("tgl_registrasi", "<=", $to->format('Y-m-d'))
                      ->sum("dpp_total");

      return $transaction;
    }
}
