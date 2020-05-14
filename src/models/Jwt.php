<?php
namespace src\models;
use core\Model;
use src\Config;

class Jwt extends Model{

    public function create($data){

        $header = json_encode(array("type" => "JWT", "alg" => "HS256"));

        $payload = json_encode($data);

        $hbase = $this->base64url_encode($header);
        $pbase = $this->base64url_encode($payload);

        $signature = hash_hmac("sha256", $hbase.".".$pbase, Config::SECRET_KEY_JWT, true);
        $bsig = $this->base64url_encode($signature);

        $jwt = $hbase.".".$pbase.".".$bsig;

        return $jwt;

    }

    public function validate($jwt){

        $array = array();

        $jwt_splits = explode('.', $jwt);

        if(count($jwt_splits) == 3){
            $signature = hash_hmac("sha256", $jwt_splits[0].".".$jwt_splits[1], Config::SECRET_KEY_JWT, true);
            $bsig = $this->base64url_encode($signature);

            if($bsig == $jwt_splits[2]){
                $array = json_decode($this->base64url_dencode($jwt_splits[1]));
            }
        }

        return $array;

    }

    private function base64url_encode($data){
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64url_dencode($data){
        return base64_decode(strtr($data, '-_', '+/').str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }

}
