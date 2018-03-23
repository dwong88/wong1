<?php

class MenuBar
{
	public $sMenuBar = "";
	
	public function generateMenu()
	{
		$arrUsergroupId  = Yii::app()->user->usergroup_id;
		$sUserGroupId 	 = implode(',', $arrUsergroupId);


		$query 			= "SELECT DISTINCT menu_name,default_url,parent_id,b.menu_id 
							FROM tdpusergroupmenu a JOIN tdpmenu b
							ON a.menu_id = b.menu_id
							WHERE usergroup_id IN ($sUserGroupId) AND parent_id = 0
							ORDER BY menu_order ASC";
		$arrMenu 		= DAO::queryAllSql($query);
		
		for($i=0;$i<count($arrMenu);$i++)
			$this->generateMenuDetail($arrMenu[$i],$sUserGroupId);
		
		echo $this->sMenuBar;
	}
	
	public function generateMenuDetail($menu,$sUserGroupId)
	{
		$href	= '#';
		$disp	= '<span>'.$menu['menu_name'].'</span>';
		
		if(!empty($menu['default_url']))
		{
			$href = CHtml::normalizeUrl(array("/".$menu['default_url']));
			$disp = $menu['menu_name'];
		}
			
		// GENERATE THEMSELF
		if($menu['parent_id']  == 0)
			$this->sMenuBar .= "<li class='pureCssMenui0'>
									<a class='pureCssMenui0' href='$href'>$disp</a>";
		else
			$this->sMenuBar	.= 	"<li class='pureCssMenui'>
									<a class='pureCssMenui' href='$href'>$disp</a>";
		
		$query 			= "SELECT DISTINCT menu_name,default_url,parent_id,b.menu_id  
							FROM tdpusergroupmenu a JOIN tdpmenu b
							ON a.menu_id = b.menu_id
							WHERE usergroup_id IN ($sUserGroupId) AND parent_id = ".$menu['menu_id']."
							ORDER BY menu_order ASC";
		$arrMenuChild 	= DAO::queryAllSql($query);	

		if(count($arrMenuChild) > 0 )
		{
			$this->sMenuBar	.= "<ul class='pureCssMenum'>";
			
			// GENERATE MENU RECURSIVE 
			for($i=0;$i<count($arrMenuChild);$i++)
				$this->generateMenuDetail($arrMenuChild[$i],$sUserGroupId);
			
			$this->sMenuBar	.= "</ul>";
		}

		$this->sMenuBar .= "</li>";
	}
}