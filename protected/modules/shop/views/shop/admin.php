<?php
$this->breadcrumbs=[
	Yii::t('ShopModule.shop', 'Shop')=>array('shop/index'),
	Yii::t('ShopModule.shop', 'Administration'),
];
?>

<div id="shopcontent">
	<h1>Administration</h1>

	<div class="span-8"> 
	<?php $this->beginWidget('zii.widgets.CPortlet', [
		'title' => Yii::t('ShopModule.shop', 'Administrate Categories')
	]) ?>
	<?php $this->renderPartial('/categories/admin'); ?>
	<?php $this->endWidget(); ?>
	</div>

	<div class="span-15 last"> 
	<?php $this->beginWidget('zii.widgets.CPortlet', [
		'title' => Yii::t('ShopModule.shop', 'Administrate your Products')
	]) ?>
	<?php $this->renderPartial('/products/admin') ?>
	<?php $this->endWidget() ?>
	</div>

	<div class="span-8 last"> 
	<?php $this->beginWidget('zii.widgets.CPortlet', [
		'title' => Yii::t('ShopModule.shop', 'Pending Orders')
	]) ?>
	<?php $this->renderPartial('/orders/admin') ?>
	<?php $this->endWidget() ?>
	</div>

</div>
<!-- /content -->