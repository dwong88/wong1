<?php



 class ExcelReporting
 {
	// AH: Template
	private $sTemplateFileType;	
 	public  $oPHPExcel;
 	private $oActiveSheet;
 	private $lastDetailRow;
 	

 	// PHASE 1
 	// =========================================================
 	// initialization to trigger autoloading class of other PHPExcel (Ex:PHPExcel_IOFactory)  
 	
 	function init()
 	{
 		$this->oPHPExcel  = new PHPExcel();
 	}
 	
 	// PHASE 2
 	// =========================================================
 	// Example : $template_filetype = 'Excel5'
 	//           $template_path     = 'templates/30template.xls'
 	function loadTemplate($sTemplateFileType,$sTemplatePath)
 	{
 		
 		$oReader   				 = PHPExcel_IOFactory::createReader($sTemplateFileType);
 		$this->sTemplateFileType = $sTemplateFileType;
 		$this->oPHPExcel 		 = $oReader->load($sTemplatePath);
 		
 		$this->oPHPExcel->setActiveSheetIndex(0);
 		$this->oActiveSheet 	 = $this->oPHPExcel->getActiveSheet();
 		
 	}
 	
 	function getLastDetailRow()
 	{
 		return $this->lastDetailRow;	
 	}
 	
 	function renderCell($sCellPos,$sCellValue,$iswrap_text = false)
 	{
 		$this->oActiveSheet->setCellValue($sCellPos,$sCellValue);
 		$this->oActiveSheet->getStyle($sCellPos)->getAlignment()->setWrapText($iswrap_text);
 	}
 	

 	// Used when render with new line
 	// Automatically adjust row height  if needed
 	function renderCellWNL($sCellPos,$sCellValue,$iswrap_text = true,$isauto_height = false)
 	{
 		$this->oActiveSheet->setCellValue($sCellPos,$sCellValue);
 		$this->oActiveSheet->getStyle($sCellPos)->getAlignment()->setWrapText($iswrap_text);
 		
 		if($isauto_height){
	 		$iRowPos = preg_replace("/[^0-9]/", '', $sCellPos);
	 		$this->oActiveSheet->getRowDimension($iRowPos)->setRowHeight(-1);
 		}
 	}
 	
 	// AH: render with item name bold [build for {item name and item_desc}  only !]  
 	// pattern : {item_name}.'#'.{item_desc}
 	function renderCellWB($sCellPos,$sCellValue)
 	{
 		$sCellValue  = explode('#',$sCellValue);
 		
 		$objRichText = new PHPExcel_RichText();
 		$objBold = $objRichText->createTextRun($sCellValue[0]);
 		$objBold->getFont()->setBold(true);
 		
 		$objRichText->createText("\n".$sCellValue[1]);
 		$this->oActiveSheet->setCellValue($sCellPos,$objRichText);
 	}
 	
 	
 	function renderTableAR($sBaseColumn,$iBaseRow,$modelList)
 	{
 		$iRow 	   = $iBaseRow;
 		$sColumn   = $sBaseColumn;
 		$sBaseCell = NULL;
 		
 		foreach($modelList as $r => $model)
 		{
 			$sColumn = $sBaseColumn;
 			$this->oActiveSheet->insertNewRowBefore($iRow,1);
 			
 			foreach($model->getAttributes() as $attr)
 			{
 				$sBaseCell   = $sColumn.$iRow;
 				$this->oActiveSheet->setCellValue($sBaseCell, $attr);
 				++$sColumn;
 			}

 			$iRow 	 = $iBaseRow +1;
 		}
 		
 		$this->oActiveSheet->removeRow($iRow+1,2);		
 	}
 	
 	
 	// AH:
 	// column pos only rendered when 
 	// array( 'A-C','D',
 	function renderTableDAO($sBaseColumn,$iBaseRow,$arrResult,$arrColumnPos)
 	{	
 		$iBaseRow  = $iBaseRow+1;
 		$iRow 	   = $iBaseRow;
 		$sColumn   = $sBaseColumn;
 		$sBaseCell = NULL;
 		
 		$iRowCounter  = 0;
 		$iCellCounter = 0;
 		
 		foreach($arrResult as $r => $objResult)
 		{

 			$iCellCounter = 0;
 			$sColumn = $sBaseColumn;
 			$iRow 	 = $iBaseRow + $r;
 			$this->oActiveSheet->insertNewRowBefore($iRow,1);
 			
 			foreach($objResult as $key => $attr)
 			{
 				if($key == 'rwnum')
 					$attr = $r+1;

 				$temp    = $arrColumnPos[$iCellCounter];
 				$isMerge = false;
 				if(strpos($temp,'-') !== false){			// column needed to be merge
 					$isMerge = true;
 					$temp    = explode('-',$temp);
 					$this->oActiveSheet->mergeCells($temp[0].($iRow).":".$temp[1].($iRow));
 				}
 				
 				
 				
 				
 				$sBaseCell   = $sColumn.$iRow;
 				
 				if(strpos($attr,'#') !== false)
 					$this->renderCellWB($sBaseCell,$attr);
 				else
 					$this->oActiveSheet->setCellValue($sBaseCell, $attr);
 					
 				$this->oActiveSheet->getStyle($sBaseCell)->getAlignment()->setWrapText(true);
 				++$sColumn;
 				
 				if($isMerge){
 					$sColumn = ++$temp[1];
 				}
 				
 				$iCellCounter++;
 			}
 			
 			//$this->oActiveSheet->getRowDimension($iRow)->setRowHeight(-1);	
 			$iRowCounter++;
 		}
 			
 		$this->oActiveSheet->removeRow($iBaseRow-1,1);
 		
 		if($iRowCounter > 1)
 			$this->oActiveSheet->removeRow($iBaseRow+1,1);
 		else
 			$this->oActiveSheet->removeRow($iBaseRow,1);
 		
 		$this->lastDetailRow = $iRow;
 	}
 	
 	
 	
 	function copySheet($numberOfCopy)
 	{
 		/*
 		$templateSheet =  $this->oPHPExcel->getSheetByName("page1");
 		$newSheet = clone $templateSheet;
 		
 		for($i=1;$i<=$numberOfCopy;$i++)
 		{
	 		$newSheet->setTitle('page'.$i+1);
	 		$newSheetIndex = $i;
	 		$this->oPHPExcel->addSheet($newSheet,$newSheetIndex);
 		}*/
 	}
 	
 	function writeFile()
 	{
 		$objWriter = PHPExcel_IOFactory::createWriter($this->oPHPExcel,$this->sTemplateFileType);
 		$objWriter->save(str_replace('.php', '.xls', __FILE__));
 		echo " Success write File";
 	}
 	
 	
 }