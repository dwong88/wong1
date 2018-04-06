<style>
    div.form label {
        display: inline;
    }
    #ul-features li {
        width: 33%;
        float: left;
    }
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roomtypefeatures-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>	
    
    <table>
	<div class="row">
        <?php echo $form->labelEx($model,'room_features_id'); ?>
        <tr>
		<td colspan="3">
            <ul id="ul-features">
                <?php echo $form->checkBoxList($model,'room_features_id', CHtml::listData(Roomfeatures::model()->findAll(), 'room_features_id', 'room_features_name'),array('prompt'=>'', 'template'=>'<li>{input} {label}</li>')); ?>
            </ul>
            <div style="clear: both;"></div>
        </td>

        </tr>
        <?php echo $form->error($model,'room_features_id'); ?>
	</div>
    </table>
    
    
    
	<div class="row">
		<?php echo $form->labelEx($model,'room_type_id'); ?>
		<?php echo $form->dropDownList($model,'room_type_id', CHtml::listData(Roomtype::model()->findAll(), 'room_type_id', 'room_type_name'),array('prompt'=>'')); ?>
		<?php echo $form->error($model,'room_type_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->