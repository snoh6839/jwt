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

        $response = [
            'errflg' => 0,
            'token' => $token
        ];

        return response();
    }
}
