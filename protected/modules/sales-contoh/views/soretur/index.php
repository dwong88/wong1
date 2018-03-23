<?php
$this->breadcrumbs=array(
	'Soretur',
);

Yii::app()->clientScript->registerScript('search', "
	$('#srcbutton').click(function(){
		$('.search-form').toggle();
		return false;
	});
		
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('soretur-grid', {
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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'soretur-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'soretur_cd','header'=>'Soretur Cd'),
		array('name'=>'do_cd','header'=>'Do Cd'),
		array('name'=>'client.client_name','header'=>'Client Name'),
		array('name'=>'signed.employee_name','header'=>'Signer Name'),
		array('name'=>'status','value'=>'Status::$core_status[$data->status]'),
		array('name'=>'received_status','value'=>'Status::$depedency_status[$data->received_status]'),
		array('name'=>'update.employee_name', 'header'=>'Employee update'),
		array('name'=>'update_dt', 'type'=>'dateTIME'),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('style'=>'text-align:left'),
			'buttons'=>array(
				'update' => array( 'visible' => '$data->isCanDeletedOrModified("status")' ),
				'delete' => array( 'visible' => '$data->isCanDeletedOrModified("status")' ),
)
		),
	),
)); ?>
