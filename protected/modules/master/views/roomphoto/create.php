<?php
$this->breadcrumbs=array(
	'Roomphotos'=>array('index'),
	'Create',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model,'modelphoto'=>$modelphoto)); ?>
