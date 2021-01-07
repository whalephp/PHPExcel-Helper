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

