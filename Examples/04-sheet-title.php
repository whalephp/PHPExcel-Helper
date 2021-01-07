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

