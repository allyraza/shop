<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="language" content="en">
	<title><?= CHtml::encode($this->pageTitle) ?></title>

	<!-- meta -->
	<meta name="keywords" content="">
	<meta name="description" content="">

	<!-- styles -->
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/assets/css/kube.min.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/assets/css/site.css">
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/assets/css/form.css">
	
	<!-- icons -->

</head>
<body id="page">

<div class="container">

	<header id="site-header" class="units-row">
		<div id="identity" class="unit-30">
			<h1><?= CHtml::encode(Yii::app()->name) ?></h1>
		</div>
		<!-- /logo -->
		<div class="unit-40 unit-push-30" id="shopping-cart">
			<?php $this->widget('shop.widgets.CartWidget') ?>
		</div>
		<!-- /cart -->
	</header>
	<!-- /site-header -->

	<div class="navbar navbar-gray">
	<?php
		$items = [
			['label'=>'Home', 'url'=>['/site/index']],
			['label'=>'All', 'url'=>['/shop/products']],
		];
		foreach (Category::model()->findAll() as $category)
			$items[] = ['label' => $category->title,'url' => ['/shop/categories/view', 'category'=>$category->title, 'id'=>$category->id]];
		$items[] = ['label'=>'Admin', 'url'=>['/shop/shop/admin']];
		$this->widget('zii.widgets.CMenu', ['items'=>$items])
	?>
	</div><!-- /mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', ['links'=>$this->breadcrumbs]) ?>
	<!-- /breadcrumbs -->

	<?= $content ?>

	<footer id="site-footer">
		Copyright &copy; <?= date('Y') ?> by My Company. All Rights Reserved.
	</footer><!-- footer -->

</div>
<!-- /container -->

</body>
</html>