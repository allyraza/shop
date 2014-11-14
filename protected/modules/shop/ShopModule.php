<?php

Yii::setPathOfAlias('shop', __DIR__);

class ShopModule extends CWebModule {

	public $version = '0.1';

	// Is the Shop in debug Mode?
	public $debug = true;

	// Whether the installer should install some demo data
	public $demo = true;

	// Enable this to use the shop module together with the yii user
	// management module
	public $userModule = false;

	// Names of the tables
	public $categoryTable = 'shop_category';
	public $productsTable = 'shop_products';
	public $orderTable = 'shop_order';
	public $orderPositionTable = 'shop_order_position';
	public $customerTable = 'shop_customer';
	public $addressTable = 'shop_address';
	public $imageTable = 'shop_image';
	public $shippingMethodTable = 'shop_shipping_method';
	public $paymentMethodTable = 'shop_payment_method';
	public $taxTable = 'shop_tax';
	public $productSpecificationTable = 'shop_product_specification';
	public $productVariationTable = 'shop_product_variation';
	public $currencySymbol = '$';

	public $logoPath = 'logo.jpg';
	public $slipView = '/order/slip';
	public $invoiceView = '/order/invoice';
	public $footerView = '/order/footer';

	public $dateFormat = 'd/m/Y';
	public $publishAssets = false;
	
	public $imageWidthThumb = 100;
	public $imageWidth = 200;

	public $notifyAdminEmail = null;

	public $termsView = '/order/terms';
	public $orderComplete = ['/shop/order/success'];
	public $orderFail = ['//shop/order/failure'];
	public $loginUrl = ['/site/login'];

	// where the uploaded product images are stored its relative to webroot
	public $uploads = 'uploads'; 

	public $layout = 'shop.views.layouts.main';

	public function init()
	{
		$this->setImport(array(
			'shop.models.*',
			'shop.components.*',
		));
	}

	public function publishAssets()
	{
		$assets = Yii::getPathOfAlias('application.modules.shop.assets');
		$url = Yii::app()->getAssetManager()->publish($assets);

		if ($this->publishAssets)
		{
			Yii::app()->clientScript
				->registerScriptFile($url.'/js/kube.min.js')
				->registerScriptFile($url.'/js/site.js')
				->registerCssFile($url.'/css/kube.min.css')
				->registerCssFile($url.'/css/site.css')
				->registerCssFile($url.'/css/form.css');
		}

		return $url . '/';
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
			return true;
		else
			return false;
	}

}