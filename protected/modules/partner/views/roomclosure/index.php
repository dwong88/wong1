<?php
$this->breadcrumbs=array(
	'Roomclosures',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#roomclosure-grid').yiiGridView('update', {
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
$buttonBar->searchLinkHtmlOptions = array('cl_id'=>'srcbutton');
$buttonBar->createUrl = array('create');
$buttonBar->render();
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.extensions.widget.GridView', array(
	'id'=>'roomclosure-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'cl_id',
		array('name'=>'refRoom.room_name', 'header'=>'Room'),
		'start_date',
		'end_date',
		'status',
		array('name'=>'refUsercreate.user_name', 'header'=>'Create By'),
		/*
		'create_by',
		'update_dt',
		'update_by',
		*/
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
