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
    array('id'=>1,'name'=>'a','nickname'=>'aa2',                    'data'=>["a"=>"aaa","b"=>"bbb","c"=>"ccc"]),
    array('id'=>2,'name'=>'b','nickname'=>'bb2',                    'data'=>'{"a":111.55555555555,"b":222.1000000000000009,"c":333.22222222}'),
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
            'c' => '节点c-指定最前',
            'a' => '节点(a)',
            'b' => '节点(b)',
        ]
    ],
    'data2'	    => [
        'title'         => '原始数据-数组转json（默认可不传）',
        'to_str'        => 'json',
        'field'         => 'data',  // 对应数据中实际的字段键值
        'width'         => 40
    ],
    'data3'	    => [
        'title'         => '原始数据-数组用指定字符拼接',
        'to_str'        => '-',
        'field'         => 'data',  // 对应数据中实际的字段键值
        'width'         => 40
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

