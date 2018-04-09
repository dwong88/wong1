<?php
$this->breadcrumbs=array(
	'Room type bed'=>array('index'),
	'Create & Update',
);

$buttonBar = new ButtonBar('{list}');
$buttonBar->listUrl = array('index');
$buttonBar->render();
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>


<html>
<head></head>
<body>
	<header>
		header part
		ada menu
		sub menu
		language
		login
		register
	</header>

	slider


	content

	<footer>
		alamat?
		link
	</footer>
</body>
</html>
