<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Code as Code;
use App\Live as Live;

class Controller extends BaseController
{
    //Validate code with code in backend
    private function codeIsValid($code) {
        if(Code::where('code', $code)->first()) {
            return true;
        }
        return false;
    }

    //Validate code and return response
    public function validateCode(Request $request) {
        if ($this->codeIsValid($request->input('code'))) {
            return response('', 204);
        }
        return response()->json(['message' => 'Code was incorrect'], 400);
    }

    //Set stream time with request body
    public function setStreamTime(Request $request) {
        if (!$this->codeIsValid($request->header('code'))) {
            return response()->json(['message' => 'Code is not valid'], 401);
        }
        try {
            $live = Live::all()->first()->update($request->all());
            return response($live, 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    //Get stream details
    public function getStreamInfo() {
        try {
            return response(Live::all()->first(), 200);
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }
}
