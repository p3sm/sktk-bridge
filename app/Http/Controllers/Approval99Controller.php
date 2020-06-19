<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApprovalTransaction;
use App\SikiAsosiasi;
use App\TeamKontribusiTa;
use App\TeamKontribusiTt;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use App\Pengajuan99;

class Approval99Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $data["results"] = Pengajuan99::whereNull('approved')->get();

    	return view('approval/approval_99/list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = $this->getKlasifikasi($id);
    	return view('approval/regta/list')->with($data);
    }

    public function getKlasifikasi($id)
    {
      
      $asosiasi = SikiAsosiasi::find($id);

      $postData = [
          "status_99" => 0,
          // "limit" => 10
        ];

      $curl = curl_init();
      $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
      $header[] = "Token:" . $asosiasi->apikey->token;
      $header[] = "Content-Type:multipart/form-data";
      curl_setopt_array($curl, array(
          CURLOPT_URL => config("app.lpjk_endpoint") . "Service/Klasifikasi/Get-TA",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $postData,
          CURLOPT_HTTPHEADER => $header,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0
      ));
      $response = curl_exec($curl);

      $obj = json_decode($response);
      
      if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
          if($this->refreshToken()){
              return $this->getKlasifikasi($id);
          } else {
              $result = new \stdClass();
              $result->message = "Error while refreshing token, please contact Administrator";
              $result->status = 401;

              return response()->json($result, 401);
          }
      }

      $data['response'] = $obj->response;
      $data['results'] = $obj->response > 0 ? $obj->result : [];
      $data['role'] = Auth::user()->role_id;

      return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function approve($id)
    {
        $pengajuan = Pengajuan99::find($id);
        // exit;
        // dd($request);
        // $asosiasiId = 142;
        $asosiasi = SikiAsosiasi::find(Auth::user()->asosiasi->asosiasi_id);
        // $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $pengajuan->id_personal,
          "id_sub_bidang"         => $pengajuan->sub_bidang,
          "id_kualifikasi"        => $pengajuan->kualifikasi,
          "id_unit_sertifikasi"   => $pengajuan->ustk,
          "tgl_permohonan"        => $pengajuan->tgl_registrasi,
          "tahun"                 => Carbon::parse($pengajuan->tgl_registrasi)->format("Y"),
          "id_provinsi"           => $pengajuan->provinsi,
          "id_permohonan"         => $pengajuan->id_permohonan,
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.lpjk_endpoint") . "Service/History/" . ($pengajuan->tipe_sertifikat == "SKA" ? "TA" : "TT"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        // dd($response);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
      
            if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
                if($this->refreshToken()){
                    return $this->approve($id);
                } else {
                    $result = new \stdClass();
                    $result->message = "Error while refreshing token, please contact Administrator";
                    $result->status = 401;
      
                    return response()->json($result, 401);
                }
            }
            
            if($obj->response) {
                $this->ApproveTransaction($pengajuan);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function ApproveTransaction($pengajuan){
        
        $pengajuanModel = Pengajuan99::find($pengajuan->id);
        $pengajuanModel->approved = 1;
        $pengajuanModel->approved_by = Auth::user()->id;
        $pengajuanModel->approved_at = Carbon::now();
        $pengajuanModel->save();
        
        if($pengajuan->tipe_sertifikat == "SKA"){
            $teamKontribusi = TeamKontribusiTa::where("team_id", $pengajuan->user->team_id)
            ->where("id_asosiasi_profesi", $pengajuan->asosiasi)
            ->where("id_propinsi_reg", $pengajuan->provinsi)
            ->where("id_kualifikasi", $pengajuan->kualifikasi)
            ->first();
        } else {
            $teamKontribusi = TeamKontribusiTt::where("team_id", $pengajuan->user->team_id)
            ->where("id_asosiasi_profesi", $pengajuan->asosiasi)
            ->where("id_propinsi_reg", $pengajuan->provinsi)
            ->where("id_kualifikasi", $pengajuan->kualifikasi)
            ->first();
        }

        $exist = ApprovalTransaction::where("tgl_registrasi", $pengajuan->tgl_registrasi)
                                    ->where("tipe_sertifikat", $pengajuan->tipe_sertifikat)
                                    ->where("id_personal", $pengajuan->id_personal)
                                    ->where("id_sub_bidang", $pengajuan->sub_bidang)
                                    ->where("id_asosiasi_profesi", $pengajuan->asosiasi)->first();
        
        if(!$exist){
            $approvalTrx                      = new ApprovalTransaction();
            $approvalTrx->id_asosiasi_profesi = $pengajuan->asosiasi;
            $approvalTrx->id_propinsi_reg     = $pengajuan->provinsi;
            $approvalTrx->team_id             = $pengajuan->user->team_id;
            $approvalTrx->tipe_sertifikat     = $pengajuan->tipe_sertifikat;
            $approvalTrx->id_personal         = $pengajuan->id_personal;
            $approvalTrx->nama                = $pengajuan->nama;
            $approvalTrx->id_sub_bidang       = $pengajuan->sub_bidang;
            $approvalTrx->id_unit_sertifikasi = $pengajuan->ustk;
            $approvalTrx->tgl_registrasi      = $pengajuan->tgl_registrasi;
            $approvalTrx->id_kualifikasi      = $pengajuan->kualifikasi;
            $approvalTrx->id_permohonan       = $pengajuan->id_permohonan;
            $approvalTrx->dpp_adm_anggota     = 0;
            $approvalTrx->dpp_kontribusi      = $teamKontribusi->kontribusi;
            $approvalTrx->dpp_total           = $teamKontribusi->kontribusi;
            $approvalTrx->created_by          = Auth::id();
            $approvalTrx->save();
        }
    }
}
