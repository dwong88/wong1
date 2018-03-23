<?php
class ButtonBar {
	/**
	* @var string the template that is used to render the content in each data cell.
	* These default tokens are recognized: {search}, {list}, {view}, {create}, {update}, {delete} and {print}. If the {@link buttons} property
	* defines additional buttons, their IDs are also recognized here. For example, if a button named 'preview'
	* is declared in {@link buttons}, we can use the token '{preview}' here to specify where to display the button.
	*/
	public $template = "{list}";
	
	/**
	* @var array the HTML options for the link Search (A) tag.
	*/
	public $searchLinkHtmlOptions=array();
	
	/**
	* @var string URL for search button
	*/
	public $searchUrl;
	
	/**
	* @var array the HTML options for the link List (A) tag.
	*/
	public $listLinkHtmlOptions=array();
	
	/**
	* @var string URL for list button
	*/
	public $listUrl;
	
	/**
	* @var array the HTML options for the link View (A) tag.
	*/
	public $viewLinkHtmlOptions=array();
	
	/**
	* @var string URL for view button
	*/
	public $viewUrl;
	
	/**
	* @var array the HTML options for the link Create (A) tag.
	*/
	public $createLinkHtmlOptions=array();
	
	/**
	* @var string URL for create button
	*/
	public $createUrl;
	
	/**
	* @var array the HTML options for the link Update (A) tag.
	*/
	public $updateLinkHtmlOptions=array();
	
	/**
	* @var string URL for update button
	*/
	public $updateUrl;
	
	/**
	* @var array the HTML options for the link Delete (A) tag.
	*/
	public $deleteLinkHtmlOptions=array();
	
	/**
	* @var string URL for delete button
	*/
	public $deleteUrl;
	
	/**
	* @var array the HTML options for the link Print (A) tag.
	*/
	public $printUrl;
	public $printLinkHtmlOptions=array();
	
	/**
	 * @var string URL for delete button
	 */
	public $previewUrl;
	public $previewLinkHtmlOptions=array();
	
	public $sendnotificationUrl;
	public $sendnotificationLinkHtmlOptions=array();
	
	public $excelUrl;
	public $excelLinkHtmlOptions=array();
	
	public $pdfUrl;
	public $pdfLinkHtmlOptions=array();
	
	public $printSoInvoiceUrl;
	public $printSoInvoiceLinkHtmlOptions=array();
	
	public $printFpUrl;
	public $printFpLinkHtmlOptions=array();
	
	/**
	* @var array the configuration for additional buttons. Each array element specifies a single button
	* which has the following format:
	* <pre>
	* 'buttonID' => array(
	*     'label'=>'...',     // text label of the button
	*     'url'=>'...',       // a string URL
	*     'options'=>array(...), // HTML options for the button tag
	* )
	* </pre>
	*
	* Note that in order to display these additional buttons, the {@link template} property needs to
	* be configured so that the corresponding button IDs appear as tokens in the template.
	*/
	public $buttons=array();
	
	public function __construct($template = '{list}')
	{
		$this->template = $template;
	}
	
	/**
	 * 
	 * Render the button bar.
	 */
	public function render()
	{
		$this->initDefaultButtons();
		
		foreach($this->buttons as $id=>$button)
		{
			if(strpos($this->template,'{'.$id.'}')===false)
			unset($this->buttons[$id]);
		}
		
		echo '<div class="button-bar">';
		echo $this->renderData();
		echo '<div class="clear"></div></div>';
	}
	
	protected function initDefaultButtons() {
		$searchLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/search.png').' Search';
		$sendnotificationLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/notif.png').' Send Notification';
		$listLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/list.png').' List';
		$viewLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/view.png').' View';
		$createLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/create.png').' Create';
		$updateLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/update.png').' Update';
		$deleteLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/delete.png').' Delete';
		$printLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/print.png').' Print';
		$excelLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/excel.png').' Excel';
		$pdfLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/pdf.png').' PDF';
		$previewLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/view.png').' Preview';
		$printSoInvoiceLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/print.png').' Print So Invoice';
		$printFpLabel = CHtml::image(Yii::app()->theme->baseUrl.'/images/print.png').' Print Faktur Pajak';
		
		foreach(array('search','list','view','create','update','delete','print','preview','excel','pdf', 'printSoInvoice', 'printFp', 'sendnotification') as $id)
		{
			$button=array(
				'label'=>${$id.'Label'},
				'url'=>$this->{$id.'Url'},
				'options'=>$this->{$id.'LinkHtmlOptions'},
			);
			if(isset($this->buttons[$id]))
				$this->buttons[$id]=array_merge($button,$this->buttons[$id]);
			else
				$this->buttons[$id]=$button;
		}
	}
	
	/**
	* Renders the data cell content.
	* This method renders the search, list, view, create, update and delete buttons in the data cell.
	*/
	protected function renderData()
	{
		$tr=array();
		foreach($this->buttons as $id=>$button)
		{
			$tr['{'.$id.'}']=$this->renderButton($id,$button);
		}
		
		echo strtr($this->template,$tr);
	}
	
	/**
	 * Renders a link button.
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url' and 'options' elements.
	 * See {@link buttons} for more details.
	 */
	protected function renderButton($id,$button)
	{
		$label=isset($button['label']) ? $button['label'] : $id;
		$options=isset($button['options']) ? $button['options'] : array();
		$url=isset($button['url']) ? $button['url'] : '#';
		
		return CHtml::link(CHtml::tag('span',array(),$label,true),CHtml::normalizeUrl($url),$options);
	}
}