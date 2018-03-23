<?php
/* @var $this SoreturController */
/* @var $model Soretur */

$this->breadcrumbs=array(
	'Soreturs'=>array('index'),
	$model->soretur_cd,
);
?>


<?php
/*$this->menu=array(
	array('label'=>'List Soretur', 'url'=>array('index')),
	array('label'=>'Create Soretur', 'url'=>array('create')),
	array('label'=>'Update Soretur', 'url'=>array('update', 'id'=>$model->do_cd)),
	array('label'=>'Delete Soretur', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->do_cd),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Soretur', 'url'=>array('admin')),
);*/

	/*$buttonBar = new ButtonBar('{list} {create} {update}');
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	$buttonBar->updateUrl = array('update', 'id'=>$model->do_cd);
	if($model->status == "Complete")
	{*/
	//if(!$model->status==STATUS::CORE_STATUS_OPEN && $model->delivery_status==Status::DEPEDENCY_STATUS_NOTYET)
	//{
		$buttonBar = new ButtonBar('{list} {create} {update} {print}');
		$buttonBar->listUrl = array('index');
		$buttonBar->createUrl = array('create');
		$buttonBar->updateUrl = array('update', 'id'=>$model->soretur_cd);
		$buttonBar->printUrl = Yii::app()->createUrl('sales/soretur/preview',array('id'=>$model->soretur_cd));
		$buttonBar->printLinkHtmlOptions= array('target'=>'_blank');
		$buttonBar->printLinkHtmlOptions= array('target'=>'_blank');
	/*}
	else
	{
		$buttonBar = new ButtonBar('{list} {create}');
		$buttonBar->listUrl = array('index');
		$buttonBar->createUrl = array('create');
	}*/
	//}
	$buttonBar->render();
?>


<br/>
<h3>Soretur</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'soretur_cd',
		'do_cd',
		array('name'=>'Client','value'=>$model->client_cd." - " .$model->client->client_name),
		array('label'=>'Notes','type'=>'raw','htmlOptions'=>array('width'=>'25%'),'value'=>nl2br($model->notes)),
	),
)); ?>


<br/>
<h3>Soretur Status</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'status', 'value'=>Status::$core_status[$model->status]),
		array('name'=>'received_status', 'value'=>Status::$depedency_status[$model->received_status]),
	),
)); ?>



<br/>
<h3>Identity Attribute</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('label'=>'Employee Create', 'value'=>$model->create->employee_name),
		array('name'=>'create_dt', 'type'=>'datetime'),
		array('label'=>'Employee Update', 'value'=>$model->update->employee_name),
		array('name'=>'update_dt', 'type'=>'datetime'),
	),
)); ?>


		

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'rrdetail-grid',
		'dataProvider'=>$mDetail->search(),
		'filter'=>$mDetail,
		'filterPosition'=>'',
		'columns'=>array(
			'item_cd',
			'item.item_name',
			'item.itemtype_name',
			'item.product_number',	
			array('name'=>'item.item_desc','htmlOptions'=>array('width'=>'30%')),
			array('name'=>'qty','type'=>'number','htmlOptions'=>array('class'=>'col-right')),
			array('name'=>'qty_received','type'=>'number','htmlOptions'=>array('class'=>'col-right')),
			array('name'=>'Notes','type'=>'raw','htmlOptions'=>array('width'=>'25%'),'value'=>'nl2br($data->notes)'),
		),
	));
?>
