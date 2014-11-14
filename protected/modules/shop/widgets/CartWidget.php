<?php

Yii::import('zii.widgets.CPortlet');

class CartWidget extends CPortlet {
	
	public function	init()
	{
				if(!Shop::getCartContent())
			return false;
		return parent::init();
	}

	public function	run()
	{
		if (!Shop::getCartContent())
			return false;

		$this->render('cart', ['products' => Shop::getCartContent()]);
	}

}