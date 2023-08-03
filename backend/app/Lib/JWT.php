<?php

namespace App\Lib;

use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\ThrowableUtils;

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
        return $header.".".$payload.".".$signature;
    }

    public function chkToken($token)
    {
        Log::debug("----chkToken Start----");
        try {
            $arr_token = explode("." , $token);

            $header = $arr_token[0];
            $payload = $arr_token[1];
            $signature = $arr_token[2];

            $arr_payload = json_decode(base64_decode($payload));
            Log::debug("exp : " . $arr_payload->exp);
            
            if (time() > $arr_payload->exp) {
                throw new Exception("인증 실패, 유효시간 초과");
            }

            Log::debug("signature : " . $signature);

            $verify = hash($this->alg, $header . $payload . $this->secret_key);

            // if($signature !== $verify) {
            //     return false;
            // } else {
            //     return true;
            // }

            Log::debug("verify : " . $verify);
            if ($signature !== $verify) {
                throw new Exception("인증 실패, 토큰이 일치하지 않습니다");
            }
        } catch (Exception $e) {
            Log::debug("Error : ". $e->getMessage() );
            return false;
        } finally {
            Log::debug("----chkToken End----");
        }
        
        return true;
    }

    
}

?>