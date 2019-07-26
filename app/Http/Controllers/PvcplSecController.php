<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\ResponseController as Response;
class PvcplSecController extends Controller
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
     * @return 配料信息  ID、日期、批号
     */
    public function getPlInfos($factory = null)
    {

        try
        {
            $peiliao = DB::table('pvcpl_second')
            ->select('id','factory','lotNumber')
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
//     public function getPlnames()
//     {
//
//         try
//         {
//             $plname = DB::table('pvc_plname')
//             ->get()
//             ->toArray();
//             Log::info('配方表信息获取');
//             return Response::response(200,'配方表信息获取成功',$plname);
//         }
//         catch (Exception $e)
//         {
//             return Response::response(520,'配方表信息获取失败');
//         }
//     }
     /**
     * 根据名称获取配料信息
     *
     * @return
     */
//     public function getPlAsName($name = null)
//     {
//         try
//         {
//
//             if(!$name)
//             {
//                 return Response::response(212,'指定名称信息查询失败,未输入指定id');
//             }
//
//                 $plname = DB::table('pvc_yldata')
//                 ->where('ylname',$name)
//             	->get()
//            		->toArray();
//
//
//             if(!$plname)
//             {
//                 return Response::response(213,'指定名称信息查询失败,未找到指定名称信息');
//             }
//             return Response::response(200,'指定名称信息查询成功',$plname);
//         }
//         catch (Exception $e)
//         {
//             return Response::response(520,'服务器端处理失败:指定名称信息查询');
//         }
//     }
    /**
     * 新增配料表信息
     * post
     * @access public
     * @param  formDate		    日期
     * @param  lotNumber	    批号1
     * @param  mixerNumber	    搅拌机号
     * @param  formulator	    配料员
     * @param  totalCount	    混合料重量
     * @param  rotateSpeed	    搅拌机转速
     * @param  totalTime	    新料静置时间
     * @param  stirStartTime    搅拌开始时间
     * @param  stirEndTime      搅拌结束时间
     * @param  startCps         调整前粘度
     * @param  endCps           调整后粘度
     * @param  cpsFlag          高低料
     * @param  cpsInspector     检验员
     * @param  cpsReviewer      带班长
     * @param  filtration1      过滤网一层
     * @param  filtration2      过滤网二层
     * @param  filtration3      过滤网三层
     * @param  filStartTime     过滤开始时间、
     * @param  filEndTime       过滤结束时间
     * @param  filOperator      操作员
     * @param  filInspector     检查人员
     * @param  bufferNumber     缓冲罐号
     * @param  secFilNumber     二次过滤罐号
     * @param  secFiltration1   二次过滤一层
     * @param  secFiltration2   二次过滤二层
     * @param  secFiltration3   二次过滤三层
     * @param  secFilStartTime  二次过滤开始时间
     * @param  secFilEndTime    二次过滤结束时间
     * @param  inputTime        入料时间
     * @param  vacReviewer      带班长
     * @param  outputNumber     放料罐号
     * @param  polOperator      排污人员
     * @param  polTime          排污时间
     * @param  outputLine       输入生产线
     * @param  outputStartTime  输入开始时间
     * @param  startOperator    开始放料员
     * @param  outputEndTime    输入结束时间
     * @param  endOperator      结束放料员
     * @param  outputInspector  检验员
     * @param  outputFlag       高低料
     * @param  outputReviewer   带班长
     * @param  ylData          原料数据
     * @param  vacData         真空脱泡数据

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
            //批号1必须输入
            $lotNumber = $request->input('lotNumber');
            //搅拌机号必须输入
            $mixerNumber = $request->input('mixerNumber');
            //配料员必须输入
            $formulator = $request->input('formulator');
            //混合料重量必须输入
            $totalCount = $request->input('totalCount');
            //搅拌机转速必须输入
            $rotateSpeed = $request->input('rotateSpeed');
            //新料静置时间必须输入
            $totalTime = $request->input('totalTime');
            //搅拌开始时间必须输入
            $stirStartTime = $request->input('stirStartTime');
            //搅拌结束时间必须输入
            $stirEndTime = $request->input('stirEndTime');
            //调整前粘度必须输入
            $startCps = $request->input('startCps');
            //调整后粘度必须输入
            $endCps = $request->input('endCps');
            //高低料必须输入
            $cpsFlag = $request->input('cpsFlag');
            //检验员必须输入
            $cpsInspector = $request->input('cpsInspector');
            //带班长必须输入
            $cpsReviewer = $request->input('cpsReviewer');
            //过滤网一层
            $filtration1 = $request->input('filtration1');
            //过滤网二层
            $filtration2 = $request->input('filtration2');
            //过滤网三层
            $filtration3 = $request->input('filtration3');
            //过滤开始时间
            $filStartTime = $request->input('filStartTime');
            //过滤结束时间
            $filEndTime = $request->input('filEndTime');
            //操作员
            $filOperator = $request->input('filOperator');
            //检查人员
            $filInspector = $request->input('filInspector');
            //缓冲罐号
            $bufferNumber = $request->input('bufferNumber');
            //二次过滤罐号
            $secFilNumber = $request->input('secFilNumber');
            //二次过滤一层
            $secFiltration1 = $request->input('secFiltration1');
            //二次过滤二层
            $secFiltration2 = $request->input('secFiltration2');
            //二次过滤三层
            $secFiltration3 = $request->input('secFiltration3');
            //二次过滤开始时间
            $secFilStartTime = $request->input('secFilStartTime');
            //二次过滤结束时间
            $secFilEndTime = $request->input('secFilEndTime');
            //入料时间
            $inputTime = $request->input('inputTime');
            //带班长
            $vacReviewer = $request->input('vacReviewer');
            //放料罐号
            $outputNumber = $request->input('outputNumber');
            //排污人员
            $polOperator = $request->input('polOperator');
            //排污时间
            $polTime = $request->input('polTime');
            //输入生产线
            $outputLine = $request->input('outputLine');
            //输入开始时间
            $outputStartTime = $request->input('outputStartTime');
            //开始放料员
            $startOperator = $request->input('startOperator');
            //输入结束时间
            $outputEndTime = $request->input('outputEndTime');
            //结束放料员
            $endOperator = $request->input('endOperator');
            //检验员
            $outputInspector = $request->input('outputInspector');
            //高低料
            $outputFlag = $request->input('outputFlag');
            //带班长
            $outputReviewer = $request->input('outputReviewer');

            //两个列表插入数据库
            //原料列表
            $ylData = $request->input('ylData');
            //真空脱泡列表
            $vacData = $request->input('vacData');


            //判断是否为空
            if($formDate!= ''&&$lotNumber!= ''&&$mixerNumber!= ''&&$formulator!= ''&&$totalCount!= ''&&$rotateSpeed!=''&&$totalTime!= ''&&$stirStartTime!= ''&&$stirEndTime!= ''&&$startCps!= ''&&$endCps!= ''&&$cpsFlag!= ''&&$cpsInspector!= ''&&$cpsReviewer!= '')
            {
                //项目类型插入数据库
                $flag = DB::table('pvcpl_second')
                ->insert(
                [

                    'formDate'     => $formDate,
                    'lotNumber'     => $lotNumber,
                    'mixerNumber'     => $mixerNumber,
                    'formulator'     => $formulator,
                    'totalCount'     => $totalCount,
                    'rotateSpeed'     => $rotateSpeed,
                    'totalTime'     => $totalTime,
                    'stirStartTime'     => $stirStartTime,
                    'stirEndTime'     => $stirEndTime,
                    'startCps'     => $startCps,
                    'endCps'     => $endCps,
                    'cpsFlag'     => $cpsFlag,
                    'cpsInspector'     => $cpsInspector,
                    'cpsReviewer'     => $cpsReviewer,
                    'filtration1'     => $filtration1,
                    'filtration2'     => $filtration2,
                    'filtration3'     => $filtration3,
                    'filStartTime'     => $filStartTime,
                    'filEndTime'     => $filEndTime,
                    'filOperator'     => $filOperator,
                    'filInspector'     => $filInspector,
                    'bufferNumber'     => $bufferNumber,
                    'secFilNumber'     => $secFilNumber,
                    'secFiltration1'     => $secFiltration1,
                    'secFiltration2'     => $secFiltration2,
                    'secFiltration3'     => $secFiltration3,
                    'secFilStartTime'     => $secFilStartTime,
                    'secFilEndTime'     => $secFilEndTime,
                    'inputTime'     => $inputTime,
                    'vacReviewer'     => $vacReviewer,
                    'outputNumber'     => $outputNumber,
                    'polOperator'     => $polOperator,
                    'polTime'     => $polTime,
                    'outputLine'     => $outputLine,
                    'outputStartTime'     => $outputStartTime,
                    'startOperator'     => $startOperator,
                    'outputEndTime'     => $outputEndTime,
                    'endOperator'     => $endOperator,
                    'outputInspector'     => $outputInspector,
                    'outputFlag'     => $outputFlag,
                    'outputReviewer'     => $outputReviewer,
                ]
                );

               	$peiliao = DB::table('pvcpl_second')
            	->select('id')
            	->orderBy('id', 'DESC')
                ->first();
             	//原料数据遍历存储
     //         	if($ylname!= ''){
     //         		$flagname = DB::table('pvc_plname')
		   //          ->insert(
		   //          [
		   //              'ylname'     => $ylname,
		   //          ]
					// );
     //         	}
           		$num = count($ylData);
           		 for($i=0;$i<$num;$i++){

	   				//配料表ID
	   				$plid = $peiliao->id;
				    //原料名称
	   				$rawName = $ylData[$i]['rawName'];
	   				//批号2
	   				$lotNumber = $ylData[$i]['lotNumber'];
                    //投入量
                    $deliveryCount = $ylData[$i]['deliveryCount'];
	   				//投放时间
	   				$startTime = $ylData[$i]['startTime'];
	   				//结束时间
	   				$endTime = $ylData[$i]['endTime'];
	   				//备注
	   				$description = $ylData[$i]['description'];

	   			//数据存储
	   			if($rawName!= ''&&$lotNumber!= ''&&$deliveryCount!= ''&&$startTime!= ''&&$endTime!= ''&&$description!= '')
            	{

	                $flag1 = DB::table('yldata_second')
	                ->insert(
	                [

	                    'plid'     => $plid,

	                    'rawName'     => $rawName,
	                    'lotNumber'     => $lotNumber,
                        'deliveryCount'     => $deliveryCount,
	                    'startTime'     => $startTime,
	                    'endTime'     => $endTime,
	                    'description'     => $description,

	                    //'ylname'     => $ylname,//原料名称

	                ]
					);
            	}
           		}
           		//检测数据遍历存储
           		$num2=count($vacData);
           		 for($j=0;$j<$num2;$j++){

	   				//配料表ID
	   				$plid = $peiliao->id;

				    //真空罐号
	   				$vacuumNumber= $vacData[$j]['vacuumNumber'];
	   				//抽真空次数
	   				$vacuumCount= $vacData[$j]['vacuumCount'];
                    //开始时间
                    $vacStartTime= $vacData[$j]['vacStartTime'];
                    //结束时间
                    $vacEndTime= $vacData[$j]['vacEndTime'];
                    //真空度
                    $vacuumMpa= $vacData[$j]['vacuumMpa'];
                    //操作员
                    $vacOperator= $vacData[$j]['vacOperator'];

	   			//数据存储
	   			if($vacuumNumber!= ''&&$vacuumCount!= ''&&$vacStartTime!= ''&&$vacEndTime!= ''&&$vacuumMpa!= ''&&$vacOperator!= '')
            	{

                $flag2 = DB::table('vacdata_second')
                ->insert(
                [

                    'plid'     => $plid,

                    'vacuumNumber'     => $vacuumNumber,
                    'vacuumCount'     => $vacuumCount,
                    'vacStartTime'     => $vacStartTime,
                    'vacEndTime'     => $vacEndTime,
                    'vacuumMpa'     => $vacuumMpa,
                    'vacuumNumber'     => $vacOperator,
                ]
				);
            	}
           		}
           		$yuanliao = DB::table('yldata_second')
            	->where('plid',$peiliao->id)
            	->get()
           		->toArray();
           		$tem = DB::table('vacdata_second')
            	->where('plid',$peiliao->id)
            	->get()
           		->toArray();
           		$peiliao2 = DB::table('pvcpl_second')
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

                $peiliao = DB::table('pvcpl_second')
                ->where('id',$id)
            	->get()
           		->first();
           		$yuanliao = DB::table('yldata_second')
            	->where('plid',$id)
            	->get()
           		->toArray();
           		$tem = DB::table('vacdata_second')
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
     * @param  formDate		    日期
     * @param  lotNumber	    批号1
     * @param  mixerNumber	    搅拌机号
     * @param  formulator	    配料员
     * @param  totalCount	    混合料重量
     * @param  rotateSpeed	    搅拌机转速
     * @param  totalTime	    新料静置时间
     * @param  stirStartTime    搅拌开始时间
     * @param  stirEndTime      搅拌结束时间
     * @param  startCps         调整前粘度
     * @param  endCps           调整后粘度
     * @param  cpsFlag          高低料
     * @param  cpsInspector     检验员
     * @param  cpsReviewer      带班长
     * @param  filtration1      过滤网一层
     * @param  filtration2      过滤网二层
     * @param  filtration3      过滤网三层
     * @param  filStartTime     过滤开始时间、
     * @param  filEndTime       过滤结束时间
     * @param  filOperator      操作员
     * @param  filInspector     检查人员
     * @param  bufferNumber     缓冲罐号
     * @param  secFilNumber     二次过滤罐号
     * @param  secFiltration1   二次过滤一层
     * @param  secFiltration2   二次过滤二层
     * @param  secFiltration3   二次过滤三层
     * @param  secFilStartTime  二次过滤开始时间
     * @param  secFilEndTime    二次过滤结束时间
     * @param  inputTime        入料时间
     * @param  vacReviewer      带班长
     * @param  outputNumber     放料罐号
     * @param  polOperator      排污人员
     * @param  polTime          排污时间
     * @param  outputLine       输入生产线
     * @param  outputStartTime  输入开始时间
     * @param  startOperator    开始放料员
     * @param  outputEndTime    输入结束时间
     * @param  endOperator      结束放料员
     * @param  outputInspector  检验员
     * @param  outputFlag       高低料
     * @param  outputReviewer   带班长
     * @param  ylData           原料数据
     * @param  vacData          真空脱泡数据

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
           //批号1必须输入
           $lotNumber = $request->input('lotNumber');
           //搅拌机号必须输入
           $mixerNumber = $request->input('mixerNumber');
           //配料员必须输入
           $formulator = $request->input('formulator');
           //混合料重量必须输入
           $totalCount = $request->input('totalCount');
           //搅拌机转速必须输入
           $rotateSpeed = $request->input('rotateSpeed');
           //新料静置时间必须输入
           $totalTime = $request->input('totalTime');
           //搅拌开始时间必须输入
           $stirStartTime = $request->input('stirStartTime');
           //搅拌结束时间必须输入
           $stirEndTime = $request->input('stirEndTime');
           //调整前粘度必须输入
           $startCps = $request->input('startCps');
           //调整后粘度必须输入
           $endCps = $request->input('endCps');
           //高低料必须输入
           $cpsFlag = $request->input('cpsFlag');
           //检验员必须输入
           $cpsInspector = $request->input('cpsInspector');
           //带班长必须输入
           $cpsReviewer = $request->input('cpsReviewer');
           //过滤网一层
           $filtration1 = $request->input('filtration1');
           //过滤网二层
           $filtration2 = $request->input('filtration2');
           //过滤网三层
           $filtration3 = $request->input('filtration3');
           //过滤开始时间
           $filStartTime = $request->input('filStartTime');
           //过滤结束时间
           $filEndTime = $request->input('filEndTime');
           //操作员
           $filOperator = $request->input('filOperator');
           //检查人员
           $filInspector = $request->input('filInspector');
           //缓冲罐号
           $bufferNumber = $request->input('bufferNumber');
           //二次过滤罐号
           $secFilNumber = $request->input('secFilNumber');
           //二次过滤一层
           $secFiltration1 = $request->input('secFiltration1');
           //二次过滤二层
           $secFiltration2 = $request->input('secFiltration2');
           //二次过滤三层
           $secFiltration3 = $request->input('secFiltration3');
           //二次过滤开始时间
           $secFilStartTime = $request->input('secFilStartTime');
           //二次过滤结束时间
           $secFilEndTime = $request->input('secFilEndTime');
           //入料时间
           $inputTime = $request->input('inputTime');
           //带班长
           $vacReviewer = $request->input('vacReviewer');
           //放料罐号
           $outputNumber = $request->input('outputNumber');
           //排污人员
           $polOperator = $request->input('polOperator');
           //排污时间
           $polTime = $request->input('polTime');
           //输入生产线
           $outputLine = $request->input('outputLine');
           //输入开始时间
           $outputStartTime = $request->input('outputStartTime');
           //开始放料员
           $startOperator = $request->input('startOperator');
           //输入结束时间
           $outputEndTime = $request->input('outputEndTime');
           //结束放料员
           $endOperator = $request->input('endOperator');
           //检验员
           $outputInspector = $request->input('outputInspector');
           //高低料
           $outputFlag = $request->input('outputFlag');
           //带班长
           $outputReviewer = $request->input('outputReviewer');
           //原料数据
           $ylData = $request->input('ylData');
           //真空脱泡数据
           $vacData = $request->input('vacData');



            if($formDate!= ''&&$lotNumber!= ''&&$mixerNumber!= ''&&$formulator!= ''&&$totalCount!= ''&&$rotateSpeed!=''&&$totalTime!= ''&&$stirStartTime!= ''&&$stirEndTime!= ''&&$startCps!= ''&&$endCps!= ''&&$cpsFlag!= ''&&$cpsInspector!= ''&&$cpsReviewer!= '')
            {

                //更新 数据库
                $flag = DB::table('pvcpl_second')
                ->where('id',$id)
                ->update(
                [
                	'formDate'     => $formDate,
                	'lotNumber'     => $lotNumber,
                	'mixerNumber'     => $mixerNumber,
                	'formulator'     => $formulator,
                	'totalCount'     => $totalCount,
                	'rotateSpeed'     => $rotateSpeed,
                	'totalTime'     => $totalTime,
                	'stirStartTime'     => $stirStartTime,
                	'stirEndTime'     => $stirEndTime,
                	'startCps'     => $startCps,
                	'endCps'     => $endCps,
                	'cpsFlag'     => $cpsFlag,
                	'cpsInspector'     => $cpsInspector,
                	'cpsReviewer'     => $cpsReviewer,
                	'filtration1'     => $filtration1,
                	'filtration2'     => $filtration2,
                	'filtration3'     => $filtration3,
                	'filStartTime'     => $filStartTime,
                	'filEndTime'     => $filEndTime,
                	'filOperator'     => $filOperator,
                	'filInspector'     => $filInspector,
                	'bufferNumber'     => $bufferNumber,
                	'secFilNumber'     => $secFilNumber,
                	'secFiltration1'     => $secFiltration1,
                	'secFiltration2'     => $secFiltration2,
                	'secFiltration3'     => $secFiltration3,
                	'secFilStartTime'     => $secFilStartTime,
                	'secFilEndTime'     => $secFilEndTime,
                	'inputTime'     => $inputTime,
                	'vacReviewer'     => $vacReviewer,
                	'outputNumber'     => $outputNumber,
                	'polOperator'     => $polOperator,
                	'polTime'     => $polTime,
                	'outputLine'     => $outputLine,
                	'outputStartTime'     => $outputStartTime,
                	'startOperator'     => $startOperator,
                	'outputEndTime'     => $outputEndTime,
                	'endOperator'     => $endOperator,
                	'outputInspector'     => $outputInspector,
                	'outputFlag'     => $outputFlag,
                	'outputReviewer'     => $outputReviewer,
                ]
                );


           		//原料数据遍历存储
           		$idyl = DB::table('yldata_second')
           		->select('id')
            	->where('ylid',$id)
            	->get()
           		->toArray();

           		$num=count($ylData);
           		 for($i=0;$i<$num;$i++){

				   //原料名称
				   $rawName = $ylData[$i]['rawName'];
				   //批号2
				   $lotNumber = $ylData[$i]['lotNumber'];
				   //投入量
				   $deliveryCount = $ylData[$i]['deliveryCount'];
				   //投放时间
				   $startTime = $ylData[$i]['startTime'];
				   //结束时间
				   $endTime = $ylData[$i]['endTime'];
				   //备注
				   $description = $ylData[$i]['description'];

	   			//数据更新
                $flag1 = DB::table('yldata_second')
                ->where('id',$idyl[$i])
                ->update(
                [

                    'rawName'     => $rawName,
                    'lotNumber'     => $lotNumber,
                    'deliveryCount'     => $deliveryCount,
                    'startTime'     => $startTime,
                    'endTime'     => $endTime,
                    'description'     => $description,
                ]
				);
           		};
           		//原料检测数据遍历存储
           		$idtem = DB::table('yldata_second')
           		->select('id')
            	->where('ylid',$id)
            	->get()
           		->toArray();

           		$num2=count($vacData);
           		 for($j=0;$j<$num2;$j++){

				     //真空罐号
				    $vacuumNumber= $vacData[$j]['vacuumNumber'];
				    //抽真空次数
				    $vacuumCount= $vacData[$j]['vacuumCount'];
				    //开始时间
				    $vacStartTime= $vacData[$j]['vacStartTime'];
				    //结束时间
				    $vacEndTime= $vacData[$j]['vacEndTime'];
				    //真空度
				    $vacuumMpa= $vacData[$j]['vacuumMpa'];
				    //操作员
				    $vacOperator= $vacData[$j]['vacOperator'];

	   			//数据更新
                $flag2 = DB::table('vacdata_second')
                ->where('id',$idtem[$j])
                ->update(
                [

                   'vacuumNumber'     => $vacuumNumber,
                   'vacuumCount'     => $vacuumCount,
                   'vacStartTime'     => $vacStartTime,
                   'vacEndTime'     => $vacEndTime,
                   'vacuumMpa'     => $vacuumMpa,
                   'vacuumNumber'     => $vacOperator,
                ]
				);
           		$yuanliao = DB::table('yldata_second')
            	->where('ylid',$peiliao->id)
            	->get()
           		->toArray();
           		$tem = DB::table('vacdata_second')
            	->where('ylid',$peiliao->id)
            	->get()
           		->toArray();

           		}



                return Response::response(200,'pl修改成功',$peiliao);
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
