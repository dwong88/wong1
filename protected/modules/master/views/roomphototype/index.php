<?php
$this->breadcrumbs=array(
	'Roomphototypes',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#roomphototype-grid').yiiGridView('update', {
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
	'id'=>'roomphototype-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'roomphototype_id',
		'roomphototype_name',
		'create_dt',
		'create_by',
		'update_dt',
		'update_by',
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
