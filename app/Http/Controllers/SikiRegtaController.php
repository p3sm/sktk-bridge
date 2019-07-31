<?php

namespace App\Http\Controllers;

use App\SikiRegta;
use App\PersonalRegTaSync;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class SikiRegtaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['regtas'] = SikiRegta::take(100)->groupBy('tahap1')->orderByDesc("tgl_thp")->get();

    	return view('siki/regta/index')->with($data);
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
        $data['regtas'] = SikiRegta::where("tahap", $id)->orderByDesc("ID_Registrasi_TK_Ahli")->get();

    	return view('siki/regta/show')->with($data);
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

    public function createSyncLog($reg, $sync)
    {
        if($reg->sync){
            $data = PersonalRegTaSync::find($reg->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalRegTaSync();
        }

        $data->registrasi_tk_ahli_id = $reg->ID_Registrasi_TK_Ahli;
        $data->sync_id = $sync->ID_Registrasi_TK_Ahli;
        if($data->save())
            return true;
        else
            return false;
    }

    public function sync($id)
    {
        $reg = SikiRegta::find($id);

        $postData = [
          "id_registrasi_tk_ahli" => $reg->sync ? $reg->sync->sync_id : 0,
          "id_personal"           => $reg->ID_Personal,
          "id_sub_bidang"         => $reg->ID_Sub_Bidang,
          "id_asosiasi_profesi"   => $reg->ID_Asosiasi_Profesi,
          "id_kualifikasi"        => $reg->ID_Kualifikasi,
          "tgl_registrasi"        => $reg->Tgl_Registrasi,
          "id_propinsi_reg"       => $reg->ID_Propinsi_reg,
          "no_reg_asosiasi"       => "-",
          "id_unit_sertifikasi"   => $reg->id_unit_sertifikasi,
          "id_permohonan"         => $reg->id_permohonan,
          "url_pdf_surat_permohonan"          => asset("uploads/source/dokumen-upload/surat_permohonan-" . $reg->ID_Personal . ".pdf"),
          "url_pdf_berita_acara_vva"          => asset("uploads/source/dokumen-upload/berita_acara_vva-" . $reg->ID_Personal . ".pdf"),
          "url_pdf_surat_permohonan_asosiasi" => asset("uploads/source/dokumen-upload/surat_permohonan_asosiasi-" . $reg->ID_Personal . ".pdf"),
          "url_pdf_penilaian_mandiri_f19"     => asset("uploads/source/dokumen-upload/penilaian_mandiri_f19-" . $reg->ID_Personal . ".pdf"),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:Dev-Rest-API-2019";
        $header[] = "content-type:application/json";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://202.152.17.10/rest-api/Service/Klasifikasi/" . ($reg->sync ? "Ubah" : "Tambah") . "-TA/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                if($this->createSyncLog($reg, $obj))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
