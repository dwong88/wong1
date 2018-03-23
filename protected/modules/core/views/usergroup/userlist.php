<?php $this->breadcrumbs=array(
		'Usergroup'=>array('index'),
	);
?>
<h1>Add usergroup: <?php  echo $model->usergroup_name; ?> </h1>
<?php

	Yii::app()->clientScript->registerScript('userlist','
	
		$("#next").click(function(){
	        $("#unregis-userlist option:selected").appendTo("#regis-userlist");
	    });
	    $("#moveall").click(function(){
	        $("#unregis-userlist option").appendTo("#regis-userlist");
	    });
		
	    $("#clear_all").click(function(){
	        $("#regis-userlist").html("");
	    });
		
		$("#btnSaveChanges").click(function(e){
			e.preventDefault();
			$("#regis-userlist option").attr("selected", "selected");
			$("#regform").submit();
			
		});
		
	    $("#remove_registered").click(function(){
	        $("#regis-userlist option:selected").remove();
	    });
	
	
		$("#usersearch").submit(function(){	
	        $action = $(this).attr("action");
	        $self = $(this);
	        $data = $self.serialize();
	        $self.find("input").attr("disabled" , "disabled");
	        $.ajax({
	            url     : $action,
	            type    : "post",
	            data    : $data,
	            dataType: "json",
	            success : function(json)
	            {
	                $("#unregis-userlist").html("");
	                for(var i in json.users)
	                {
	                	if($("#regis-userlist option[value="+json.users[i].user_id+"]").length > 0) continue;
	                    	$("#unregis-userlist").append("<option value="+json.users[i].user_id+">"+json.users[i].user_name+"</option>");
	                }
	            },
	            error : function()
	            {
	                alert("Failed to fetch data from server");
	            },
	            complete: function()
	            {
	                $self.find("input").removeAttr("disabled");
	            }
	        });
	        return false;
	    });	
	');
?>
<div>
	
    <div style="width:50%;float:left;">
        <div>Un-registered User List</div>
         <?php
            	$unregistered_user = User::model()->with('usergroupdetail')->findAll(
									array('condition'=>'usergroup_id != :usergroup_id OR usergroup_id IS NULL',
											'params'=>array(':usergroup_id'=>$model->usergroup_id)));
				$unregistered_user = CHtml::listData($unregistered_user,'user_id', 'user_name');
         ?>
        <?php echo CHtml::dropDownList('User', '', $unregistered_user , array("style" => 'width: 90%' , 'size'=>'10', 'multiple'=>'multiple' , 'id'=>'unregis-userlist'));?>
        <div align="right" style="padding-right: 10%;">
            <form id="usersearch" style="display: inline;" action="index.php?r=core/usergroup/ajxsearchuser" method="post">
                <?php echo CHtml::textField('search'); ?>
                <?php echo CHtml::submitButton('Search',array('id' => 'usersearch')); ?>
            </form>
            <?php echo CHtml::button('>', array("id" => "next")); ?>
            <?php echo CHtml::button('>>' , array('id' => 'moveall'));?>
        </div>
    </div>
    <div style="width:50%;float:left;">
        <div>Registered User List</div>
        <form action="index.php?r=core/usergroup/userlist" method="post" id="regform">
            <?php echo CHtml::hiddenField("id", $model->usergroup_id); ?>
            <?php
            	$registered_user = Usergroupdetail::model()->with('users')->findAll(array('condition'=>'usergroup_id=:usergroup_id','params'=>array(':usergroup_id'=>$model->usergroup_id)));
				$registered_user = CHtml::listData($registered_user,'users.user_id', 'users.user_name');
				echo CHtml::dropDownList('registereduser[]', '',$registered_user, array("style" => 'width: 90%' , 'size'=>'10' , 'multiple'=>'multiple', 'id'=>'regis-userlist')); 
            ?>
            <div align="left">
                <?php echo CHtml::button('Remove Selected', array("id" => 'remove_registered')); ?>
                <?php echo CHtml::button('Clear All', array("id" => "clear_all")); ?>
                <?php echo CHtml::submitButton('Save Changes',array('id'=>'btnSaveChanges')); ?>
            </div>
        </form>
    </div>
    <div style="clear: both;"></div>
</div>
<hr/>