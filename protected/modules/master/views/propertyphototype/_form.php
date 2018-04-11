<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertyphototype-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'propertyphototype_name'); ?>
		<?php echo $form->textField($model,'propertyphototype_name',array('size'=>20,'maxlength'=>20,'placeholder'=>'Masukan Type Photo')); ?>
		<?php echo $form->error($model,'propertyphototype_name'); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNtFhOOiG7ZWxIYP3_Vic8Qd157YQit0g&callback=initialize"
    async defer></script>
<script type="text/javascript">
  var map;
  function initialize() {
  var myLatlng = new google.maps.LatLng(-6.214626,106.84513);

  var myOptions = {
     zoom: 8,
     center: myLatlng,
     mapTypeId: google.maps.MapTypeId.ROADMAP
     }
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  var marker = new google.maps.Marker({
  draggable: true,
  position: myLatlng,
  map: map,
  title: "Your location"
  });

  google.maps.event.addListener(marker, 'dragend', function (event) {
      document.getElementById("latbox").value = this.getPosition().lat();
      document.getElementById("lngbox").value = this.getPosition().lng();
  });

}
</script>
<div id="latlong">
	<p>Latitude: <input size="20" type="text" id="latbox" name="lat" ></p>
	<p>Longitude: <input size="20" type="text" id="lngbox" name="lng" ></p>
</div>
<div class="row">
  <div id="map_canvas" style="width:50%; height:50%; position:absolute;left:500px;top:auto;overflow: none"></div>
</div>
