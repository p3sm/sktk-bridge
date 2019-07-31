<?php

namespace App\Http\Controllers;

use App\SikiPersonal;
use App\SikiPersonalProyek;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class SikiPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['personals'] = SikiPersonal::take(100)->orderByDesc("tgl_update")->get();

    	return view('siki/personal/index')->with($data);
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
        $data['personal'] = SikiPersonal::find($id);

    	return view('siki/personal/show')->with($data);
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

    public function plain($id)
    {
        $data['personal'] = SikiPersonal::find($id);

        return view('siki/personal/plain')->with($data);
    }

    public function proyek($id)
    {
        $data['personal'] = SikiPersonal::find($id);

    	return view('siki/personal/proyek')->with($data);
    }

    public function pendidikan($id)
    {
        $data['personal'] = SikiPersonal::find($id);

    	return view('siki/personal/pendidikan')->with($data);
    }

    public function sync($id)
    {
        $personal = SikiPersonal::find($id);
        dd($personal);

        $postData = [
        "id_personal"         => (string) $personal->id_personal,
        "no_ktp"              => $personal->No_KTP,
        "nama"                => $personal->Nama,
        "nama_tanpa_gelar"    => $personal->nama_tanpa_gelar,
        "alamat"              => $personal->Alamat1,
        "kodepos"             => "-",
        "id_kabupaten_alamat" => $personal->ID_Kabupaten_Alamat,
        "tgl_lahir"           => $personal->Tgl_Lahir,
        "jenis_kelamin"       => $personal->jenis_kelamin == "PRIA" ? "L" : "P",
        "tempat_lahir"        => $personal->Tempat_Lahir,
        "id_kabupaten_lahir"  => $personal->ID_Kabupaten_Alamat,
        "id_propinsi"         => $personal->ID_Propinsi,
        "npwp"                => $personal->npwp,
        "email"               => $personal->email,
        "no_hp"               => $personal->hp_personal,
        "id_negara"           => $personal->nm_ibu_kandung,
        "url_pdf_ktp"                             => curl_file_create(realpath("uploads/source/dokumen-upload/" . $personal->id_personal . "/ktp.pdf")),
        "url_pdf_npwp"                            => curl_file_create(realpath("uploads/source/dokumen-upload/" . $personal->id_personal . "/npwp.pdf")),
        "url_pdf_photo"                           => curl_file_create(realpath("uploads/source/dokumen-upload/" . $personal->id_personal . "/foto.pdf")),
        "url_pdf_surat_pernyataan_kebenaran_data" => curl_file_create(realpath("uploads/source/dokumen-upload/" . $personal->id_personal . "/skpd.pdf")),
        "url_pdf_daftar_riwayat_hidup"            => curl_file_create(realpath("uploads/source/dokumen-upload/" . $personal->id_personal . "/drh.pdf"))
        ];
        
        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:ASTEKINDO-API";
        $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlka3d4aDluTUlzWlBUQ21Jcm9XR3JSQU1DNGFiTVBMOS82WllHY3lCVWttSw==";
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://dev.lpjk.net/slim-api/Service/Biodata/Tambah",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        // dd($response);
        
		if($obj = json_decode($response)){
			if($obj->response) {
				return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
		}

        return redirect()->back()->with('error', "An error has occurred");
    }
}
