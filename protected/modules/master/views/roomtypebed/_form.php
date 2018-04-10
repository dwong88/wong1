<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roomtypebed-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
echo $form->hiddenField($model, 'room_type_bed_id');
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>


	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
<b style="font-size: 18px;">
    <?php
        if($model->isNewRecord) echo 'Create new bed';
        else
            echo 'Update';
    ?>
</b>
	<?php Helper::showFlash(); ?>
	<h2><?php
	if($_GET['id']!=null)
	{
		echo 'Nama Property:'.$qProperty['property_name'];
	} ?>
</h2>
	<div class="row">
		<?php echo $form->labelEx($model,'room_type_id'); ?>
		<?php
			if($_GET['id']==null)
			{
				echo $form->dropDownList($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'Pilih Room Type'));
			}
			else
			{
					echo $mRoomType->room_type_name;
			} ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'master_bed_id'); ?>
		<?php echo $form->dropDownList($model,'master_bed_id', CHtml::listData(Masterbed::model()->findAll(), 'master_bed_id', 'master_bed_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'master_bed_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_type_bed_quantity_room'); ?>
		<?php echo $form->textField($model,'room_type_bed_quantity_room', array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'room_type_bed_quantity_room'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php
if($_GET['id']!=null)
{
	echo CHtml::link('Create new bed', array('update','id'=>$model->room_type_id));
}
else
{
	 echo "";
}

$this->widget('application.extensions.widget.GridView', array(
	'id'=>'roomtypebed-grid',
	'dataProvider'=>$mBed->search(),
	'filter'=>$mBed,
	'filterPosition'=>'',
	'columns'=>array(
		'room_type_bed_id',
		array('name'=>'refRoomtype.room_type_name', 'header'=>'Room type'),
		array('name'=>'refMasterbed.master_bed_name', 'header'=>'Master bed'),
		'room_type_bed_quantity_room',
		array(
			'class'=>'application.extensions.widget.ButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                    'update'=>array(
                            'url'=>'CHtml::normalizeUrl(array("update","id"=>$data->room_type_id, "bedid"=>$data->room_type_bed_id))',

                    )
            )
		),
	),
)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
