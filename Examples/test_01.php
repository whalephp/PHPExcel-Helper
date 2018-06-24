<?php 
include '../vendor/autoload.php';
include '../src/PHPExcelHelper.php';

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

