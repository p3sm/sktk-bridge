<?php

namespace App\Http\Controllers;

use App\SikiAsosiasi;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalRegtaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	return view('approval/regta/index');
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
        $asosiasi = SikiAsosiasi::find($id);

        $postData = [
            "status_99" => 0,
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Klasifikasi/Get-TA?status_99=0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);

        $data['response'] = $obj->response;
        $data['results'] = $obj->response > 0 ? $obj->result : [];

    	return view('approval/regta/list')->with($data);
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

    public function approve(Request $request, $id)
    {
        // dd($request);
        // $asosiasiId = 142;
        $asosiasi = SikiAsosiasi::find($id);
        // $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $request->query('ID_Personal'),
          "id_sub_bidang"         => $request->query('ID_Sub_Bidang'),
          "id_kualifikasi"        => $request->query('ID_Kualifikasi'),
          "id_unit_sertifikasi"   => $request->query('id_unit_sertifikasi'),
          "tgl_permohonan"        => $request->query('Tgl_Registrasi'),
          "tahun"                 => Carbon::parse($request->query('Tgl_Registrasi'))->format("Y"),
          "id_provinsi"           => $request->query('ID_Propinsi_reg'),
          "id_permohonan"         => $request->query('id_permohonan'),
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/History/TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        // dd($response);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // if($this->createApproveLog($reg))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
