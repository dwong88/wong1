<h1>Property Setup</h1>
<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
				'General'=>array('id'=>'General','content'=>$this->renderPartial(
										'_formgeneral',
										array('model'=>$model),TRUE
										)),
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>false,
    ),
    'id'=>'MyTab-Menu',
));
?>
