<?php

class DownloadController extends Controller
{
	public function actionIndex($id,$const)
	{
		$serverFile='';
		switch($const)
		{
			case FileUpload::CLIENT_PO_PATH:
				$model = So::model()->findByPk($id);
				if($model===null)
					throw new CHttpException(404,'The requested page does not exist.');
				$serverFile = FileUpload::getFilePath($model->client_po_serverfile, FileUpload::CLIENT_PO_PATH);
				$clientFile = urlencode($model->client_po_clientfile);
				break;
			case FileUpload::CLIENT_DEVO_PATH:
				$model = Devo::model()->findByPk($id);
				if($model===null)
					throw new CHttpException(404,'The requested page does not exist.');
				$serverFile = FileUpload::getFilePath($model->devo_file_name, FileUpload::CLIENT_DEVO_PATH);
				$clientFile = urlencode($model->devo_file_name);
				break;
			case FileUpload::CLIENT_SOINVOICE_PATH:
				$model = Soinvoice::model()->findByPk($id);
				if($model===null)
					throw new CHttpException(404,'The requested page does not exist.');
				$serverFile = FileUpload::getFilePath($model->invoice_file_name, FileUpload::CLIENT_SOINVOICE_PATH);
				$clientFile = urlencode($model->invoice_file_name);
				break;
		}
		//echo $clientFile;
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$clientFile");
		echo file_get_contents($serverFile);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array_merge(array(
				array('allow',
						'actions'=>array('index'),
						'users'=>array('@'),
				),
		),parent::accessRules());
	}
}