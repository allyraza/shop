<?php

Yii::import('zii.widgets.CPortlet');

class CartWidget extends CPortlet {
	
	public function	run()
	{
		$this->render('cart', [
			'cart'=>Yii::app()->getModule('shop')->cart
		]);
	}

}