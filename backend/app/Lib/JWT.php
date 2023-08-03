<?php

namespace App\Lib;

use Illuminate\Support\Facades\Log;

class JWT{
    protected $alg = 'SHA256';
    protected $secret_key = 'php506';

    public function createJWT(array $data)
    {
        Log::debug("----createJWT Start----");


        $header_json = json_encode([
            'alg' => $this->alg,
            'typ' => 'JWT'
        ]);

        $header = base64_encode($header_json);

        Log::debug("header : ". $header);

        $iat = time();
        $exp = $iat + 60;
        
        $payload_json = json_encode([
            'id' => $data['id'],
            'iat' => $iat,
            'exp' => $exp
        ]);

        $payload = base64_encode($payload_json);

        Log::debug("payload : " . $payload);

        $signature = hash($this->alg, $header.$payload.$this->secret_key);

        Log::debug("signature : " . $signature);

        Log::debug("----createJWT End----");
        return $header.",".$payload.",".$signature;
    }
}

?>