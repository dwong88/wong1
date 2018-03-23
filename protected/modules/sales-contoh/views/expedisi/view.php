<?php
$this->breadcrumbs=array(
	'Expedisis'=>array('index'),
	$model->expedisi_cd,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->expedisi_cd);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->expedisi_cd),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'expedisi_cd',
		'expedisi_name',
		array('label'=>'Expedisi Address','type'=>'raw','htmlOptions'=>array('width'=>'25%'),'value'=>nl2br($model->expedisi_address)),
		'expedisi_contact',
		array('label'=>'Create By', 'value'=>$model->create->employee_name),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('label'=>'Update By', 'value'=>$model->update->employee_name),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>
