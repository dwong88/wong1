<?php
$this->breadcrumbs=array(
	'Properties'=>array('index'),
	'Create',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php $this->renderPartial('_formterms', array('modeldesc'=>$modeldesc)); ?>
