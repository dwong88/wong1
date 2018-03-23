<?php
class FileUpload 
{
	const CLIENT_PO_PATH = 1;
	const CLIENT_DEVO_PATH = 2;
	const CLIENT_SOINVOICE_PATH = 3;
	
	/***
	 * Untuk dapatin file path untuk upload file. "C:\xampp\htdocs\del\upload\foto\file.ext"
	 * @param String $fileName filename dan extention dari file yang mau di upload
	 * @param String $constPath variable constant yang ada diatas
	 * @return String a Complete upload path for file upload.
	 */
	public static function getFilePath($fileName, $constPath) 
	{
		$pathFile = '';
		switch($constPath) {
			case FileUpload::CLIENT_PO_PATH: // Untuk file Client_PO pada menu SO. (tdpso)
				$pathFile = Yii::app()->basePath.'/../upload/client_po/'.$fileName;
				break;
			case FileUpload::CLIENT_DEVO_PATH:
				$pathFile = Yii::app()->basePath.'/../upload/client_devo/'.$fileName;
				break;
			case FileUpload::CLIENT_SOINVOICE_PATH:
				$pathFile = Yii::app()->basePath.'/../upload/client_soinvoice/'.$fileName;
				break;
		}
		return $pathFile;
	}
	
	/**
	 * 
	 * Digunakan untuk memanggil ksh url dari target download.
	 * @param String $id
	 * @param Number $constPath
	 */
	public static function getHttpPath($id, $constPath)
	{
		$pathFile = '';
		switch($constPath) {
			case FileUpload::CLIENT_PO_PATH: // Untuk foto biodata
				$pathFile = CHtml::normalizeUrl(array('/download','id'=>$id,'const'=>$constPath));
				//Yii::app()->baseUrl.'/upload/client_po/'.$fileName;
				break;
			case FileUpload::CLIENT_DEVO_PATH:
				$pathFile = CHtml::normalizeUrl(array('/download','id'=>$id,'const'=>$constPath));
				break;
			case FileUpload::CLIENT_SOINVOICE_PATH:
				$pathFile = CHTML::normalizeUrl(array('/download','id'=>$id,'const'=>$constPath));
				break;
		}
		
		return $pathFile;
	}
}