<?php
class FileUpload
{
	const PROPERTY_PHOTO_PATH = 1;


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
			case FileUpload::PROPERTY_PHOTO_PATH: // Untuk file Client_PO pada menu SO. (tdpso)
				$pathFile = Yii::app()->basePath.'/../upload/property_photo/'.$fileName;
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
			case FileUpload::PROPERTY_PHOTO_PATH: // Untuk foto biodata
				$pathFile = CHtml::normalizeUrl(array('/download','id'=>$id,'const'=>$constPath));
				//Yii::app()->baseUrl.'/upload/client_po/'.$fileName;
				break;
		}

		return $pathFile;
	}
}
