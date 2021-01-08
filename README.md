### 项目介绍
##### PHPExcel-Helper是什么？
PHPExcel辅助开发类，帮助开发者快速创建各类excel。

[github](https://github.com/whalephp/PHPExcel-Helper)

##### PHPExcel-Helper存在的意义？
官方phpexcel库功能全面，但其调用有些繁琐，一个简单的表格导出可能需要写上几十行代码，本库将phpexcel中常用的方法配置进行封装，并添加了一些常用的业务支持，通常几行代码即可实现一个导出功能。

在实际开发中很容易的可以将数据库中查询出来的列表配置导出。

### 安装教程

使用 composer 安装，依赖 phpexcel
~~~
$ composer require whalephp/phpexcel-helper
~~~


### Demo

##### demo 1：简单表格
~~~php
<?php 
include '../vendor/autoload.php';

use whalephp\tool\PHPExcelHelper;

$ToolExcel = new PHPExcelHelper();

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
![](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/a19ef6b5996c49c1ad5d1d5eb9d08609~tplv-k3u1fbpfcp-watermark.image)

##### demo 2：跨行跨列表格

~~~php
<?php 
include '../vendor/autoload.php';

use whalephp\tool\PHPExcelHelper;

$ToolExcel = new PHPExcelHelper();

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
![](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/019eeae8518a49cfbe9fca98243b13b1~tplv-k3u1fbpfcp-watermark.image)

##### demo 3：指定列宽

~~~php
<?php 
include '../vendor/autoload.php';

use whalephp\tool\PHPExcelHelper;

$ToolExcel = new PHPExcelHelper();

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
![](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/ff0b239c71b54a4fbd222e3fd9875b8a~tplv-k3u1fbpfcp-watermark.image)

##### demo 4：指定sheet信息

~~~php
<?php
include '../vendor/autoload.php';

use whalephp\tool\PHPExcelHelper;

$ToolExcel = new PHPExcelHelper();

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
![](https://p3-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/428b9397cfa54da3a30a05d920f9fcf6~tplv-k3u1fbpfcp-watermark.image)


##### demo 5：多sheet

~~~php
<?php 
include '../vendor/autoload.php';

use whalephp\tool\PHPExcelHelper;

$ToolExcel = new PHPExcelHelper();

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
![](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/8ede852ca6574a3980dc22d9d24e1ffd~tplv-k3u1fbpfcp-watermark.image)



##### demo 6：综合（更多配置、支持json字符串解析）

~~~php
<?php 
include '../vendor/autoload.php';

use whalephp\tool\PHPExcelHelper;

$ToolExcel = new PHPExcelHelper();

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
    array('id'=>1,'name'=>'a','nickname'=>'aa2',                    'data'=>["a"=>"aaa","b"=>"bbb","c"=>"ccc"]),
    array('id'=>2,'name'=>'b','nickname'=>'bb2',                    'data'=>'{"a":"111","b":"222","c":"333"}'),
    array('id'=>3,'name'=>'c','nickname'=>'ddddddddddddddddddd2',   'data'=>'{"a":"aaa111","b":"bbb222","c":"ccc333"}'),
);
$key_02 = array(
    'id'	    => '编号二',
    'name'	    => ['姓名二',15],
    'nickname'	=> '昵称二',
    'data.a'	=> '节点a',
    'data.b'	=> 'data.b',
    'data'	    => [
        'title'     => '格式化数据',
        'width'     => 50,
        'parse_json'=> [
            'a' => '节点(a)',
            'b' => '节点(b)',
            'c' => '节点c',
        ]
    ],
    'data2'	    => [
        'title'     => '原始数据',
        'field'     => 'data',  // 对应数据中实际的字段键值
        'width'     => 40
    ]
);

$fileInfo = [
    'file_name' => '简版测试',
    'width' => 20,          // 指定默认宽度
    'sheet' => [
        ['sheetIndex'=>0,'sheetTitle'=>'工作区一'],
        ['sheetIndex'=>1,'sheetTitle'=>'工作区二'],
    ]
];

$ToolExcel->exportExcelSimp($fileInfo,[$key_02,$key],[$list_02,$list]);
~~~
![](https://p9-juejin.byteimg.com/tos-cn-i-k3u1fbpfcp/7b246a86981c4428997becc6a3894042~tplv-k3u1fbpfcp-watermark.image)
