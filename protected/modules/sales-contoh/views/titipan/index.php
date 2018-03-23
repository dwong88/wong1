<?php
$this->breadcrumbs=array(
	'Titipan',
);

Yii::app()->clientScript->registerScript('search', "
$('#srcbutton').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('so-grid', {
		data: $(this).serialize()
	});
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

<?php

	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'so-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'summaryText'=>'Total: {count}',
	'columns'=>array(
		'so_cd',
		'titipan_currency',
		'total_titipan',
		'titipan_kurs',
		array('name'=>'is_print_titipan','value'=>'Status::$is_status[$data->is_print_titipan]'),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('style'=>'text-align:left'),
			'template'=>'{print} {update}',
			'buttons'=>array(
				'print'=>array(
					'visible' => '$data->isInvoice()',
					'imageUrl' => Yii::app()->request->baseUrl.'/images/print.png',
					'url' => 'CHtml::normalizeUrl(array("titipan/preview","id"=>$data->primaryKey))',
				),
			)
		),
	),
)); ?>