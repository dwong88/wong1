<?php
$this->breadcrumbs=array(
	'Runningdates',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#runningdate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	$('.search-form').hide();
	return false;
});
");
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{search} {create}');
$buttonBar->searchLinkHtmlOptions = array('id'=>'srcbutton');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.extensions.widget.GridView', array(
	'id'=>'runningdate-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'runningdate',
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
