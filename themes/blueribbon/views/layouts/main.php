<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/sitemenu.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/site.css" />

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/moment.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/code/highcharts.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/code/modules/series-label.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/code/modules/exporting.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/code/modules/export-data.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<!-- Start PureCSSMenu.com MENU -->
		<ul class="pureCssMenu pureCssMenum">
			<?php if(Yii::app()->user->isGuest) { ?>
			<li class="pureCssMenui0"><a class="pureCssMenui0" href="<?php echo CHtml::normalizeUrl(array('/site/login'));?>">Login</a></li>
			<?php } else {
					$oMenuBar  = new MenuBar();
					$oMenuBar->generateMenu(); ?>
					<li class="pureCssMenui0"><a class="pureCssMenui0" href="<?php echo CHtml::normalizeUrl(array('/site/changepassword'));?>">Change Password</a></li>
					<li class="pureCssMenui0"><a class="pureCssMenui0" href="<?php echo CHtml::normalizeUrl(array('/site/logout'));?>">Logout (<?php echo Yii::app()->user->name; ?>)</a></li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
		<!-- End PureCSSMenu.com MENU -->
	</div><!-- mainmenu -->

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Home', Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Developer Team.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
