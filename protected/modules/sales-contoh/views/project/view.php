<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->project_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->project_name);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->project_name),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'project_name',
		array('name'=>'start_date', 'type'=>'date'),
		array('name'=>'end_date', 'type'=>'date'),
		array('name'=>'Is Closed','value'=>Status::$is_status[$model->is_closed]),
		'project_notes',
		array('label'=>'Client Name', 'value'=>$model->client->client_name),
		array('label'=>'Employee Name', 'value'=>$model->client->employee->employee_name),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('label'=>'Create By', 'value'=>$model->create->employee_name),
		array('name'=>'update_dt', 'type'=>'datetime'),
		array('label'=>'Update By', 'value'=>$model->update->employee_name),
	),
)); ?>
