<?php

class MenuController extends Controller
{
	public $layout='//layouts/column1';
	
	public function actionView($id)
	{
		$model = Vwmenu::model()->findByPk($id);
		$mDetail= new Vwmenuaction('search');
		$mDetail->unsetAttributes();
		$mDetail->menu_id = $id;
		
		$this->render('view',array(
			'model'=>$model,
			'mDetail'=>$mDetail
		));
	}

	public function actionCreate()
	{
		$model = new Menu;
		$model->parent_id = $_GET['parent_id'];
		
		if(isset($_POST['Menu']))
		{
			$model->attributes = $_POST['Menu'];
			if($model->parent_id == '')
				$model->parent_id  = 0;
			
			if($model->save()) 
			{
				if(!empty($model->default_url))
				{
					$pathMenu = explode("/", $model->default_url);
					if(count($pathMenu) == 3) 
					{
						//WT: default action to this new menu. We can delete which is not use
						$MenuRules = array('index'=>2,'view'=>2,'create'=>3,'update'=>4,'delete'=>5);
						
						foreach ($MenuRules as $MenuKey=>$MenuVal)
						{
							$mMenuAction = new Menuaction;
							$mMenuAction->menu_id = $model->menu_id;
							$mMenuAction->action_url = $pathMenu[0].'/'.$pathMenu[1].'/'.$MenuKey;
							$mMenuAction->group_id = $MenuVal;
							$mMenuAction->save();
						}
					}
				}
				
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('update','id'=>$model->menu_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionReorder($id)
	{
		$model	= Menu::model()->findAll(array('order'=>'menu_order ASC', 'condition'=>'parent_id=:parent_id', 
											'params'=>array(':parent_id'=>$id)));
		if(isset($_POST['Menu']))
		{
			for($i=0;$i<count($_POST['Menu']['menu_id']);$i++)
			{
				$menu_ordering_id = $_POST['Menu']['menu_id'][$i];
				$query 			  = 'UPDATE tdpmenu SET menu_order = '.($i+1).' 
									 WHERE parent_id = '.$id.' AND menu_id = '.$menu_ordering_id.'';
				DAO::executeSql($query);
			}

			$this->redirect(array('index'));
		}
		
		$this->render('reorder',array(
			'model'=>$model,
		));
	}

	
	public function actionUpdate($id)
	{
		$model	= $this->loadModel($id);
		
		$mDetail= new Vwmenuaction('search');
		$mDetail->unsetAttributes();
		$mDetail->menu_id = $id;
		
		if(isset($_POST['Menu']))
		{
			if((Menuaction::model()->find("menu_id='".$id."'")) !== NULL)
			{
				$model->attributes=$_POST['Menu'];
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Update Successfully");
					$this->redirect(array('view','id'=>$model->menu_id));	
				}
			}
			else
			{
				$model->addError($model->menu_id,'At least add one detail');
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'mDetail'=>$mDetail
		));
	}

	
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	

	private function genMenuButton($menu,$position = "haschild")
	{
		$menu_url[]    = CHtml::normalizeUrl(array('/core/menu/create', 'parent_id'=>$menu->menu_id));
		$menu_url[]    = CHtml::normalizeUrl(array('/core/menu/update', 'id'=>$menu->menu_id));
		$menu_url[]    = CHtml::normalizeUrl(array('/core/menu/reorder', 'id'=>$menu->menu_id));
		$menu_url[]    = CHtml::normalizeUrl(array('/core/menu/delete', 'id'=>$menu->menu_id));
		
		if($position == "haschild"):
			$menu_button = <<<EOF
			<div style='float:left;min-width:200px'>
				<div class='tree-menu-name'>{$menu->menu_name}</div>
			</div>
			<div style='float:left;min-width:200px'>
				 <a class='dp-link' title='Add' href='{$menu_url[0]}'><span style="float:left" class="ui-icon ui-icon-plus"></span></a>
				 <a class='dp-link' title='Edit' href='{$menu_url[1]}'><span style="float:left" class="ui-icon ui-icon-pencil"></span></a>
				 <a class='dp-link' title='Reorder' href='{$menu_url[2]}'><span style="float:left" class="ui-icon ui-icon-arrowthick-2-n-s"></span></a>
				 <a class='dp-link btn-del' title='Delete#{$menu->menu_id}' href='{$menu_url[3]}'><span style="float:left" class="ui-icon ui-icon-trash"></span></a>
			</div>
			<div style='clear:both'></div>
EOF;
		else:
					$menu_button = <<<EOF
			<div style='float:left;min-width:200px'>
				<div class='tree-menu-name'>{$menu->menu_name}</div>
			</div>
			<div style='float:left;min-width:200px'>
				 <a class='dp-link' title='Add' href='{$menu_url[0]}'><span style="float:left" class="ui-icon ui-icon-plus"></span></a>
				 <a class='dp-link' title='Edit' href='{$menu_url[1]}'><span style="float:left" class="ui-icon ui-icon-pencil"></span></a>
				 <a class='dp-link btn-del' title='Delete#{$menu->menu_id}' href='{$menu_url[3]}'><span style="float:left" class="ui-icon ui-icon-trash"></span></a>
			</div>
			<div style='clear:both'></div>
EOF;
		endif;
		return $menu_button;
	}

	private function genMenuButtonWebroot()
	{
		$menu_url[]    = CHtml::normalizeUrl(array('/core/menu/create', 'parent_id'=>0));
		$menu_url[]    = CHtml::normalizeUrl(array('/core/menu/reorder', 'id'=>0));
		
		$menu_button = <<<EOF
		<div style='float:left;min-width:200px'>
			<div class='tree-menu-name'>Webroot</div>
		</div>
		<div style='float:left;min-width:200px'>
			 <a class='dp-link' title='Add' href='{$menu_url[0]}'><span style="float:left" class="ui-icon ui-icon-plus"></span></a>
			 <a class='dp-link' title='Reorder' href='{$menu_url[1]}'><span style="float:left" class="ui-icon ui-icon-arrowthick-2-n-s"></span></a>
		</div>
		<div style='clear:both'></div>
EOF;
		return $menu_button;
	}

	
	
	public function genMenuDetailWButton($menu)
	{
		$menuChild 		= Menu::model()->findAll(array('order'=>'menu_order ASC', 'condition'=>'parent_id=:parent_id', 
													'params'=>array(':parent_id'=>$menu->menu_id)));
		$menu_parent_id = 0;
		
		if($menuChild == NULL)														// RECURSIVE END WHERE NO CHILD
			return array('text'=>$this->genMenuButton($menu,"nochild"));
		else
		{
			$arrTemp = array();
			foreach($menuChild as $mChild)
				$arrTemp[] 	= $this->genMenuDetailWButton($mChild);					// RECURSIVE			
				
			return array('text'=>$this->genMenuButton($menu),'children'=>$arrTemp);
		}
	}
	
	
	
	public function actionIndex()
	{
		$dtTreeViewRoot;
		$menuHeader  = Menu::model()->findAll(array('order'=>'menu_order ASC', 'condition'=>'parent_id = 0'));
		$dtTreeView	 = NULL;
		 
		$i = 0;
		foreach($menuHeader as $mHeader)
			$dtTreeView[$i++] = $this->genMenuDetailWButton($mHeader);
		
		
		$dtTreeView = array(array('text'=>$this->genMenuButtonWebroot(),'children'=>$dtTreeView));
		$this->render('index',array(
			'dtTreeView'=>$dtTreeView,
		));
	}

	
	public function loadModel($id)
	{
		$model = Menu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='currency-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
