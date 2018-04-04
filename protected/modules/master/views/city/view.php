<?php
$this->breadcrumbs=array(
	'City'=>array('index'),
	$model->city_name,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->city_id);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->city_id),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'city_id',
		array('name'=>'state','value'=>$model->refState->state_name),
		'postal_code',
		'city_name',
		array('name'=>'create_dt', 'type'=>'datetime'),
        array('name'=>'create_by','value'=>$model->refUserupdate->user_name),
        array('name'=>'update_dt', 'type'=>'datetime'),
        array('name'=>'update_by','value'=>$model->refUserupdate->user_name)
	),
)); ?>
