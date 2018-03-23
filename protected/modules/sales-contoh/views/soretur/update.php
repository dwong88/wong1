<?php
	
	yii::app()->clientScript->registerScript('soreturdetail-form',"
		$('#uptDetail').click(function(e){
				
			e.preventDefault();
			var dataheader  = $('#soretur-form').serialize();
			var datadetail  = $('#soreturdetail-form').serialize();
			var data 		= dataheader+'&'+datadetail;	 
			
			$.ajax({
				type	 : 'POST',
				url 	 : $('#soreturdetail-form').attr('action'),
				data	 : data,
				dataType : 'html',
				success  : function(data)
				{
			
					var jsondata = jQuery.parseJSON(data);
					if(jsondata.success){
						$('#soretur-form').submit();
					}else if(jsondata.errordetail){
						var errordetail = jsondata.errordetail; 
						$('.error-detail').html('');
						for(var i=0;i<errordetail.length;i++)
						{
							var err_index = errordetail[i].err_index;
							var err_desc  = errordetail[i].err_desc;
							$('.error-detail').get(err_index).innerHTML = err_desc;	
						}
						
						$('.errorSummary').hide();
						$('#soreturdetail-form .error').removeClass('error');
					}
				}
			});
		});
	");
	

	$this->breadcrumbs = array(
		'Soretur'=>array('index'),
		$modelHeader->soretur_cd=>array('view','id'=>$modelHeader->soretur_cd),
		'Update',
	);
	
	$buttonBar = new ButtonBar('{list} {create} {view}');
	$buttonBar->listUrl = array('index');
	$buttonBar->createUrl = array('create');
	$buttonBar->viewUrl = array('view', 'id'=>$modelHeader->soretur_cd);
	$buttonBar->render();
?>

<?php echo $this->renderPartial('_form', array('model'=>$modelHeader)); ?>
<?php echo $this->renderPartial('_grid_detail', array('model'=>$modelDetail,'soretur_cd'=>$modelHeader->soretur_cd,'modelHeader'=>$modelHeader)); ?>