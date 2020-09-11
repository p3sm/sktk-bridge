<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\AsosiasiKey;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function refreshToken(){
        $key = AsosiasiKey::where('asosiasi_id', Auth::user()->myAsosiasi()->asosiasi_id)->first();

        $postData = [
            "X-Api-Key" => $key->lpjk_key,
            "Username" => $key->lpjk_username
          ];

        $curl = curl_init();
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "AktivasiToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);

        if($obj->response == 1){
            $key->token = $obj->token;
            $key->token_expired = Carbon::createFromFormat("d-m-Y", $obj->tanggal_expired);
            $key->save();

            return true;
        }

    	return false;
    }
}
