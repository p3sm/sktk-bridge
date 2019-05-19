<?php

namespace App\Http\Controllers;

use App\SikiPersonalProyek;
use App\PersonalProyekSync;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class SikiProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    public function createSyncLog($proyek, $sync)
    {
        if($proyek->sync){
            $data = PersonalProyekSync::find($proyek->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalProyekSync();
        }

        $data->personal_proyek_id = $proyek->id_personal_proyek;
        $data->sync_id = $sync->id_personal_proyek;
        if($data->save())
            return true;
        else
            return false;
    }

    public function sync($id)
    {
        $proyek = SikiPersonalProyek::find($id);

        $postData = [
            "id_personal_proyek"                    => $proyek->sync ? $proyek->sync->sync_id : 0,
            "id_personal"                           => $proyek->id_personal,
            "nama_proyek"                           => $proyek->Proyek,
            "lokasi"                                => $proyek->Lokasi,
            "tgl_mulai"                             => $proyek->Tgl_Mulai,
            "tgl_selesai"                           => $proyek->Tgl_Selesai,
            "jabatan"                               => $proyek->Jabatan,
            "nilai_proyek"                          => $proyek->Nilai,
            "url_pdf_persyaratan_pengalaman_proyek" => asset("uploads/source/dokumen-upload/ijazah-" . $proyek->id_personal . ".pdf"),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:Dev-Rest-API-2019";
        $header[] = "content-type:application/json";
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://202.152.17.10/rest-api/Service/Proyek/" . ($proyek->sync ? "Ubah" : "Tambah"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                if($this->createSyncLog($proyek, $obj))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
