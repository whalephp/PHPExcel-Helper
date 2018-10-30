<?php
namespace whalephp\tool;
use PHPExcel_IOFactory;
use PHPExcel;

class PHPExcelHelper
{
	public function __construct(){
		ob_clean();
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Europe/London');
		
		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');
		
		//import('Vendor.Phpexcel.phpexcel');
		$this->objPHPExcel = new \PHPExcel();
	}
	
	public function getCharacterByColNum($col_num){
		if($col_num==26)return 'Z';
		$val = floor($col_num / 26);
		$currentChildCharacter = '';
		if($val>0){
			$currentChildCharacter .= chr(64+$val);
		}
		$val = $col_num % 26;
		if($val>0){
			$currentChildCharacter .= chr(64+$val);
		}
		return $currentChildCharacter;
	}







	//---------------------------------------------------------------------------------------------
    public function setProperties()
    {
        // Set document properties
        $this->objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
    }

    /**
     * excel头样式
     * @param array $config
     * @return array
     */
    public function excelHeaderStyle($config=[])
    {
        return array_replace([
            //'background'        => 'adadad',
            'center'            => 1,
            'bold'              => true,
        ],$config);
    }

    public function exportExcelAdv($file_name,$keyArr,$list,$excel_type='xls')
    {

    }

    public function createExcelSheet($file_info,$keyArr,$list)
    {
        // Sheet 设置
        if($file_info['sheetIndex']>0){     //创建附加工作表
            $newWorkSheet = new \PHPExcel_Worksheet($this->objPHPExcel, 'card_message'); 	//创建一个工作表
            $this->objPHPExcel->addSheet($newWorkSheet); 									        //插入工作表
            $this->objPHPExcel->setActiveSheetIndex($file_info['sheetIndex']);
        }
        $this->objPHPExcel->getActiveSheet()->setTitle( $file_info['sheetTitle'] );

        //生成表头
        $col_num        = 1;
        $toCCel         = 'A1';
        $allKey         = [];   // 全部使用到列Key
        $char_width     = [];   // 列宽
        foreach ($keyArr as $key=>$key_val){
            $width = null;
            $parse_json = null;

            if(is_array($key_val) && isset($key_val[0]) ){  // 索引配置：0 字段名 1 列宽
                $name  = $key_val[0];
                $width = $key_val[1];
            }elseif(is_array($key_val)) {   // 全量配置
                $name       = $key_val['title'];
                $width      = (isset($key_val['width']))?$key_val['width']:$width;
                $parse_json = (isset($key_val['parse_json']))?$key_val['parse_json']:$parse_json;
                $key        = (isset($key_val['field']))?$key_val['field']:$key;
            }else{  // 字符串配置：字段名
                $name = $key_val;
            }

            // 列内容填充
            //-----------------------------------------------
            $allKey[]       = [     // 生成数据主题需要使用的字段key
                'val_key'       => $key,
                'parse_json'    => $parse_json,
            ];
            $toCharacter    = $this->getCharacterByColNum($col_num);
            $toCCel         = $toCharacter . '1';	//列数
            $char_width[ $toCharacter ] = mb_strlen($name);
            $this->objPHPExcel->setActiveSheetIndex($file_info['sheetIndex'])->setCellValue( $toCCel, $name);
            $col_num++;

            // 设置列宽
            //-----------------------------------------------
            if($width || $file_info['width']){      // 指定宽度
                $width = ($width)?$width:$file_info['width'];
                $this->objPHPExcel->getActiveSheet()->getColumnDimension($toCharacter)->setWidth($width);
            }else{          // 设置自适应
                $this->objPHPExcel->getActiveSheet()->getColumnDimension($toCharacter)->setAutoSize(true);
            }
        }

        // 列头样式设置
        $this->setStyle('A1:'.$toCCel,array(),$this->excelHeaderStyle());
//
//        echo "<pre>";
//        var_dump($allKey);//exit();
//        echo "<br/>";var_dump($list);//exit();
//        echo "<hr/>";

        // 生成数据主体
        $col_num = 1;
        foreach ( $list as $i=>$one ){
            $col_num++;	//行数
            foreach ($allKey as $k=>$config){
                $toCharacter    = $this->getCharacterByColNum($k+1);
                $toCCel         = $toCharacter . $col_num;	//列数
                $val_key_arr    = explode('.',$config['val_key']);
                $val_key_count  = count($val_key_arr);
                $val_key_first  = $val_key_arr[0];
                $val            = $one[ $val_key_first ];
                $val_arr        = $val;     // 数组场景使用
                // 首先判断当前字段是否为字符串，是则转换成数组
                if( is_string($val_arr) ){
                    $temp = json_decode($val_arr,true);
                    if($temp)$val_arr = $temp;
                }

                if($val_key_count>1){                // 数组场景一：取出数组内的值
                    for ($j=1;$j<$val_key_count;$j++){
                        $val = $val_arr[ $val_key_arr[$j] ];
                    }
                }elseif ($config['parse_json']){    // 数组场景二：格式化json展示
                    $val = '';
                    //echo "<pre>";var_dump($config['parse_json']);var_dump($val_arr);exit();
                    foreach ($val_arr as $val_k=>$val_v){
                        if( isset($config['parse_json'][$val_k]) ){
                            $val .= $config['parse_json'][$val_k].':'.$val_v.';';
                        }
                    }
                }
                if(is_array($val)){     // 数组值，自动转换成json展示
                    $val = json_encode($val);
                }
                $this->objPHPExcel->setActiveSheetIndex($file_info['sheetIndex'])->setCellValue( $toCCel,$val );
            }
//            exit();
        }
    }

    /**
     * 快速导出excel（简洁版）
     * @param $file_name
     * @param $keyArr
     * @param $list
     * @param string $excel_type
     * @throws \PHPExcel_Exception
     */
	public function exportExcelSimp($file_info,$keyArr,$list,$excel_type='xls'){

        $file_info_defaulty = [
            'file_name'     => date('Y-m-d H:i:s'),
            'min_width'     => null,    // 指定默认最小宽度
            'sheetIndex'    => 0,
            'sheetTitle'    => '表一',
            'sheet'         => null,    // 多Sheet   [['sheetIndex' => 0,'sheetTitle' => '表一'],['sheetIndex' => 0,'sheetTitle' => '表一']]
        ];
        if(is_array($file_info)){
            $file_info = array_replace($file_info_defaulty,$file_info);
        }else{
            $file_info_defaulty['file_name'] = $file_info;
            $file_info = $file_info_defaulty;
        }

        $this->setProperties();

        if($file_info['sheet']){
            foreach ($file_info['sheet'] as $group=>$sheet){
                $file_info = array_replace($file_info,$sheet);
                $this->createExcelSheet($file_info,$keyArr[$group],$list[$group]);
            }
            $this->objPHPExcel->setActiveSheetIndex(0);
        }else{
            $this->createExcelSheet($file_info,$keyArr,$list);
        }

		//执行导出
		$this->doExport($file_info['file_name'],$excel_type);
	}
    //---------------------------------------------------------------------------------------------
	
	/**
	 * 生成Excel
	 * @param unknown $data
	 */
	public function createExcel($data){
		$sheetIndex = (isset($data['sheetInfo']['sheetIndex']))?$data['sheetInfo']['sheetIndex']:0;
		$sheetTitle = (isset($data['sheetInfo']['sheetTitle']))?$data['sheetInfo']['sheetTitle']:'表一';
		
		$start_row 	= (isset($data['startCell']['row']))?$data['startCell']['row']:1;
		$start_col 	= (isset($data['startCell']['col']))?$data['startCell']['col']:1;
		
		if($sheetIndex>0){
			//创建第二个工作表
			$newWorkSheet = new \PHPExcel_Worksheet($this->objPHPExcel, 'card_message'); 	//创建一个工作表
			$this->objPHPExcel->addSheet($newWorkSheet); 									//插入工作表
		}
		$this->objPHPExcel->setActiveSheetIndex($sheetIndex);
		$objSheet = $this->objPHPExcel->getActiveSheet();
		
		
		$cellData 			= $data['cellData'];
		
		//当前所有被占用格子数组
		$cellAllUsedArr = array();
		
		//遍历各行数据（最重要的是处理这些格子中的跨行跨列逻辑）
		foreach ( $cellData as $row=>$rowData ){		//遍历各行
			$row_num = $row + 1;
			foreach ( $rowData as $col=>$colData ){		//遍历各列
				
				$col_num = $col + 1;
				
				//当前格子跨行跨列数
				$rowspan = (isset($colData['rowspan']))?$colData['rowspan']:1;
				$colspan = (isset($colData['colspan']))?$colData['colspan']:1;
								
				if( !isset($cellAllUsedArr[$row_num]) ){
					$cellAllUsedArr[$row_num] = array();
				}
				//如果当前列被占，则继续向下一列延伸
				while ( isset($cellAllUsedArr[$row_num][$col_num]) ){
					$col_num++;
				}
				$cellAllUsedArr[$row_num][$col_num] = $colData['val'];
				
				
				$toCharacter 	= $this->getCharacterByColNum($col_num);
				$currentCell 	= $toCharacter . $row_num;					//列数
				
				
				$objSheet->setCellValue( $currentCell, $colData['val'] );
				
				
				$this->setStyle($currentCell,$toCharacter,$colData);
				
				if( $rowspan>1 || $colspan>1 ){	//如果存在跨行跨列
					
					for ($i=0;$i<$rowspan;$i++){
						for ($j=0;$j<$colspan;$j++){
							$cellAllUsedArr[$row_num+$i][$col_num+$j] = $colData['val'];
						}
					}
					$lo_col = $col_num - 1 + $colspan;
					$lo_row = $row_num - 1 + $rowspan;
					
					$toCharacter 	= $this->getCharacterByColNum($lo_col);
					$toEndCell 		= $toCharacter . $lo_row;
					
					$objSheet->mergeCells( $currentCell.':'.$toEndCell );
				}
			}
		}

// 		vde($cellAllUsedArr);
		// Rename worksheet
		$objSheet->setTitle( $sheetTitle );
	}
	
	/**
	 * 导出Excel
	 * @param unknown $data
	 */
	public function exportExcel($data){
	
		$file_name = $data['file_name'];
	
	
		// Set document properties
		$this->objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							->setLastModifiedBy("Maarten Balliauw")
							->setTitle("Office 2007 XLSX Test Document")
							->setSubject("Office 2007 XLSX Test Document")
							->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							->setKeywords("office 2007 openxml php")
							->setCategory("Test result file");
	
	
		if( isset($data['sheet_group']) ){
			foreach ($data['sheet_group'] as $oneData){
				$this->createExcel($oneData);
			}
		}else{
			$this->createExcel($data);
		}
		
		$excel_type = (isset($data['excel_type']))?$data['excel_type']:'xls';
		$this->doExport($file_name,$excel_type);
	}
	
	public function addRowColVal($rowAddColSpanArr,$toRowNum,$toColNum,$addNum=1){
		if( !isset($rowAddColSpanArr[$toRowNum][$toColNum]) )$rowAddColSpanArr[$toRowNum][$toColNum]=0;
		$rowAddColSpanArr[$toRowNum][$toColNum] += $addNum;
		
		return $rowAddColSpanArr;
	}
	
	/**
	 * 设置样式
	 * @param unknown $currentCell				当前格子
	 * @param unknown $currentChildCharacter
	 * @param unknown $colData					设置的样式内容数组
	 */
	public function setStyle($currentCell,$currentChildCharacter,$colData){
		
		$objSheet = $this->objPHPExcel->getActiveSheet();
		
		//添加批注
		if( isset($colData['remarks']) ){
			/*
			echo "########";
			vd($currentCell);vde($colData['remarks']);
			*/
			$objSheet->getComment($currentCell)->getText()->createText( $colData['remarks'] );
		}
		
		//设置加粗
		if( isset($colData['bold']) ){
			$objSheet->getStyle($currentCell)->applyFromArray( array('font'	=> array('bold' => true)) );
			
		}
		
		//设置样式
		if( isset($colData['style']) ){
			$objSheet->getStyle($currentCell)->applyFromArray( $colData['style'] );
		}
		
		//设置背景色
		if( isset($colData['background']) ){
			$objSheet->getStyle($currentCell)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()->setARGB( $colData['background'] );
		}
		
		//列宽
		if( isset($colData['set_width']) ){
			$objSheet->getColumnDimension( $currentChildCharacter )->setWidth( $colData['set_width'] );
		}
		
		//居中
		if( isset($colData['center']) && $colData['center'] ){
			$objSheet->getStyle($currentCell)->applyFromArray(array(
					'alignment' => array(
							'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical'	 => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
			));
		}
	}
	
	
	
	/**
	 * 执行导出
	 * @param unknown $file_name
	 */
	private function doExport($file_name,$excel_type='xls'){
		
		ob_end_clean();//清除缓冲区,避免乱码
		ob_start();
		
		if($excel_type=='xlsx'){
			//xlsx
			//=====================
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
				
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
				
			$objWriter = \PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
		}else{
			//
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = \PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}
	}
	
	
	
	
	
	public function readXlsx($uploadfile){
		$reader = \PHPExcel_IOFactory::createReader('Excel2007');
		$PHPExcel = $reader->load($uploadfile); // 文档名称
		//$objWorksheet = $PHPExcel->getActiveSheet();
		
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow 	= $sheet->getHighestRow(); 		// 取得总行数
		$highestColumm 	= $sheet->getHighestColumn(); 	// 取得总列数
		
		/** 循环读取每个单元格的数据 */
		$dataset = [];
		for ($column = 'A'; $column <= $highestColumm; $column++){//行数是以第1行开始
			for ($row =1; $row <= $highestRow; $row++) {//列数是以A列开始
				$dataset[$row][$column] = $sheet->getCell($column.$row)->getValue();
			}
		}
		return $dataset;
	}
	
	public function readXlsxByFileId($file_id){
		$info = model('File')->getInfo($file_id);
		$uploadfile = ROOT_PATH . $info['path'];
		$uploadfile = str_replace('\\\\', DS, $uploadfile);
		$uploadfile = str_replace('/\\', DS, $uploadfile);
		$uploadfile = str_replace('\\', DS, $uploadfile);
		
		return $this->readXlsx($uploadfile);
	}
	
	
}