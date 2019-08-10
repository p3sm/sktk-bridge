<?php

namespace App\Http\Controllers;

use App\SikiPersonal;
use App\SikiPersonalProyek;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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

    public function plain(Request $request, $id)
    {
        if(!$request->exists("ta") && !$request->exists("tt")){
            return redirect("/");
        }

        $data['sertifikatType'] = $request->exists("ta") ? "ta" : "tt";
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

    public function sync(Request $request, $id)
    {
        $date = Carbon::now();
        $personal = SikiPersonal::find($id);
        $no_npwp = false;
        $is_tt = $request->query("type") == "tt";

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/KTP.pdf")){
            return redirect()->back()->with('error', 'File KTP tidak tersedia');
        }

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/NPWP.pdf")){
            if($is_tt){
                $no_npwp = true;
            } else {
                return redirect()->back()->with('error', 'File NPWP tidak tersedia');
            }
        }

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/FOTO.png")){
            return redirect()->back()->with('error', 'File FOTO tidak tersedia (format .png)');
        }

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/SKEB.pdf")){
            return redirect()->back()->with('error', 'File SKEB tidak tersedia');
        }

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/CV.pdf")){
            return redirect()->back()->with('error', 'File CV tidak tersedia');
        }

        try{
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
            "jenis_tenaga_kerja"  => $request->query("type") == "ta" ? "tenaga_ahli" : "tenaga_terampil",
            "url_pdf_ktp"                             => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/KTP.pdf")),
            "url_pdf_npwp"                            => $is_tt && $no_npwp ? "" : curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/NPWP.pdf")),
            "url_pdf_photo"                           => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/FOTO.png")),
            "url_pdf_surat_pernyataan_kebenaran_data" => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/SKEB.pdf")),
            "url_pdf_daftar_riwayat_hidup"            => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $personal->id_personal . "/CV.pdf"))
            ];
        } catch(Exception $error) {
            return redirect()->back()->with('error', $error);
        }

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . env("LPJK_KEY");
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQ04xb1RyU3UwZDVIZmJ6OG81cTZ0Vg==";
        // $header[] = "Token:Rm1ydmpGbGQzcUxqR0J0Vis4cTlkZ1lKMUMzTDZDeEV5N2hZbVNSKzdGQk9JMm50Z1dKdW5SZlJLc1h0c0gyRA==";
        $header[] = "Token:Q0lLNkJYNHdqK3FxS0tZeEdUR2FYcTJRRWpiZ0N3ejhvcGRlRjd5blNrUlpGb0pBUi93MStNZkZzdTJMdTliOHZQV0JiTkp1UDZpOWxSdkVoVjM5YXc9PQ==";
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
        CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Biodata/Tambah",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        
        if($objResponse = json_decode($response)){
            if($objResponse->message == "Data Biodata Tersebut Sudah Pernah Didaftarkan !"){
                curl_setopt_array($curl, array(
                    CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Biodata/Ubah",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $postData,
                    CURLOPT_HTTPHEADER => $header,
                ));
                $response = curl_exec($curl);
            }
        }

        // dd($response);

        // echo $response;
        // exit;
        
		if($obj = json_decode($response)){
			if($obj->response) {
				return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
		}

        return redirect()->back()->with('error', "An error has occurred");
    }
}
