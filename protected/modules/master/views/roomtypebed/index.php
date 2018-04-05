<?php
$this->breadcrumbs=array(
	'Room type bed',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#roomtypebed-grid').yiiGridView('update', {
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
	'id'=>'roomtypebed-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		'room_type_bed_id',
		array('name'=>'refRoomtype.room_type_name', 'header'=>'Room type'),
		array('name'=>'refMasterbed.master_bed_name', 'header'=>'Master bed'),
		'room_type_bed_quantity_room',
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
		),
	),
)); ?>
