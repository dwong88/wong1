<h1>Default CJuiTabs</h1>
<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
				'General'=>array('id'=>'General','content'=>$this->renderPartial(
										'_formgeneral',
										array('model'=>$model),TRUE
										)),
				'Policies'=>array('id'=>'Policies','content'=>$this->renderPartial(
										'_formterms',
										array('modeldesc'=>$modeldesc),TRUE
										)),
				/*'Features'=>array('id'=>'Features','content'=>$this->renderPartial(
										'_formfeatures',
										array('model'=>$model),TRUE
										)),
				'Photos'=>array('id'=>'Photos','content'=>$this->renderPartial(
										'_formphotos',
										array('model'=>$model),TRUE
                  )),*/
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>false,
    ),
    'id'=>'MyTab-Menu',
));
?>
