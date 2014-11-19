<?php
$this->breadcrumbs=[
	Yii::t('ShopModule.shop', 'Shop')=>array('shop/index'),
	Yii::t('ShopModule.shop', 'Categories')=>array('index'),
	$model->title,
];
?>

<h2><?= $model->title ?></h2>
<?php
foreach ($model->products as $product) {
	$this->renderPartial('/products/_view', array('data' => $product));
}
?>