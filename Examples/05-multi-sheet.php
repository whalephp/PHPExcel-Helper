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

