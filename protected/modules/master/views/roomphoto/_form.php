<?php
#fungsi list data menggunakan GridView
$this->widget('application.extensions.widget.GridView', array(
	'id'=>'room-grid',
	'dataProvider'=>$modelphoto->search(),
	'filter'=>$modelphoto,
	'filterPosition'=>'',
	'columns'=>array(
		'photo_id',
		array('name'=>'refPropphototype.roomphototype_name', 'header'=>'Photo Type'),
		array(
            'filter' => '',
            'type' => 'raw',
						'value'=>'CHtml::tag("div",  array("style"=>"border: 1px solid #ddd; /* Gray border */border-radius: 4px;  /* Rounded border */padding: 5px; /* Some padding */" ,),CHtml::tag("img", array( "src" => "'.Yii::app()->request->baseUrl . '/upload/room_photo/{$data["filename"]}","width" =>"150px")))'
             ),
		array(
      'class'=>'CButtonColumn',
      'template'=>'{delete}',
			'deleteButtonUrl'=>'CHtml::normalizeUrl(array("room/delete", "id"=>$_GET["id"], "pid"=>$data->photo_id))',
		),
	),
));
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'roomphoto-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'title' => 'form title'),

)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($modelphoto->hasErrors()) echo $form->errorSummary($modelphoto); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($modelphoto,'filename'); ?>
		<?php echo $form->fileField($modelphoto,'doc'); ?>
		<?php echo $form->error($modelphoto,'doc'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($modelphoto,'roomphototype_id').'<br>'; ?>
		<?php echo $form->dropDownList($modelphoto,'roomphototype_id', CHtml::listData(Roomphototype::model()->findAll(), 'roomphototype_id', 'roomphototype_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($modelphoto,'roomphototype_id'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($modelphoto->isNewRecord ? 'Save' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->