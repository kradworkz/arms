<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;

class DeviceController extends Controller
{
    public function login(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.79:8080/api/internal/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{  \n   \"email\": \"$username\",  \n   \"password\": \"$password\"  \n }");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        return $result;
    }

    public function check(Request $request){
        $token = $request->input('toks');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.79:8080/api/applications?limit=10');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Grpc-Metadata-Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        return $result;
    }

    public function devices(Request $request){
        $token = $request->input('toks');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.79:8080/api/devices?limit=10&applicationID=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Grpc-Metadata-Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
       
        $res = json_decode($result);
        if(isset($res->code)){
            if($res->code == 16){
                return $result;
            }
        }else{
            return ApiResource::collection($res->result);
        }
    }
    
    public function search(Request $request){
        $token = $request->input('toks');
        $keyword = $request->input('keyword');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.79:8080/api/devices?limit=5&applicationID=1&search='.$keyword);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Grpc-Metadata-Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        
        $res = json_decode($result);
        if(isset($res->code)){
            if($res->code == 16){
                return $result;
            }
        }else{
            return ApiResource::collection($res->result);
        }
    }
}
