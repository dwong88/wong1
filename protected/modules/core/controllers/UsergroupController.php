<?php

class UsergroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	public function actionAjxSearchUser() 
	{
        $search_key  = $_POST['search'];	
        $search_user = User::model()->findAll(array('condition'=>'user_name LIKE :user_name','params'=>array(':user_name'=>'%'.$search_key.'%')));
		$result;
		foreach($search_user as $item)
			$result['users'][] = array('user_id' => $item->user_id ,'user_name'=> $item->user_name);		
		
        header("content-type: application/json");
        echo CJSON::encode($result);
    }
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Usergroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usergroup']))
		{
			$model->attributes=$_POST['Usergroup'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Create Successfully");
				$this->redirect(array('view','id'=>$model->usergroup_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usergroup']))
		{
			$model->attributes = $_POST['Usergroup'];
			$model->default_redirect = $_POST['Usergroup']['default_redirect'];
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Update Successfully");
				$this->redirect(array('view','id'=>$model->usergroup_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Usergroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usergroup']))
			$model->attributes=$_GET['Usergroup'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionUserlist()
	{
		$model =  Usergroup::model()->findByPk($_REQUEST['id']);
		
		if(isset($_POST['registereduser']))
		{
			$registered = @$_POST['registereduser'];

			if(!is_array($registered))
            	$registered = array($registered);
        	
			Usergroupdetail::model()->deleteAll(array('condition'=>'usergroup_id=:usergroup_id','params'=>array(':usergroup_id'=>$model->usergroup_id)));
			foreach($registered as $user_id) 
        	{
	            $newuser = new Usergroupdetail();
	            $newuser->user_id 	   = $user_id;
	            $newuser->usergroup_id = $model->usergroup_id;
	            $newuser->save();
        	}	
        	$this->redirect(array('view','id'=>$model->usergroup_id));	
		}		
        

		$this->render('userlist',array(
			'model'=>$model,
		));
	}
	
	
	
	private $menuCounter;
	
	private function genMenuAction($menu,$group_id)
	{
		$txtMenuAction = '';
		$j=0;
		
		foreach($menu->menuactions as $mAction)
		{
			$class = 'act-1 ';
			if($mAction->group_id > 1)
			{
				for($i = $mAction->group_id;$i<=count($menu->menuactions);$i++)
				$class .= 'act-'.$i.' ';
			}
			
			// if alerady given access before checked the action
			$condition		= array('condition'=>'usergroup_id=:usergroup_id AND menuaction_id=:menuaction_id',
									'params'=>array(':usergroup_id'=>$group_id,
													':menuaction_id'=>$mAction->menuaction_id));
			$usergroupakses = Usergroupakses::model()->findAll($condition);
			
			$txtMenuAction .= '<input type="checkbox" class="'.$class.'" 
								name="Usergroupakses[]" '.((empty($usergroupakses))?'':'checked="checked"').'
								value="'.($mAction->menu_id.'#'.$mAction->menuaction_id).'" 
								title="'.$mAction->menuaction_desc.'"/>'.$mAction->action_url.' &nbsp';
			
			$j++;
			if($j%4 == 0)
				$txtMenuAction .= "<br/>";
			
		}
		
		return $txtMenuAction;	
	}
	
	private function genMenuActionGroup($menu,$group_id)
	{
		$menuActionGroup = Actiongroup::model()->findAll();
		
		
		
		$query 			 = "SELECT MAX(group_id) AS mx_group_id 
							  FROM tdpactiongroup a 
							  WHERE group_id IN  
							  	( SELECT group_id FROM tdpmenuaction 
							  		WHERE menu_id = ".$menu->menu_id." AND menuaction_id IN  
							  		( SELECT menuaction_id FROM tdpusergroupakses
							  		 	WHERE usergroup_id = ".$group_id." )
							  	)";
		$mx_group_id	= DAO::queryRowSql($query);
		
		// reduce from array to integer
		$mx_group_id 	= $mx_group_id['mx_group_id'];
		if(empty($mx_group_id))
			$mx_group_id = 1;
 
		 
		$txtMenuActionGroup = '';
		$i = 1;
		foreach($menuActionGroup as $mActionGroup)
		{
			$txtMenuActionGroup .= '<input type="radio" name="rad-act-group-'.$this->menuCounter.'" class="rad-act-group" class="rad-act-group" '.
										 (($i==$mx_group_id)?'checked="checked"':'').' value="act-'.$mActionGroup->group_id.'" />'.
										 $mActionGroup->group_name;
			$i++;
		}	
		
		$this->menuCounter++;
		return $txtMenuActionGroup;
	}
	
	private function genMenuDetail($menu,$group_id)
	{
		$txtMenuAction		= $this->genMenuAction($menu,$group_id);
		$txtMenuActionGroup = $this->genMenuActionGroup($menu,$group_id); 
		$textMenuDetail     = <<<EOF
			<div style='float:left;min-width:200px'>
				<div class='tree-menu-name'>$menu->menu_name</div>
			</div>
			<div style='float:left;min-width:200px'>
				<div class='tree-menu-act-group'>$txtMenuActionGroup</div>
				<div class='tree-menu-act'>$txtMenuAction</div>
			</div>
			<div style='clear:both'></div>
EOF;
		return $textMenuDetail;
	}
	
	private function genMenu($menu,$group_id)
	{
		$textMenuDetail 	= $menu->menu_name;
		
	
		// cheking have children or not
		$menuChild 		= Menu::model()->with('menuactions')->findAll(array('order'=>'menu_order ASC', 'condition'=>'parent_id=:parent_id', 
																	'params'=>array(':parent_id'=>$menu->menu_id)));
			
		if($menuChild == NULL)
		{
			//checking have menu action or not
			if($menu->menuactions != NULL)
				$textMenuDetail = $this->genMenuDetail($menu,$group_id);
			
			return array('text'=>$textMenuDetail);
		}
		else
		{
			$arrTemp = array();
			foreach($menuChild as $mChild)		
				$arrTemp[] 		= $this->genMenu($mChild,$group_id);
			
			return array('text'=>$menu->menu_name,'children'=>$arrTemp);
		}	
	}
	
	public function actionMenuConf($id)
	{
		if(isset($_POST['Usergroupakses']))
		{
			$flag  = -1;
			$sccss = DAO::executeSql("DELETE FROM tdpusergroupmenu WHERE usergroup_id=".$id);
			$sccss = DAO::executeSql("DELETE FROM tdpusergroupakses WHERE usergroup_id=".$id);
			$tempe = -1;
			
			foreach ($_POST['Usergroupakses'] as $val) 
			{
				$temp = explode('#', $val);
				
				if($flag != $temp[0]){	// insert usergroup menu
					$sccss = DAO::executeSql("INSERT INTO tdpusergroupmenu VALUES (NULL,".$id.",".$temp[0].")");
				
					$tahu  = DAO::queryRowSql("SELECT parent_id FROM tdpmenu WHERE menu_id = ".$temp[0]);
					if($tahu['parent_id'] != $tempe)
					{
						$sccss = DAO::executeSql("INSERT INTO tdpusergroupmenu VALUES (NULL,".$id.",".$tahu['parent_id'].")");
						$tempe = $tahu['parent_id'];
					}
				}
				
				$sccss = DAO::executeSql("INSERT INTO tdpusergroupakses VALUES(NULL,".$id.",".$temp[1].")");
				$flag  = $temp[0]; 
			}
			Yii::app()->user->setFlash('success', "Update Successfully");
		}
		
		
		$model 	 = $this->loadModel($id);
		$group_id = $id;
		$criteria = new CDbCriteria();
		$criteria->condition = 'parent_id = 0';
		$criteria->order 	 = 't.menu_order ASC';
		$criteria->select 	= array('menu_name','menu_id');
		
		$dtTreeViewRoot;
		$menuHeader  	  	= Menu::model()->findAll($criteria);
		$this->menuCounter  = 0;
		
		$i = 0;
		foreach($menuHeader as $mHeader)
			$dtTreeView[$i++] = $this->genMenu($mHeader,$group_id);
		
		// inserting webroot to structure
		$dtTreeView = array(array('text'=>'webroot','children'=>$dtTreeView));
		$this->render('menuconf',array(
			'model'=>$model,
			'dtTreeView'=>$dtTreeView,
		));
	}
	
	
	 

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Usergroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='usergroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
