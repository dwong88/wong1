<?php
$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->country_name=>array('view','id'=>$model->countryid),
	'Update',
);

$buttonBar = new ButtonBar('{list} {create} {view}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->viewUrl = array('view', 'id'=>$model->countryid);
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
