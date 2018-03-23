<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveRecord
 * Develop by Karltigo Development Team.
 * For customize CActiveRecord
 *
 */
class ActiveRecord extends CActiveRecord
{
    /**
     * turn this on at inherited class for log user when accessing this record.
     * @var boolean a flag for log create_by,create_dt,update_by,update_dt of 1 single record.
     */
    protected $logRecord=false;
    
    /**
     *
     * @var boolean a flag for log on table tloghistory. but the field create_by,create_dt,update_by,update_dt will not to be recorded.
     */
    protected $logTableHistory=false;
    protected $mLogHistory;
    
    public function __construct($scenario = 'insert')
	{
        parent::__construct($scenario);
        $this->attachEventHandler('onBeforeSave', '');
        $this->attachEventHandler('onAfterSave', '');
    }

    /**
     * By provide '$this->attachEventHandler('onBeforeSave', '');' at inherited class model,
     * this function will run before the record save to database.
     * By setting {@link CModelEvent::isValid} to be false, the normal {@link save()} process will be stopped.
     * @param CModelEvent $event the event parameter.
     */
    public function onBeforeSave($event)
	{
        //Don't provide 'parent::onBeforeSave($event);' at this function.
        //Because it will call this function multiple times.
        if($this->logRecord)
        {
            if($this->getIsNewRecord())
            {
                if($this->hasAttribute('create_dt') && $this->hasAttribute('create_by'))
                {
                    $this->setAttribute('create_dt', Yii::app()->datetime->getDateTimeNow());
                    $this->setAttribute('create_by', Yii::app()->user->id);
                }
                if($this->hasAttribute('update_dt') && $this->hasAttribute('update_by'))
                { 
                    $this->setAttribute('update_dt', Yii::app()->datetime->getDateTimeNow());
                    $this->setAttribute('update_by', Yii::app()->user->id);
                }
            }
            else
            {
                if($this->hasAttribute('update_dt') && $this->hasAttribute('update_by') && !empty(Yii::app()->user->id))
                {
                    $this->setAttribute('update_dt', Yii::app()->datetime->getDateTimeNow());
                    $this->setAttribute('update_by', Yii::app()->user->id);
                }
            }
        }
        
        if($this->logTableHistory && !$this->isNewRecord)
        {
        	$this->mLogHistory = new Loghistory();
        	$this->mLogHistory->setOriginalModel($this::model()->findByPk($this->oldPrimaryKey));
        }
    }
    
    /**
     * This event is raised after the record is saved.
     * @param CEvent $event the event parameter
     */
    public function onAfterSave($event)
    {
    	if($this->logTableHistory && get_class($this->mLogHistory)==='Loghistory' )
    		if($this->mLogHistory->isDifferences($this->attributes,array('create_by','create_dt','update_by','update_dt')))
    			$this->mLogHistory->saveDifferences();
    }
}
?>
