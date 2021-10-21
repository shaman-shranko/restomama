<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SEOController extends Controller
{
    public static function removeFirstPageParametr($url){
        $arr = explode('?', $url);
        $params = explode('&',$arr[1]);
        $param_string = "";
        foreach ($params as $key => $param){
            if($param !== "page=1"){
                $param_string .= $param;
                if($key !== array_key_last($params)){
                    $param_string .= "&";
                }
            }
        }
        if(strlen($param_string) > 0){
            $link = $arr[0]."?".$param_string;
        }else{
            $link = $arr[0];
        }
        return $link;
    }
}
