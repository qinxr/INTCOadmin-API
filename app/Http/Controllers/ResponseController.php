<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
class ResponseController extends Controller
{
    /**
     * 数据相应相关接口
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 数据相应.
     * 
     * @access public 
     * @param  responseCode       响应码
     * @param  responseMessage    响应信息
     * @param  data               响应数据
     * @param  dataTitle          响应标题
     */
    public static function response($responseCode,$responseMessage=null,$data = null,$dataTitle=null)
    {
        try 
        {
            return response()->json
            (
                [
                    'head'    => $responseCode,
                    'message' => $responseMessage,
                    'data'    => $data,
                    'dataTitle' => $dataTitle
                ]
            );
        }
        catch (Exception $e) 
        {
            return response()->json
            (
            [
                'head' => '520',
                'message' => '服务器端处理失败:数据响应',
                'data'    => null,
                'dataTitle' => null
            ]
            );
        }
    }
}
