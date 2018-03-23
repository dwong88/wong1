<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * show all query executed with CActiveRecord.
	 * @var boolean set it to true, will show all query executed with CActiveRecord.
	 */
	public static $showSql = false;
	
	/**
	 *
	 * This variable is used for popup window title.
	 * @var String $_popuptitle the title for popup window
	 */
	public $_popuptitle = '';
	
	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	// AH: will return array needed for acces control
	public function accessRules()
	{
		// AH: Uncomment this code below to gave full access to anyone login
		// BEGIN FULL ACCESS
// 		$rules = array(
// 			array('allow', 'users' => array('@')),
// 		);
// 		return $rules;
		
		// END FULL ACCESS
		
		$rules = array(
			array('deny', 'users' => array('*')),
		);

		if(!Yii::app()->user->isGuest) {
			$arrUsergroupId  = Yii::app()->user->usergroup_id;
			$sUserGroupId 	 = implode(',', $arrUsergroupId);
			
			$sModule 		 = '';
			if(isset($this->module))
				$sModule	 = $this->module->getName();
			
			$sReqAction 	 = $sModule.'/'.Yii::app()->controller->id.'/'.$this->action->id;
			$sQuery			 = "SELECT COUNT(action_url) AS acc 
								FROM tdpusergroupakses a JOIN tdpmenuaction b
								 WHERE a.menuaction_id = b.menuaction_id 
								 AND action_url  = '$sReqAction'
								 AND usergroup_id IN ( $sUserGroupId )";
								
			
			$result = DAO::queryRowSql($sQuery);
			if($result['acc'] != 0 ) {
				$rules = array(
					array('allow', 'users' => array('@')),
					array('deny', 'users' => array('*')),
				);
			}
		}
		
		return $rules;
	}
}
