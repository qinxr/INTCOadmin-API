<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\ResponseController as Response;
class PadController extends Controller
{
    /**
     * pad管理增、删、改、查 相关接口
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('cors');
    }

     /**
     * 获取pad信息
     *
     * @return pad信息
     */
    public function getPadInfos()
    {
        
        try 
        {
            $pads = DB::table('pad_admin')
            ->select('id','num','pad_num','pad_type','pad_detail','pad_state','description')
            ->where('flag','1')
            ->get()
            ->toArray();
            Log::info('pad信息获取');
            return Response::response(200,'pad信息获取成功',$pads);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'pad信息获取失败');
        }
    }
    /**
     * 新增pad.
     * post
     * @access public 
     * @param  pad_num		pad序列号
     * @param  pad_type		pad型号
     * @param  pad_state		状态
     * @return 200      	pad增加成功 
     *         210      	pad增加失败
     *         520      	服务器端处理失败:pad新增
     *         211      	项目新增失败：缺少必要参数
     */
    public function addPadInfo(Request $request)
    {
        try 
        {
//          
            //编号 必须输入
            $num = $request->input('num');
            //详细参数 必须输入
            $pad_detail = $request->input('pad_detail');
            //pad序列号 必须输入
            $pad_num = $request->input('pad_num');
            //pad型号 必须输入
            $pad_type = $request->input('pad_type');
            //pad状态
            $pad_state = $request->input('pad_state');
            //描述
            $description = $request->input('description');
            //判断是否为空
            if($pad_num!= ''&&$pad_type!= ''&&$pad_state!= ''&&$num!= ''&&$pad_detail!= '')
            {
                //项目类型插入数据库
                $flag = DB::table('pad_admin')
                ->insert(
                [
                    
                    'num'     => $num,
                    'pad_num'     => $pad_num,
                    'pad_detail'     => $pad_detail,
                    'pad_type'     => $pad_type,
                    'pad_state'     => $pad_state,
                    'description'     => $description,
                ]
                );
               	$pads = DB::table('pad_admin')
            	->select('id','num','pad_num','pad_type','pad_detail','pad_state','description')
            	->where('flag','1')
            	->get()
           		 ->toArray();
                Log::info('新增pad');
                return Response::response(200,'pad新增成功',$pads);
            }
            else
            {
                return Response::response(211,'pad新增失败：缺少必要参数');
            }
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:pad新增');
        }
    }
    
    /**
     * 获取指定pad.(根据id)
     * get
     * @access public
     * @param  integer  id  项目id
     * @return 200      查询信息成功 
     *                  指定id信息数据
     *         212      信息查询失败 未输入id
     *         213      信息查询失败 指定id信息未找到
     *         520      服务器端处理失败:指定id信息查询
     */
    public function getPadAsId($id = null)
    {
        try 
        {
            
            if(!$id)
            {
                return Response::response(212,'指定id信息查询失败,未输入指定id');
            }
            $pad = DB::table('pad_admin')
                ->where('id',$id)
                ->select('id','num','pad_num','pad_detail','pad_type','pad_state','description')
                ->first();
            if(!$pad)
            {
                return Response::response(213,'指定id信息查询失败,未找到指定id信息');
            }
            return Response::response(200,'指定id信息查询成功',$pad);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定id信息查询');
        }
    }
    
    /**
     * 获取指定pad(根据序列号).
     * get
     * @access public
     * @param  num      序列号
     * @return 200      查询信息成功 
     *                  指定id信息数据
     *         212      信息查询失败 未输入id
     *         213      信息查询失败 指定id信息未找到
     *         520      服务器端处理失败:指定id信息查询
     */
    public function getPadAsNum($num = null)
    {
        try 
        {
            
            if(!$num)
            {
                return Response::response(212,'指定num信息查询失败,未输入指定信息');
            }
            $pad = DB::table('pad_admin')
                ->where('id',$num)
                ->select('pad_num','pad_detail','pad_type','pad_state','description')
                ->first();
            if(!$pad)
            {
                return Response::response(213,'指定num信息查询失败,未找到指定id信息');
            }
            return Response::response(200,'指定型号信息查询成功',$pad);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定num信息查询');
        }
    }
    
    
	/**
     * 修改pad信息.
     * post
     * @access public 
     * @param  pad_num		pad序列号
     * @param  pad_type		pad型号
     * @param  pad_state		状态
     * @return 200      pad修改成功 
     *                  所有pad信息
     *         520      服务器端处理失败:pad修改
     *         211      pad修改失败：缺少必要参数
     *         212      pad修改失败：缺少指定id
     */
    public function editPad(Request $request,$id=null)
    {
        try 
        {
//         
            if(!$id)
            {
                return Response::response(212,'pad修改失败,未输入指定id');
            }
            //自定义编号 必须输入
            $num = $request->input('num');
            //详细参数 必须输入
            $pad_detail = $request->input('pad_detail');
            //pad序列号 必须输入
            $pad_num = $request->input('pad_num');
            //pad型号 必须输入
            $pad_type = $request->input('pad_type');
            //pad状态
            $pad_state = $request->input('pad_state');
            //描述
            $description = $request->input('description');
            
            if($pad_num!= ''&&$pad_type!= ''&&$pad_state!= ''&&$num!= ''&&$pad_detail!= '')
            {
                
                //电脑管理更新 数据库
                $flag = DB::table('pad_admin')
                ->where('id',$id)
                ->update(
                [	
                	'num'     => $num,
                    'pad_num'     => $pad_num,
                    'pad_detail'     => $pad_detail,
                    'pad_type'     => $pad_type,
                    'pad_state'     => $pad_state,
                    'description'     => $description,
                ]
                );
                $pads = DB::table('pad_admin')
            ->select('id','num','pad_num','pad_detail','pad_type','pad_state','description')
            ->where('flag','1')
            ->get()
            ->toArray();
                return Response::response(200,'pad修改成功',$pads);
            }
            else
            {
                return Response::response(211,'pad修改失败：缺少必要参数');
            }
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:pad修改');
        }
    }
	/**
     * 删除指定id信息.
     * post
     * @access public
     * @param  integer  id  
     * @return 200      pad删除成功 
     *                  所有pad数据
     *         212      pad删除失败 未输入指定id
     *         520      服务器端处理失败:pad删除
     */
    public function deletePad(Request $request)
    {
        try 
        {
            $delete_id = $request->input('delete_id');
            if(!$delete_id)
            {
                return Response::response(212,'pad删除失败,未输入指定id');
            }
           
                
            //假删除  删除标志位改为2
                $flag = DB::table('pad_admin')
                ->where('id',$delete_id)
                ->update(
                [
                    
                    'flag'     => '2',
                ]
                );    
            
           $pads = DB::table('pad_admin')
            ->select('id','num','pad_num','pad_detail','pad_type','pad_state','description')
            ->where('flag','1')
            ->get()
            ->toArray();
            
            
            return Response::response(200,'pad删除成功',$pads);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定pad删除');
        }
    }
	/**
     * 归还pad（根据序列号[pad_num]）
     * post
     * @access public
     * @param  pad_num  	序列号  
     * @return 200      pad归还成功 
     *                  所有pad数据
     *         212      pad归还失败 未输入指定id
     *         520      服务器端处理失败:pad删除
     */
	public function backPad(Request $request)
    {
        try 
        {
            $pad_num = $request->input('pad_num');
            $id = $request->input('id');
            if(!$pad_num)
            {
                return Response::response(212,'归还失败,缺少参数');
            }
            
            //电脑管理更新 数据库
                $flag = DB::table('pad_admin')
                ->where('pad_num',$pad_num)
                ->update(
                [
                    'pad_state'     => 1,
                ]
                );
                //人员表更新  (添加归还日期)
                $flag2 = DB::table('users')
                ->where('id',$id)
                ->update(
                [
                    'back_date'     => now(),
                ]
                );
            	$users = DB::table('users')
	            ->select('id','name','job_num','dept','job','ent_date','dim_date','pad_num','pad_type','pc_date','get_date','back_date','description')
	            ->where('flag','1')
	            ->get()
	            ->toArray();
            
            
            return Response::response(200,'pad归还成功',$users);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:pad归还');
        }
    }


}
