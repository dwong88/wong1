<?php Helper::registerNumberField('.tnumber');  ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roomtype-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>
	
	<?php Helper::showFlash(); ?>
    
    <br><h1><?php echo $mProperty->property_name; ?></h1><br/>
    <?php echo $form->hiddenField($model,'property_id'); ?>
    
    <table>
    <tr>
        <td colspan="2">
        <div class="row">
            <?php echo $form->labelEx($model,'room_type_name'); ?>
            <?php echo $form->textField($model,'room_type_name',array('size'=>30,'maxlength'=>30)); ?>
            <?php echo $form->error($model,'room_type_name'); ?>
        </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <div class="row">
            <?php echo $form->labelEx($model,'room_type_desc'); ?>
            <?php echo $form->textArea($model,'room_type_desc',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'room_type_desc'); ?>
        </div>
        </td>
    </tr>

    <tr>
        <td style="width: 300px;">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_cleaning_minutes'); ?>
                <?php echo $form->textField($model,'room_type_cleaning_minutes'); ?>
                <?php echo $form->error($model,'room_type_cleaning_minutes'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_availability_threshold'); ?>
                <?php echo $form->textField($model,'room_type_availability_threshold'); ?>
                <?php echo $form->error($model,'room_type_availability_threshold'); ?>
            </div>
        </td>
    </tr>
    
    <tr>
        <td style="width: 300px;">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_minimum_availability_threshold'); ?>
                <?php echo $form->textField($model,'room_type_minimum_availability_threshold'); ?>
                <?php echo $form->error($model,'room_type_minimum_availability_threshold'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_default_minimum_stay'); ?>
                <?php echo $form->textField($model,'room_type_default_minimum_stay'); ?>
                <?php echo $form->error($model,'room_type_default_minimum_stay'); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_default_maximum_stay'); ?>
                <?php echo $form->textField($model,'room_type_default_maximum_stay'); ?>
                <?php echo $form->error($model,'room_type_default_maximum_stay'); ?>
            </div>
        </td>
    </tr>
    </table>
    
    
    <br>
    <br>
    <h1>RATES</h1>
    <br/>

    <table>
    <tr>
        <td style="width: 300px;">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_rack_rate'); ?>
                <?php echo $form->textField($model,'room_type_rack_rate',array('size'=>15,'maxlength'=>15, 'class'=>'tnumber col-right')); ?>
                <?php echo $form->error($model,'room_type_rack_rate'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_default_extra_child_rate'); ?>
                <?php echo $form->textField($model,'room_type_default_extra_child_rate',array('size'=>15,'maxlength'=>15, 'class'=>'tnumber col-right')); ?>
                <?php echo $form->error($model,'room_type_default_extra_child_rate'); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 300px;">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_default_extra_adult_rate'); ?>
                <?php echo $form->textField($model,'room_type_default_extra_adult_rate',array('size'=>15,'maxlength'=>15, 'class'=>'tnumber col-right')); ?>
                <?php echo $form->error($model,'room_type_default_extra_adult_rate'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_default_infant_rate'); ?>
                <?php echo $form->textField($model,'room_type_default_infant_rate',array('size'=>15,'maxlength'=>15, 'class'=>'tnumber col-right')); ?>
                <?php echo $form->error($model,'room_type_default_infant_rate'); ?>
            </div>
        </td>
    </table>
    
    <br>
    <br>
    <h1>OCCUPANCIES</h1>
    <br/>
    
    <table>
    <tr>
        <td style="width: 300px;">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_included_occupants'); ?>
                <?php echo $form->textField($model,'room_type_included_occupants'); ?>
                <?php echo $form->error($model,'room_type_included_occupants'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_maximum_occupants'); ?>
                <?php echo $form->textField($model,'room_type_maximum_occupants'); ?>
                <?php echo $form->error($model,'room_type_maximum_occupants'); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 300px;">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_adult_required'); ?>
                <?php echo $form->textField($model,'room_type_adult_required'); ?>
                <?php echo $form->error($model,'room_type_adult_required'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_room_size'); ?>
                <?php echo $form->textField($model,'room_type_room_size',array('size'=>20,'maxlength'=>20)); ?>
                <?php echo $form->error($model,'room_type_room_size'); ?>
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 300px;">    
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_bed_size'); ?>
                <?php echo $form->textField($model,'room_type_bed_size',array('size'=>20,'maxlength'=>20)); ?>
                <?php echo $form->error($model,'room_type_bed_size'); ?>
            </div>
        </td>
        <td>
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_guest_capacity'); ?>
                <?php echo $form->textField($model,'room_type_guest_capacity'); ?>
                <?php echo $form->error($model,'room_type_guest_capacity'); ?>
            </div>
        </td>
    <tr>
        <td colspan="2">
            <div class="row">
                <?php echo $form->labelEx($model,'room_type_total_room'); ?>
                <?php echo $form->textField($model,'room_type_total_room'); ?>
                <?php echo $form->error($model,'room_type_total_room'); ?>
            </div>
        </td>
    </tr>
    </table>
    <br/>

    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
