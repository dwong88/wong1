<?php
$this->breadcrumbs=array(
	'Change Password',
);
?>

<h1>Change Password #<?php echo $model->user_name; ?></h1>

<?php echo $this->renderPartial('_formchangepassword', array('model'=>$model)); ?>