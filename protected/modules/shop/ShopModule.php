<?php

Yii::setPathOfAlias('shop', __DIR__);

require(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'helpers.php');

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
	public $categoriesTable = 'categories';
	public $productsTable = 'products';
	public $ordersTable = 'orders';
	public $orderProductsTable = 'order_products';
	public $customersTable = 'customers';
	public $addressesTable = 'addreses';
	public $imagesTable = 'images';
	public $shippingMethodsTable = 'shipping_methods';
	public $paymentMethodsTable = 'payment_methods';
	public $taxesTable = 'taxes';
	public $attributesTable = 'attributes';
	public $variationsTable = 'variations';
	public $currencySymbol = '$';

	public $logoPath = 'logo.jpg';
	public $slipView = '/orders/slip';
	public $invoiceView = '/orders/invoice';
	public $footerView = '/orders/footer';

	public $dateFormat = 'd/m/Y';
	public $publishAssets = false;
	
	public $thumbWidth = 100;
	public $imageWidth = 200;

	public $adminEmail = null;

	public $termsView = '/order/terms';
	public $orderComplete = ['/shop/orders/success'];
	public $orderFail = ['/shop/orders/failure'];
	public $loginUrl = ['/site/login'];

	// where the uploaded product images are stored its relative to webroot
	public $uploads = 'uploads'; 

	public $layout = 'shop.views.layouts.main';

	public function init()
	{
		$this->setImport([
			'shop.models.*',
			'shop.components.*',
			'shop.components.cart.*',
		]);
		$this->setComponents([
			'cart' => [
				'class' => 'shop.components.cart.EShoppingCart'
			]
		]);
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