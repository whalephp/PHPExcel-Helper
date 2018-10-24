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
		'id'	=> '编号',
		'name'	=> '姓名',
        'nickname'	=> '昵称',
);
$ToolExcel->exportExcelSimp('简版测试',$key,$list);

