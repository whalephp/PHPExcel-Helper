# PHPExcel-Helper


#### 项目介绍
# PHPExcel-Helper是什么？
PHPExcel辅助开发类，帮助开发者快速创建各类excel。


#### 安装教程

使用 composer 安装，依赖 phpexcel
~~~
$ composer require whalephp/phpexcel-helper
~~~


#### Demo

demo 1：简单表格
~~~php
<?php 
include './vendor/autoload.php';

$ToolExcel = new \whalephp\tool\PHPExcelHelper();
$list = array(
		array('id'=>1,'name'=>'a'),
		array('id'=>2,'name'=>'b'),
		array('id'=>3,'name'=>'c'),
		array('id'=>4,'name'=>'c'),
);
$key = array(
		'id'	=> '编号',
		'name'	=> '姓名',
);
$ToolExcel->exportExcelSimp('简版测试',$key,$list);
~~~
![1540372635030](images\1540372635030.png)

demo 2：跨行跨列表格

~~~php
<?php 
include './vendor/autoload.php';

$ToolExcel = new \whalephp\tool\PHPExcelHelper();
$data = array(
		'file_name'	=> '测试-跨行跨列',
		'sheetInfo'	=> array(
				'sheetIndex'	=> 0,
				'sheetTitle'	=> '订单汇总',
		),
		'startCell'	=> array(					//开始写入位置
				'row'=>1,
				'col'=>1
		),
		'cellData'	=> array(
				array(
						array(
								'val'		=> 'A1',
								'rowspan'	=> 2,		//跨行数
								'colspan'	=> 2,		//跨列数
								'remarks'	=> '备注1',
						),
						array(
								'val'		=> 'B1',	//
								'rowspan'	=> 2,		//跨行数
								'colspan'	=> 2,		//跨行数
						),
						array(
								'val'		=> 'C1',
								'colspan'	=> 2,
						),
						array(
								'val'		=> 'D1',	//
								'colspan'	=> 2,
						),
						array(
								'val'		=> 'A1',
								'rowspan'	=> 2,		//跨行数
								'colspan'	=> 2,		//跨列数
								'remarks'	=> '备注1',
						),
						array(
								'val'		=> 'C1',
								'colspan'	=> 2,
						),
						array(
								'val'		=> 'D1',	//
								'colspan'	=> 2,
						),
				),
				array(
						array(
								'val'		=> '1',
						),
						array(
								'val'		=> '2',
						),
						array(
								'val'		=> '3',
						),
						array(
								'val'		=> '4',
						),
						array(
								'val'		=> '5',
						),
						array(
								'val'		=> '6',
						),
				),
				array(
						array(
								'val'		=> 'a',
						),
						array(
								'val'		=> 'b',	//
						),
				),

		),
);

$ToolExcel->exportExcel($data);
~~~
![1540372598972](images\1540372598972.png)

demo 3：指定列宽

~~~php
<?php 
include '../vendor/autoload.php';
include '../src/PHPExcelHelper.php';

$ToolExcel = new \whalephp\tool\PHPExcelHelper();
$list = array(
    array('id'=>1,'name'=>'a','nickname'=>'aa'),
    array('id'=>2,'name'=>'b','nickname'=>'bb'),
    array('id'=>3,'name'=>'c','nickname'=>'cc'),
    array('id'=>4,'name'=>'d','nickname'=>'dddddddddddddddddddddddddddddddd'),
);
$key = array(
    'id'	    => ['编号',10],
    'name'	    => ['姓名',15],
    'nickname'	=> ['昵称',35],
);
$ToolExcel->exportExcelSimp('简版测试',$key,$list);
~~~



![1540372560858](images\1540372560858.png)

demo 4：指定sheet信息

~~~php
<?php 
include '../vendor/autoload.php';
include '../src/PHPExcelHelper.php';

$ToolExcel = new \whalephp\tool\PHPExcelHelper();
$list = array(
    array('id'=>1,'name'=>'a','nickname'=>'aa'),
    array('id'=>2,'name'=>'b','nickname'=>'bb'),
    array('id'=>3,'name'=>'c','nickname'=>'cc'),
    array('id'=>4,'name'=>'d','nickname'=>'dddddddddddddddddddddddddddddddd'),
);
$key = array(
    'id'	    => ['编号',10],
    'name'	    => ['姓名',15],
    'nickname'	=> ['昵称',35],
);
$ToolExcel->exportExcelSimp([
    'file_name'     => '简版测试',
    'sheetTitle'    => '工作区一',
],$key,$list);
~~~



![1540372539349](images\1540372539349.png)

demo 5：多sheet

~~~php
<?php 
include '../vendor/autoload.php';
include '../src/PHPExcelHelper.php';

$ToolExcel = new \whalephp\tool\PHPExcelHelper();

// 第一组数据
//--------------------------------------------------------------
$list = array(
    array('id'=>1,'name'=>'a','nickname'=>'aa'),
    array('id'=>2,'name'=>'b','nickname'=>'bb'),
    array('id'=>3,'name'=>'c','nickname'=>'cc'),
    array('id'=>4,'name'=>'d','nickname'=>'dddddddddddddddddddddddddddddddd'),
);
$key = array(
    'id'	    => ['编号',10],
    'name'	    => ['姓名',15],
    'nickname'	=> ['昵称',35],
);

// 第二组数据
//--------------------------------------------------------------
$list_02 = array(
    array('id'=>1,'name'=>'a','nickname'=>'aa2'),
    array('id'=>2,'name'=>'b','nickname'=>'bb2'),
    array('id'=>3,'name'=>'c','nickname'=>'cc2'),
    array('id'=>4,'name'=>'d','nickname'=>'ddddddddddddddddddd2'),
);
$key_02 = array(
    'id'	    => ['编号二',10],
    'name'	    => ['姓名二',15],
    'nickname'	=> ['昵称二',25],
);

$fileInfo = [
    'file_name'=>'简版测试',
    'sheet'=>[
        ['sheetIndex'=>0,'sheetTitle'=>'工作区一'],
        ['sheetIndex'=>1,'sheetTitle'=>'工作区二'],
    ]
];

$ToolExcel->exportExcelSimp($fileInfo,[$key,$key_02],[$list,$list_02]);
~~~



![1540372500801](images\1540372500801.png)



