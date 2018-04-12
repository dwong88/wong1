<?php
$this->breadcrumbs=array(
	'Basepricerooms',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#basepriceroom-grid').yiiGridView('update', {
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
	'id'=>'basepriceroom-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'refRoomtype.room_type_name', 'header'=>'Room Type'),
		'hours',
		'price',
		array(
      'class'=>'CButtonColumn',
      'template'=>'{update}',
			'updateButtonUrl'=>'CHtml::normalizeUrl(array("Basepriceroom/update", "id"=>$data->room_type_id))',
		),
	),
)); ?>
