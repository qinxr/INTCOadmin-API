<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\ResponseController as Response;
class PcController extends Controller
{
    /**
     * 计算机管理增、删、改、查 相关接口
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('cors');
    }

     /**
     * 获取计算机信息
     *
     * @return 计算机信息
     */
    public function getPcInfos()
    {
        
        try 
        {
            $pcs = DB::table('pc_admin')
            ->select('id','num','pc_num','pc_type','pc_detail','pc_state','description')
            ->where('flag','1')
            ->get()
            ->toArray();
            Log::info('计算机信息获取');
            return Response::response(200,'计算机信息获取成功',$pcs);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'计算机信息获取失败');
        }
    }
    /**
     * 新增计算机.
     * post
     * @access public 
     * @param  pc_num		计算机序列号
     * @param  pc_type		计算机型号
     * @param  pc_state		状态
     * @return 200      	计算机增加成功 
     *         210      	计算机增加失败
     *         520      	服务器端处理失败:计算机新增
     *         211      	项目新增失败：缺少必要参数
     */
    public function addPcInfo(Request $request)
    {
        try 
        {
//          
            //编号 必须输入
            $num = $request->input('num');
            //详细参数 必须输入
            $pc_detail = $request->input('pc_detail');
            //计算机序列号 必须输入
            $pc_num = $request->input('pc_num');
            //计算机型号 必须输入
            $pc_type = $request->input('pc_type');
            //计算机状态
            $pc_state = $request->input('pc_state');
            //判断是否为空
            if($pc_num!= ''&&$pc_type!= ''&&$pc_state!= ''&&$num!= ''&&$pc_detail!= '')
            {
                //项目类型插入数据库
                $flag = DB::table('pc_admin')
                ->insert(
                [
                    
                    'num'     => $num,
                    'pc_num'     => $pc_num,
                    'pc_detail'     => $pc_detail,
                    'pc_type'     => $pc_type,
                    'pc_state'     => $pc_state,
                ]
                );
               	$pcs = DB::table('pc_admin')
            	->select('id','num','pc_num','pc_type','pc_detail','pc_state','description')
            	->where('flag','1')
            	->get()
           		 ->toArray();
                Log::info('新增计算机');
                return Response::response(200,'计算机新增成功',$pcs);
            }
            else
            {
                return Response::response(211,'计算机新增失败：缺少必要参数');
            }
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:计算机新增');
        }
    }
    
    /**
     * 获取指定计算机.
     * get
     * @access public
     * @param  integer  id  项目id
     * @return 200      查询信息成功 
     *                  指定id信息数据
     *         212      信息查询失败 未输入id
     *         213      信息查询失败 指定id信息未找到
     *         520      服务器端处理失败:指定id信息查询
     */
    public function getPcAsId($id = null)
    {
        try 
        {
            
            if(!$id)
            {
                return Response::response(212,'指定id信息查询失败,未输入指定id');
            }
            $pc = DB::table('pc_admin')
                ->where('id',$id)
                ->select('id','num','pc_num','pc_detail','pc_type','pc_state','description')
                ->first();
            if(!$pc)
            {
                return Response::response(213,'指定id信息查询失败,未找到指定id信息');
            }
            return Response::response(200,'指定id信息查询成功',$pc);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定id信息查询');
        }
    }
    
    /**
     * 获取指定计算机(根据id).
     * get
     * @access public
     * @param  num      序列号
     * @return 200      查询信息成功 
     *                  指定id信息数据
     *         212      信息查询失败 未输入id
     *         213      信息查询失败 指定id信息未找到
     *         520      服务器端处理失败:指定id信息查询
     */
    public function getPcAsNum($num = null)
    {
        try 
        {
            
            if(!$num)
            {
                return Response::response(212,'指定num信息查询失败,未输入指定信息');
            }
            $pc = DB::table('pc_admin')
                ->where('id',$num)
                ->select('pc_num','pc_detail','pc_type','pc_state','description')
                ->first();
            if(!$pc)
            {
                return Response::response(213,'指定num信息查询失败,未找到指定id信息');
            }
            return Response::response(200,'指定型号信息查询成功',$pc);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定num信息查询');
        }
    }
    
    
	/**
     * 修改计算机.
     * post
     * @access public 
     * @param  pc_num		计算机序列号
     * @param  pc_type		计算机型号
     * @param  pc_state		状态
     * @return 200      计算机修改成功 
     *                  所有计算机信息
     *         520      服务器端处理失败:计算机修改
     *         211      计算机修改失败：缺少必要参数
     *         212      计算机修改失败：缺少指定id
     */
    public function editPc(Request $request,$id=null)
    {
        try 
        {
//         
            if(!$id)
            {
                return Response::response(212,'计算机修改失败,未输入指定id');
            }
            //自定义编号 必须输入
            $num = $request->input('num');
            //详细参数 必须输入
            $pc_detail = $request->input('pc_detail');
            //计算机序列号 必须输入
            $pc_num = $request->input('pc_num');
            //计算机型号 必须输入
            $pc_type = $request->input('pc_type');
            //计算机状态
            $pc_state = $request->input('pc_state');
            //计算机状态
            $description = $request->input('description');
            
            if($pc_num!= ''&&$pc_type!= ''&&$pc_state!= ''&&$num!= ''&&$pc_detail!= '')
            {
                
                //电脑管理更新 数据库
                $flag = DB::table('pc_admin')
                ->where('id',$id)
                ->update(
                [	
                	'num'     => $num,
                    'pc_num'     => $pc_num,
                    'pc_detail'     => $pc_detail,
                    'pc_type'     => $pc_type,
                    'pc_state'     => $pc_state,
                    'description'  => $description,
                ]
                );
                $pcs = DB::table('pc_admin')
            ->select('id','num','pc_num','pc_detail','pc_type','pc_state','description')
            ->where('flag','1')
            ->get()
            ->toArray();
                return Response::response(200,'计算机修改成功',$pcs);
            }
            else
            {
                return Response::response(211,'计算机修改失败：缺少必要参数');
            }
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:计算机修改');
        }
    }
	/**
     * 删除指定id信息.
     * post
     * @access public
     * @param  integer  id  
     * @return 200      计算机删除成功 
     *                  所有计算机数据
     *         212      计算机删除失败 未输入指定id
     *         520      服务器端处理失败:计算机删除
     */
    public function deletePc(Request $request)
    {
        try 
        {
            $delete_id = $request->input('delete_id');
            if(!$delete_id)
            {
                return Response::response(212,'计算机删除失败,未输入指定id');
            }
            //假删除  标志位改为2
            $flag = DB::table('pc_admin')
                ->where('id',$delete_id)
                ->update(
                [
                    
                    'flag'     => '2',
                ]
                );
                
            
           $pcs = DB::table('pc_admin')
            ->select('id','num','pc_num','pc_detail','pc_type','pc_state','description')
            ->where('flag','1')
            ->get()
            ->toArray();
            
            
            return Response::response(200,'计算机删除成功',$pcs);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定计算机删除');
        }
    }
	/**
     * 归还计算机（根据序列号[pc_num]）
     * post
     * @access public
     * @param  pc_num  	序列号  
     * @return 200      计算机归还成功 
     *                  所有计算机数据
     *         212      计算机归还失败 未输入指定id
     *         520      服务器端处理失败:计算机删除
     */
	public function backPc(Request $request)
    {
        try 
        {
            $pc_num = $request->input('pc_num');
            $id = $request->input('id');
            $back_state = $request->input('back_state');
            $description = $request->input('description');
            if(!$pc_num)
            {
                return Response::response(212,'归还失败,缺少参数');
            }
            if(!$pc_num)
            {
                return Response::response(212,'归还失败,缺少参数');
            }
            
            //电脑管理更新 数据库
                $flag = DB::table('pc_admin')
                ->where('pc_num',$pc_num)
                ->update(
                [
                    'pc_state'     => $back_state,
                    'description'  => $description,
                ]
                );
                //人员表更新  (添加归还日期)
                $flag2 = DB::table('users')
                ->where('id',$id)
                ->update(
                [
                    'back_date'     => now(),
                    'description'  => $description,
                ]
                );
//          	$users = DB::table('users')
//	            ->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','pc_date','get_date','back_date','description')
//	            ->where('flag','1')
//	            ->get()
//	            ->toArray();
            
            
            return Response::response(200,'计算机归还成功');
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:计算机归还');
        }
    }


}
