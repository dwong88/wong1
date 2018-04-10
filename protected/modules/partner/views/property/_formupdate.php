<h1>Update Property</h1>
<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
				'General'=>array('id'=>'General','content'=>$this->renderPartial(
										'_formgeneral',
										array('model'=>$model,'mStatec'=>$mStatec),TRUE
										)),
        'Policies'=>array('id'=>'Policies','content'=>$this->renderPartial(
                      '_formterms',
                      array('modeldesc'=>$modeldesc),TRUE
                      )),
          'Features'=>array('id'=>'Features','content'=>$this->renderPartial(
                      '_formfeatures',
                      array('mFeat'=>$mFeat,'checkedFeat'=>$checkedFeat),TRUE
                      )),
          'Photos'=>array('id'=>'Photos','content'=>$this->renderPartial(
                      '_formphotos',
                      array('modelphoto'=>$modelphoto),TRUE
                    )),
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>false,
    ),
    'id'=>'MyTab-Menu',
));
?>
