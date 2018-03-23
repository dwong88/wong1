<?php
$this->breadcrumbs=array(
	'Company Branch'=>array('index'),
	$model->branch_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->companybranch_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->companybranch_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'refCompany.company_name', 'label'=>'Company'),
		'branch_code',
		'branch_name',
		'branch_addr',
		'branch_phone',
		'notes',
		array('name'=>'refUsercreate.user_name', 'label'=>'Create By'),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('name'=>'refUserupdate.user_name', 'label'=>'Update By'),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
