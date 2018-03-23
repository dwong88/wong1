<?php
$this->breadcrumbs=array(
	'Soinvoices'=>array('index'),
	$modelSoInvoice->soinvoice_cd=>array('view','id'=>$modelSoInvoice->soinvoice_cd),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$modelSoInvoice->soinvoice_cd);
$buttonBar->render();
?>
<?php Helper::registerNumberField('.tnumber'); ?>
<?php echo $this->renderPartial('_form', array('model'=>$modelSoInvoice)); ?>
<?php if($modelSoInvoice->is_down_payment==0):?>
<?php echo $this->renderPartial('_formdetail', array('model'=>$modelSoInvoiceDO,'soinvoice_cd'=>$modelSoInvoice->soinvoice_cd,'so_cd'=>$modelSoInvoice->so_cd)) ?>
<?php endif;?>
<?php echo $this->renderPartial('_griditemdetail', array('model'=>$modelSoInvoiceDetail,'item_code'=>$modelSoInvoiceDetail->item_cd)); ?>