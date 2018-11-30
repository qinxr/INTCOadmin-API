<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
class AuthenticationController extends Controller
{
    /**
     * 权限认证相关接口
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 角色认证 判断是否是管理员 用于后台管理.
     * 
     * @access public 
     * @param  user_id       响应码
     * @return  true 是管理员  false 不是管理员
     */
    public static function isAdmin($user_id=null)
    {
        try 
        {
            $user = DB::table('users')
            ->where('id',$user_id)
            ->first();
            if($user)
            {
                if($user->hxbr_flag == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        catch (Exception $e) 
        {
            Log::info('服务器异常'.$e->getMessage());
        }
    }
    
}
