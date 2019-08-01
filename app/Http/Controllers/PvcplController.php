<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\ResponseController as Response;
class PvcplController extends Controller
{
    /**
     * 配料表增、改、查 相关接口
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('cors');
    }

     /**
     * 获取配料信息,根据厂次
     *
     * @return 配料信息  ID、日期、班次、批号
     */
    public function getPlInfos($factory = null)
    {

        try
        {
            $peiliao = DB::table('pvc_peiliao')
            ->select('id','factory','shift','lotNumber')
            ->where('factory',$factory)
            ->get()
            ->toArray();
            Log::info('配料表信息获取');
            return Response::response(200,'配料表信息获取成功',$peiliao);
        }
        catch (Exception $e)
        {
            return Response::response(520,'配料表信息获取失败');
        }
    }
     /**
     * 获取配料信息
     *
     * @return 配料信息  ID、日期、班次、批号
     */
    public function getPlnames()
    {

        try
        {
            $plname = DB::table('pvc_plname')
            ->get()
            ->toArray();
            Log::info('配方表信息获取');
            return Response::response(200,'配方表信息获取成功',$plname);
        }
        catch (Exception $e)
        {
            return Response::response(520,'配方表信息获取失败');
        }
    }
     /**
     * 根据名称获取配料信息
     *
     * @return
     */
    public function getPlAsName($name = null)
    {
        try
        {

            if(!$name)
            {
                return Response::response(212,'指定名称信息查询失败,未输入指定id');
            }

                $plname = DB::table('pvc_yldata')
                ->where('ylname',$name)
            	->get()
           		->toArray();


            if(!$plname)
            {
                return Response::response(213,'指定名称信息查询失败,未找到指定名称信息');
            }
            return Response::response(200,'指定名称信息查询成功',$plname);
        }
        catch (Exception $e)
        {
            return Response::response(520,'服务器端处理失败:指定名称信息查询');
        }
    }
    /**
     * 新增配料表信息
     * post
     * @access public
     * @param  formDate		日期
     * @param  shift		班次
     * @param  factory		厂区
     * @param  stirStartTime		搅拌开始时间
     * @param  stirEndTime		搅拌结束时间
     * @param  lotNumber		批号
     * @param  mixerNumber		一次搅拌机号
     * @param  rotateSpeed		搅拌机转速
     * @param  totalCount		投放总量
     * @param  totalTime		搅拌总时长
     * @param  visDegree		粘度
     * @param  finDegree		细度
     * @param  inspectors		检验员
     * @param  detTime			检测列表
     * @param  ylData			原料列表
     * @param  restStartTime		开始静置时间
     * @param  restTemperature		开始静置温度
     * @param  restStartOperator	开始静置操作员
     * @param  restEndTime		结束静置时间
     * @param  restEndOperator		结束静置操作员
     * @param  restShift		静置班次
     * @param  restTotalTime		合计静置时间
     * @param  restTankNumber		静置罐号
     * @param  mixNumber2		二次搅拌机号
     * @param  finalAuditor		审核人
     * @return 200      	增加成功
     *         210      	增加失败
     *         520      	服务器端处理失败:新增
     *         211      	信息新增失败：缺少必要参数
     */
    public function addPlInfo(Request $request)
    {
        try
        {
//
            //日期必须输入
            $formDate = $request->input('formDate');
            //班次必须输入
            $shift = $request->input('shift');
            //厂区 必须输入
            $factory = $request->input('factory');
            //搅拌开始时间  必须输入
            $stirStartTime = $request->input('stirStartTime');
            //搅拌结束时间   必须输入
            $stirEndTime = $request->input('stirEndTime');
            //批号     后续生成  必须输入
            $lotNumber = $request->input('lotNumber');
            //一次搅拌机号   必须输入
            $mixerNumber = $request->input('mixerNumber');
            //搅拌机转速  必须输入
            $rotateSpeed = $request->input('rotateSpeed');
            //投放总量 必须输入
            $totalCount = $request->input('totalCount');
            //搅拌总时长  必须输入
            $totalTime = $request->input('totalTime');
            //配料原料名  可选输入
            $ylname = $request->input('ylname');
            //粘度   必须输入
            $visDegree = $request->input('visDegree');
            //细度      必须输入
            $finDegree = $request->input('finDegree');
            //检验员
            $inspectors = $request->input('inspectors');
            //开始静置时间
            $restStartTime = $request->input('restStartTime');
            //开始静置温度
            $restTemperature = $request->input('restTemperature');
            //开始静置操作员
            $restStartOperator = $request->input('restStartOperator');
            //结束静置时间
            $restEndTime = $request->input('restEndTime');
            //结束静置操作员
            $restEndOperator = $request->input('restEndOperator');
            //静置班次
            $restShift = $request->input('restShift');
            //合计静置时间
            $restTotalTime = $request->input('restTotalTime');
            //静置罐号
            $restTankNumber = $request->input('restTankNumber');
            //二次搅拌机号
            $mixNumber2 = $request->input('mixNumber2');
            //审核人
            $finalAuditor = $request->input('finalAuditor');

            //两个列表插入数据库
            //原料列表
            $ylData = $request->input('ylData');
            //检测列表
            $det = $request->input('detTime');


            //判断是否为空
            if($formDate!= ''&&$shift!= ''&&$factory!= ''&&$stirStartTime!= ''&&$stirEndTime!= ''&&$lotNumber!=''&&$mixerNumber!= ''&&$rotateSpeed!= ''&&$totalCount!= ''&&$inspectors!= ''&&$totalTime!= ''&&$finDegree!= ''&&$visDegree!= '')
            {
                //项目类型插入数据库
                $flag = DB::table('pvc_peiliao')
                ->insert(
                [

                    'formDate'     => $formDate,
                    'shift'     => $shift,
                    'factory'     => $factory,
                    'stirStartTime'     => $stirStartTime,
                    'stirEndTime'     => $stirEndTime,
                    'lotNumber'     => $lotNumber,
                    'mixerNumber'     => $mixerNumber,
                    'rotateSpeed'     => $rotateSpeed,
                    'totalCount'     => $totalCount,
                    'totalTime'     => $totalTime,
                    'visDegree'     => $visDegree,
                    'finDegree'     => $finDegree,
                    'inspectors'     => $inspectors,
                    'restStartTime'     => $restStartTime,
                    'restTemperature'     => $restTemperature,
                    'restStartOperator'     => $restStartOperator,
                    'restEndTime'     => $restEndTime,
                    'restEndOperator'     => $restEndOperator,
                    'restShift'     => $restShift,
                    'restTotalTime'     => $restTotalTime,
                    'restTankNumber'     => $restTankNumber,
                    'mixNumber2'     => $mixNumber2,
                    'finalAuditor'     => $finalAuditor,
                ]
                );

               	$peiliao = DB::table('pvc_peiliao')
            	->select('id')
            	->orderBy('id', 'DESC')
                ->first();
             	//原料数据遍历存储
             	if($ylname!= ''){
             		$flagname = DB::table('pvc_plname')
		            ->insert(
		            [
		                'ylname'     => $ylname,
		            ]
					);
             	}
           		$num = count($ylData);
           		 for($i=0;$i<$num;$i++){

	   				//配料表ID
	   				$plid = $peiliao->id;
				    //原料名称
	   				$rawName = $ylData[$i]['rawName'];
	   				//原料批号
	   				$lotNumber = $ylData[$i]['lotNumber'];
	   				//投放时间
	   				$startTime = $ylData[$i]['startTime'];
	   				//结束时间
	   				$endTime = $ylData[$i]['endTime'];
	   				//投放数量
	   				$deliveryCount = $ylData[$i]['deliveryCount'];
	   				//配料员
	   				$formulator = $ylData[$i]['formulator'];
	   				//复核人
	   				$reviewer = $ylData[$i]['reviewer'];
	   			//数据存储
	   			if($rawName!= ''&&$lotNumber!= ''&&$startTime!= ''&&$endTime!= ''&&$deliveryCount!= ''&&$formulator!= '')
            	{

	                $flag1 = DB::table('pvc_yldata')
	                ->insert(
	                [

	                    'plid'     => $plid,
	                    'rawName'     => $rawName,
	                    'lotNumber'     => $lotNumber,
	                    'startTime'     => $startTime,
	                    'endTime'     => $endTime,
	                    'deliveryCount'     => $deliveryCount,
	                    'formulator'     => $formulator,
	                    'reviewer'     => $reviewer,
	                    'ylname'     => $ylname,//原料名称

	                ]
					);
            	}
           		}
           		//检测数据遍历存储
           		$num2=count($det);
           		 for($j=0;$j<$num2;$j++){

	   				//配料表ID
	   				$plid = $peiliao->id;
				    //原料名称
	   				$detTime= $det[$j]['dettime'];
	   				//原料批号
	   				$detTemperature= $det[$j]['detTemperature'];
	   			//数据存储
	   			if($detTime!= ''&&$detTemperature!= '')
            	{

                $flag2 = DB::table('pvc_detdata')
                ->insert(
                [

                    'plid'     => $plid,
                    'detTime'     => $detTime,
                    'detTemperature'     => $detTemperature,
                ]
				);
            	}
           		}
           		$yuanliao = DB::table('pvc_yldata')
            	->where('plid',$peiliao->id)
            	->get()
           		->toArray();
           		$tem = DB::table('pvc_detdata')
            	->where('plid',$peiliao->id)
            	->get()
           		->toArray();
           		$peiliao2 = DB::table('pvc_peiliao')
            	->where('id',$peiliao->id)
            	->get()
           		->first();

				$pl=array($peiliao2,$yuanliao,$tem);

                Log::info('配料表新增数据');
                return Response::response(200,'保存成功',$pl);
            }
            else
            {
                return Response::response(211,'保存失败：缺少必要参数');
            }
        }
        catch (Exception $e)
        {
            return Response::response(520,'服务器端处理失败:数据新增');
        }
    }

    /**
     * 获取指定配料表.(根据id)
     * get
     * @access public
     * @param  integer  id  项目id
     * @return 200      查询信息成功
     *                  指定id信息数据
     *         212      信息查询失败 未输入id
     *         213      信息查询失败 指定id信息未找到
     *         520      服务器端处理失败:指定id信息查询
     */
    public function getPlAsId($id = null)
    {
        try
        {

            if(!$id)
            {
                return Response::response(212,'指定id信息查询失败,未输入指定id');
            }

                $peiliao = DB::table('pvc_peiliao')
                ->where('id',$id)
            	->get()
           		->first();
           		$yuanliao = DB::table('pvc_yldata')
            	->where('plid',$id)
            	->get()
           		->toArray();
           		$tem = DB::table('pvc_detdata')
            	->where('plid',$id)
            	->get()
           		->toArray();

				$pl=array($peiliao,$yuanliao,$tem);


            if(!$peiliao)
            {
                return Response::response(213,'指定id信息查询失败,未找到指定id信息');
            }
            return Response::response(200,'指定id信息查询成功',$pl);
        }
        catch (Exception $e)
        {
            return Response::response(520,'服务器端处理失败:指定id信息查询');
        }
    }



	/**
     * 修改pl信息.
     * post
     * @access public
     * @param  formDate		日期
     * @param  shift		班次
     * @param  factory		厂区
     * @param  stirStartTime		搅拌开始时间
     * @param  stirEndTime		搅拌结束时间
     * @param  lotNumber		批号
     * @param  mixerNumber		一次搅拌机号
     * @param  rotateSpeed		搅拌机转速
     * @param  totalCount		投放总量
     * @param  totalTime		搅拌总时长
     * @param  visDegree		粘度
     * @param  finDegree		细度
     * @param  inspectors		检验员
     * @param  restStartTime		开始静置时间
     * @param  restTemperature		开始静置温度
     * @param  restStartOperator	开始静置操作员
     * @param  restEndTime		结束静置时间
     * @param  restEndOperator		结束静置操作员
     * @param  restShift		静置班次
     * @param  restTotalTime		合计静置时间
     * @param  restTankNumber		静置罐号
     * @param  mixNumber2		二次搅拌机号
     * @param  finalAuditor		审核人
     * @return 200      pl修改成功
     *                  所有pl信息
     *         520      服务器端处理失败:pl修改
     *         211      pl修改失败：缺少必要参数
     *         212      pl修改失败：缺少指定id
     */
    public function editpl(Request $request,$id=null)
    {
        try
        {
//
            if(!$id)
            {
                return Response::response(212,'pl修改失败,未输入指定id');
            }
           //日期必须输入
            $formDate = $request->input('formDate');
            //班次必须输入
            $shift = $request->input('shift');
            //厂区 必须输入
            $factory = $request->input('factory');
            //搅拌开始时间  必须输入
            $stirStartTime = $request->input('stirStartTime');
            //搅拌结束时间   必须输入
            $stirEndTime = $request->input('stirEndTime');
            //批号     后续生成  必须输入
            $lotNumber = $request->input('lotNumber');
            //一次搅拌机号   必须输入
            $mixerNumber = $request->input('mixerNumber');
            //搅拌机转速  必须输入
            $rotateSpeed = $request->input('rotateSpeed');
            //投放总量 必须输入
            $totalCount = $request->input('totalCount');
            //搅拌总时长  必须输入
            $totalTime = $request->input('totalTime');
            //粘度   必须输入
            $visDegree = $request->input('visDegree');
            //细度      必须输入
            $finDegree = $request->input('finDegree');
            //检验员
            $inspectors = $request->input('inspectors');
            //开始静置时间
            $restStartTime = $request->input('restStartTime');
            //开始静置温度
            $restTemperature = $request->input('restTemperature');
            //开始静置操作员
            $restStartOperator = $request->input('restStartOperator');
            //结束静置时间
            $restEndTime = $request->input('restEndTime');
            //结束静置操作员
            $restEndOperator = $request->input('restEndOperator');
            //静置班次
            $restShift = $request->input('restShift');
            //合计静置时间
            $restTotalTime = $request->input('restTotalTime');
            //静置罐号
            $restTankNumber = $request->input('restTankNumber');
            //二次搅拌机号
            $mixNumber2 = $request->input('mixNumber2');
            //审核人
            $finalAuditor = $request->input('finalAuditor');
            //两个列表
            //原料列表
            $ylData = $request->input('ylData');
            //检测列表
            $det = $request->input('detTime');

            if($formDate!= ''&&$shift!= ''&&$factory!= ''&&$stirStartTime!= ''&&$stirEndTime!= ''&&$lotNumber!=''&&$mixerNumber!= ''&&$rotateSpeed!= ''&&$totalCount!= ''&&$inspectors!= ''&&$totalTime!= '')
            {

                //更新 数据库
                $flag = DB::table('pvc_peiliao')
                ->where('id',$id)
                ->update(
                [
                	'formDate'     => $formDate,
                    'shift'     => $shift,
                    'factory'     => $factory,
                    'stirStartTime'     => $stirStartTime,
                    'stirEndTime'     => $stirEndTime,
                    'lotNumber'     => $lotNumber,
                    'mixerNumber'     => $mixerNumber,
                    'rotateSpeed'     => $rotateSpeed,
                    'totalCount'     => $totalCount,
                    'totalTime'     => $totalTime,
                    'visDegree'     => $visDegree,
                    'finDegree'     => $finDegree,
                    'inspectors'     => $inspectors,
                    'restStartTime'     => $restStartTime,
                    'restTemperature'     => $restTemperature,
                    'restStartOperator'     => $restStartOperator,
                    'restEndTime'     => $restEndTime,
                    'restEndOperator'     => $restEndOperator,
                    'restShift'     => $restShift,
                    'restTotalTime'     => $restTotalTime,
                    'restTankNumber'     => $restTankNumber,
                    'mixNumber2'     => $mixNumber2,
                    'finalAuditor'     => $finalAuditor,
                ]
                );


           		//原料数据遍历存储
           		$idyl = DB::table('pvc_yldata')
           		->select('id')
            	->where('plid',$id)
            	->get()
           		->toArray();

           		$num=count($ylData);
           		 for($i=0;$i<$num;$i++){

				   //原料名称
	   				$rawName = $ylData[$i]['rawName'];
	   				//原料批号
	   				$lotNumber = $ylData[$i]['lotNumber'];
	   				//投放时间
	   				$startTime = $ylData[$i]['startTime'];
	   				//结束时间
	   				$endTime = $ylData[$i]['endTime'];
	   				//投放数量
	   				$deliveryCount = $ylData[$i]['deliveryCount'];
	   				//配料员
	   				$formulator = $ylData[$i]['formulator'];
	   				//复核人
	   				$reviewer = $ylData[$i]['reviewer'];
	   			//数据更新
                $flag1 = DB::table('pvc_yldata')
                ->where('id',$idyl[$i]->id)
                ->update(
                [

                    'rawName'     => $rawName,
                    'lotNumber'     => $lotNumber,
                    'startTime'     => $startTime,
                    'endTime'     => $endTime,
                    'deliveryCount'     => $deliveryCount,
                    'formulator'     => $formulator,
                    'reviewer'     => $reviewer,
                ]
				);
           		};
           		//原料检测数据遍历存储
           		$idtem = DB::table('pvc_yldata')
           		->select('id')
            	->where('plid',$id)
            	->get()
           		->toArray();

           		$num2=count($det);
           		 for($j=0;$j<$num2;$j++){

				    //原料名称
	   				$detTime= $det[$j]['dettime'];
	   				//原料批号
	   				$detTemperature= $det[$j]['detTemperature'];
	   			//数据更新
                $flag2 = DB::table('pvc_detdata')
                ->where('id',$idtem[$j]->id)
                ->update(
                [

                    'dettime'     => $detTime,
                    'detTemperature'     => $detTemperature,
                ]
				);
           		}
				$peiliao = DB::table('pvc_peiliao')
            	->where('id',$id)
            	->get()
           		->toArray();
           		$yuanliao = DB::table('pvc_yldata')
            	->where('plid',$id)
            	->get()
           		->toArray();
           		$tem = DB::table('pvc_detdata')
            	->where('plid',$id)
            	->get()
           		->toArray();
           		
           		
           		$pl=array($peiliao,$yuanliao,$tem);



                return Response::response(200,'pl修改成功',$pl);
            }
            else
            {
                return Response::response(211,'pl修改失败：缺少必要参数');
            }
        }
        catch (Exception $e)
        {
            return Response::response(520,'服务器端处理失败:pl修改');
        }
    }
	/**
     * 删除指定id信息.
     * post
     * @access public
     * @param  integer  id
     * @return 200      pl删除成功
     *                  所有pl数据
     *         212      pl删除失败 未输入指定id
     *         520      服务器端处理失败:pl删除
     */
//  public function deletepl(Request $request)
//  {
//      try
//      {
//          $delete_id = $request->input('delete_id');
//          if(!$delete_id)
//          {
//              return Response::response(212,'pl删除失败,未输入指定id');
//          }
//
//
//          //假删除  删除标志位改为2
//              $flag = DB::table('pl_admin')
//              ->where('id',$delete_id)
//              ->update(
//              [
//
//                  'flag'     => '2',
//              ]
//              );
//
//         $pls = DB::table('pl_admin')
//          ->select('id','num','pl_num','pl_detail','pl_type','pl_state','description')
//          ->where('flag','1')
//          ->get()
//          ->toArray();
//
//
//          return Response::response(200,'pl删除成功',$pls);
//      }
//      catch (Exception $e)
//      {
//          return Response::response(520,'服务器端处理失败:指定pl删除');
//      }
//  }



}
