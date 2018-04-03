<?php
$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->country_name,
);
?>

<?php Helper::showFlash(); ?>
<?php
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->countryid);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->countryid),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'countryid',
		'country_name',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
	),
)); ?>
