<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="language" content="en">

	<!-- styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/kube.min.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/site.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body id="page">

<div class="container">

	<header id="site-header">
		<div id="logo">
			<?= CHtml::encode(Yii::app()->name) ?>
		</div>
		<div id="cart">
			<?php $this->widget('shop.widgets.ShoppingCartWidget') ?>	
		</div>
		<!-- /cart -->
	</header>
	<!-- /site-header -->

	<div class="navbar navbar-gray">
	<?php
		$items = [
			['label'=>'Home', 'url'=>['/site/index']],
			['label'=>'All', 'url'=>['/shop/products/index']],
		];
		foreach (Category::model()->findAll() as $category)
			$items[] = ['label' => $category->title,'url' => ['/shop/category/view', 'id' => $category->category_id]];
		$items[] = ['label'=>'Admin', 'url'=>['/shop/shop/admin']];
		$this->widget('zii.widgets.CMenu', ['items'=>$items])
	?>
	</div><!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', ['links'=>$this->breadcrumbs]) ?>
	<!-- breadcrumbs -->

	<?= $content ?>

	<footer id="site-footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</footer><!-- footer -->

</div>
<!-- /container -->

</body>
</html>