<?php

namespace App\Http\Controllers;

use App\Lib\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $obj_jwt;

    public function __construct()
    {
        $this->obj_jwt = new JWT();
    }
    
    function IssueToken(Request $req) {
        Log::debug("----IssueToken Start----");
        Log::debug("id : ", $req->only('id'));

        $token = $this->obj_jwt->createJWT($req->only('id'));
        Log::debug("token : ". $token);

        Log::debug("----IssueToken End----");

        $res = [
            'errflg' => 0,
            'token' => $token
        ];

        return response(json_encode($res), 200);
    }

    public function chk(Request $req)
    {
        $token = $req->header('Authorization');

        $res = [
            'errflg' => '0',
            'msg' => 'ok.'
        ];

        $status = 200;

        if( !$this->obj_jwt->chkToken($token)){
            $res = [
                'errflg' => '1',
                'msg' => '유효한 토큰이 아닙니다.'
            ];

            $status = 401;
        }

        return response(json_encode($res), $status);
    }
}
