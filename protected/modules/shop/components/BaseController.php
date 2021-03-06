<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController {

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='/layouts/column1';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=[];

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=[];

	public function getCart()
	{
		return Yii::app()->getModule('shop')->cart;
	}

	public function getUser()
	{
		return Yii::app()->user;
	}

	public function flash($name, $message=null)
	{
		if ($message===null) {
			return Yii::app()->user->getFlash($name);
		}
		return Yii::app()->user->setFlash($name, $message);
	}

}