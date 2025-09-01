<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

trait Responseable
{
    public $locale;
    public function __construct(){
        $this->locale=app()->getLocale();
    }




    private function apiResponse($status,$data=[],$message=null,$code=Response::HTTP_OK){
        return response()->json(
            [
                'status'=>$status,
                'data'=>[
                    'message'=>$message,
                    'content'=>$data?$data:(object)[]
                ]
            ],
            $code
        );
    }
}
