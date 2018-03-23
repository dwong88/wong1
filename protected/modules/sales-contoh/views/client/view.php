<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->client_cd,
);
?>

<?php Helper::showFlash(); ?>
<?php 
$buttonBar = new ButtonBar('{list} {create} {update} {delete}');
$buttonBar->listUrl = array('index');
$buttonBar->createUrl = array('create');
$buttonBar->updateUrl = array('update', 'id'=>$model->client_cd);
$buttonBar->deleteLinkHtmlOptions = array('submit'=>array('delete','id'=>$model->client_cd),'confirm'=>'Are you sure you want to delete this item?');
$buttonBar->render();
?>


<br/>
<h3>Client</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'client_cd',
		'client_name',
		array('label'=>'Sales Name', 'value'=>$model->employee->employee_name),
		'top',
		array('label'=>'Notes','type'=>'raw','value'=>nl2br($model->notes)),
	),
)); ?>

<br/>
<h3>Tax Information</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'npwp_no',
			'npwp_name',
			array('label'=>'Npwp Address','type'=>'raw','htmlOptions'=>array('width'=>'25%'),'value'=>nl2br($model->npwp_address)),
		)	
	  )); ?>


<br/>
<h3>Address</h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'addressdetail-grid',
			'dataProvider'=>$modelAddress->search(),
			'filterPosition'=>'',
			'columns'=>array(
				array('name'=>'short_desc','htmlOptions'=>array('width'=>'15%')),
				'phone',
				'fax',
				array('name'=>'address','type'=>'raw','value'=>'nl2br($data->address)','htmlOptions'=>array('width'=>'20%')),
				array('name'=>'notes','type'=>'raw','value'=>'nl2br($data->notes)','htmlOptions'=>array('width'=>'20%')),
				array('name'=>'status','value'=>'Status::$is_status[$data->status]'),
			),//end array columns
		)); ?>

<br/>
<h3>Contact Person</h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'contactdetail-grid',
			'dataProvider'=>$modelContact->search(),
			'filterPosition'=>'',
			'columns'=>array(
				array('name'=>'contact_name','htmlOptions'=>array('width'=>'15%')),
				'phone_no',
				'position',
				array('name'=>'notes','type'=>'raw','value'=>'nl2br($data->notes)','htmlOptions'=>array('width'=>'20%')),
				array('name'=>'status','value'=>'Status::$is_status[$data->status]'),
			),//end array columns
		));
		
?>

<br/>
<h3>Identity Information</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
	  		array('label'=>'Employee Create', 'value'=>$model->create->employee_name),
			array('name' =>'create_dt', 'type'=>'datetime'),
			array('label'=>'Employee Update', 'value'=>$model->update->employee_name),
			array('name' =>'update_dt', 'type'=>'datetime'),
		)
)); ?>
