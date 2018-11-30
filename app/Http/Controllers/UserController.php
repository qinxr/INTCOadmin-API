<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\ResponseController as Response;
class UserController extends Controller
{
    /**
     * 人员信息增、删、改、查 相关接口
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('cors');
    }

     /**
     * 获取用户信息
     *
     * @return 用户信息
     */
    public function getAllUserInfos()
    {
        
        try 
        {
            $users = DB::table('users')
            ->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','pc_date','get_date','back_date','description')
            ->where('flag','1')
            ->get()
            ->toArray();
            Log::info('人员信息获取');
            return Response::response(200,'人员信息获取成功',$users);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'人员信息获取失败');
        }
    }
    /**
     * 获取用户信息
     *
     * @return 用户信息
     */
    public function getUserInfos()
    {
        
        try 
        {
            $users = DB::table('users')
            ->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','pc_date','get_date','back_date','description')
            ->where('back_date',null)
            ->where('flag','1')
            ->get()
            ->toArray();
            Log::info('人员信息获取');
            return Response::response(200,'人员信息获取成功',$users);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'人员信息获取失败');
        }
    }
    /**
     * 新增人员信息.
     * post
     * @access public 
     * @param  name			姓名
     * @param  job_num		工号
     * @param  dept			部门
     * @param  job			职位
     * @param  ent_date		入职时间 
     * @param  dim_date		离职时间 
     * @param  pc_num		计算机序列号
     * @param  pc_type		计算机型号
     * @param  get_date		借用日期 
     * @param  back_date	归还日期
     * @return 200      	人员信息增加成功 
     *         210      	人员信息增加失败
     *         520      	服务器端处理失败:人员信息新增
     *         211      	项目新增失败：缺少必要参数
     */
    public function addUserInfo(Request $request)
    {
        try 
        {
            //姓名 必须输入
            $name = $request->input('name');
            //工号 必须输入
            $job_num = $request->input('job_num');
            //部门 必须输入
            $dept = $request->input('dept');
            //职位 必须输入
            $job = $request->input('job');
            //入职时间 必须输入
            $ent_date = $request->input('ent_date');
            //离职时间 可选输入
            $dim_date = $request->input('dim_date');
            //计算机序列号 必须输入
            $pc_num = $request->input('pc_num');
            //计算机型号 (传入为计算机id)必须输入
            $pc_type = $request->input('pc_type');
            //借用期限 必须输入（1短期，2长期）
            $pc_date = $request->input('pc_date');
            //借用日期 必须输入
            $get_date = $request->input('get_date');
            //归还日期 可选输入
            $back_date = $request->input('back_date');
            //判断是否为空
            if($name!= ''&&$job_num!= ''&&$dept!= ''&&$job!= ''&&$ent_date!= ''&&$pc_num!= ''&&$pc_type!= ''&&$get_date!= '')
            {	
            	
            	//根据序列号查id
                $pc = DB::table('pc_admin')
                ->where('pc_num',$pc_num)
                ->select('id','pc_type')
                ->first();
            	
            	$pc_type=$pc->pc_type;
                //项目类型插入数据库
                $flag = DB::table('users')
                ->insert(
                [
                    'name'     => $name,
                    'job_num'     => $job_num,
                    'dept'     => $dept,
                    'job'     => $job,
                    'ent_date'     => $ent_date,
                    'dim_date'     => $dim_date,
                    'pc_num'     => $pc_num,
                    'pc_type'     => $pc_type,
                    'pc_date'     => $pc_date,
                    'get_date'     => $get_date,
                    'back_date'     => $back_date,
                ]
                );
                
                //根据id修改计算机状态
                 //项目信息更新 数据库
                $flagpc = DB::table('pc_admin')
                ->where('id',$pc->id)
                ->update(
                [
                    'pc_state'     => 2,
                ]
                );
                $users = DB::table('users')
            	->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','get_date','back_date','description')
            	->where('flag','1')
           	 	->get()
            	->toArray();
                Log::info('新增人员信息:'.$name.'领用电脑');
                return Response::response(200,'人员信息新增成功',$users);
            }
            else
            {
                return Response::response(211,'人员信息新增失败：缺少必要参数');
            }
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:人员信息新增');
        }
    }
    
    /**
     * 获取指定人员信息.
     * get
     * @access public
     * @param  integer  id  项目id
     * @return 200      查询信息成功 
     *                  指定id信息数据
     *         212      信息查询失败 未输入id
     *         213      信息查询失败 指定id信息未找到
     *         520      服务器端处理失败:指定id信息查询
     */
    public function getUserAsId($id = null)
    {
        try 
        {
            
            if(!$id)
            {
                return Response::response(212,'指定id信息查询失败,未输入指定id');
            }
            $user = DB::table('users')
                ->where('id',$id)
                ->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','get_date','back_date','description')
                ->first();
            if(!$user)
            {
                return Response::response(213,'指定id信息查询失败,未找到指定id信息');
            }
            return Response::response(200,'指定id信息查询成功',$user);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定id信息查询');
        }
    }
	/**
     * 修改人员信息.
     * post
     * @access public 
     * @param  name			姓名
     * @param  job_num		工号
     * @param  dept			部门
     * @param  job			职位
     * @param  ent_date		入职时间 
     * @param  dim_date		离职时间 
     * @param  pc_num		计算机序列号
     * @param  pc_type		计算机型号
     * @param  get_date		借用日期 
     * @param  back_date	归还日期
     * @return 200      人员信息修改成功 
     *                  所有人员信息信息
     *         520      服务器端处理失败:人员信息修改
     *         211      人员信息修改失败：缺少必要参数
     *         212      人员信息修改失败：缺少指定id
     */
    public function editUser(Request $request,$id=null)
    {
        try 
        {
//         
            if(!$id)
            {
                return Response::response(212,'人员信息修改失败,未输入指定id');
            }
            //姓名 必须输入
            $name = $request->input('name');
            //工号 必须输入
            $job_num = $request->input('job_num');
            //部门 必须输入
            $dept = $request->input('dept');
            //职位 必须输入
            $job = $request->input('job');
            //入职时间 必须输入
            $ent_date = $request->input('ent_date');
            //离职时间 可选输入
            $dim_date = $request->input('dim_date');
            //计算机序列号 必须输入
            $pc_num = $request->input('pc_num');
            //计算机型号 必须输入
            $pc_type = $request->input('pc_type');
            //借用日期 必须输入
            $get_date = $request->input('get_date');
            //归还日期 可选输入
            $back_date = $request->input('back_date');
            //描述 可选输入
            $description = $request->input('description');
            
            if($name!= ''&&$job_num!= ''&&$dept!= ''&&$job!= ''&&$ent_date!= ''&&$pc_num!= ''&&$pc_type!= ''&&$get_date!= '')
            {
                
                //项目信息更新 数据库
                $flag = DB::table('users')
                ->where('id',$id)
                ->update(
                [
                    'name'     => $name,
                    'job_num'     => $job_num,
                    'dept'     => $dept,
                    'job'     => $job,
                    'ent_date'     => $ent_date,
                    'dim_date'     => $dim_date,
                    'pc_num'     => $pc_num,
                    'pc_type'     => $pc_type,
                    'get_date'     => $get_date,
                    'back_date'     => $back_date,
                    'description'     => $description,
                ]
                );
                $users = DB::table('users')
            	->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','get_date','back_date','description')
            	->where('flag','1')
           	 	->get()
            	->toArray();
                Log::info('人员信息修改:'.$name);
                return Response::response(200,'人员信息修改成功',$users);
            }
            else
            {
                return Response::response(211,'人员信息修改失败：缺少必要参数');
            }
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:人员信息修改');
        }
    }
	/**
     * 删除指定id信息(假删除).
     * post
     * @access public
     * @param  integer  id  
     * @return 200      人员信息删除成功 
     *                  所有人员信息数据
     *         212      人员信息删除失败 未输入指定id
     *         520      服务器端处理失败:人员信息删除
     */
    public function deleteUser(Request $request)
    {
        try 
        {
            $delete_id = $request->input('delete_id');
            if(!$delete_id)
            {
                return Response::response(212,'人员信息删除失败,未输入指定id');
            }
           
            
            //假删除  删除标志位改为2
                $flag = DB::table('users')
                ->where('id',$delete_id)
                ->update(
                [
                    
                    'flag'     => '2',
                ]
                );
            
            $users = DB::table('users')
            	->select('id','name','job_num','dept','job','ent_date','dim_date','pc_num','pc_type','get_date','back_date','description')
            	->where('flag','1')
           	 	->get()
            	->toArray();
            
            
            return Response::response(200,'人员信息删除成功',$users);
        }
        catch (Exception $e) 
        {
            return Response::response(520,'服务器端处理失败:指定人员信息删除');
        }
    }










}
