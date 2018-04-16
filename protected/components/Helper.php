<?php
class Helper
{
	public static $listLanguage = array('en'=>'English', 'id'=>'Indonesia');
	public static $listDay = array('senin'=>'Senin', 'selasa'=>'Selasa', 'rabu'=>'Rabu', 'kamis'=>'Kamis', 'jumat'=>'Jumat', 'sabtu'=>'Sabtu', 'minggu'=>'Minggu');
	public static $listDays = array('1'=>'Senin', '2'=>'Selasa', '3'=>'Rabu', '4'=>'Kamis', '5'=>'Jumat', '6'=>'Sabtu', '7'=>'Minggu');
	public static function showFlash()
	{
		Yii::app()->clientScript->registerScript(
			    '_myHideEffectFlash',
			    '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
		CClientScript::POS_READY
		);

		foreach(Yii::app()->user->getFlashes() as $key => $message) :
			echo '<div class="flash-' . $key . ' info">' . $message . "</div>\n";
		endforeach;
	}

    public static function registerNumberField($selector)
    {
        Helper::registerJsKarlwei();
        Yii::app()->clientScript->registerScript(
            '__registerNumberField',
            "
					    $(document).on('focus','{$selector}', function() {
							this.value = Karlwei.helper.number.removeCommas(this.value);
						});
						$(document).on('blur','{$selector}', function() {
							this.value = Karlwei.helper.number.addCommas(this.value);
						});
					    $('{$selector}').each(function() {
							$(this).trigger('blur');
						});",
            CClientScript::POS_READY
        );
    }

	public static function registerJsKarlwei()
	{
		Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/karlwei.js');
	}
}
