<?php

class CartController extends BaseController {

	public function actionIndex()
	{
		$this->render('index', ['cart'=>$this->cart]);
	}

	public function actionTotal()
	{
		echo $this->cart->getCost();
	}

	public function actionUpdate()
	{
		if (isset($_POST['product']) && isset($_POST['qty']))
		{
			$pid = (int) $_POST['product']; 
			$qty = (int) $_POST['qty'];
			$product = Product::model()->findByPk($_POST['product']);
			
			if ($product)
				$this->cart->update($product, $_POST['qty']);

			if (isset($_POST['Variation']))
			{
				foreach ($_POST['Variation'] as $key => $variation)
					$spec = Attribute::model()->findByPk($key);
			}
			
			if (Yii::app()->request->isAjaxRequest)
			{
				$pos = $this->cart->itemAt($pid);
				echo $pos->getQuantity() * $pos->price;
				Yii::app()->end();
			}

			$this->flash('cart', 'cart has been updated.');
		}

		$this->redirect(['/shop/cart']);
	}

	public function actionDelete($id)
	{
		$this->cart->remove((int) $id);
		$this->redirect(['/shop/cart']);
	}

	public function actionClear()
	{
		$this->cart->clear();
		$this->redirect(['/shop/cart']);
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='cart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}