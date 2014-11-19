<?php
$this->breadcrumbs=[
	'Products'=>['index'],
	$model->title,
];
?>

<div class="product-images">
<?php 
	if ($model->images):
		foreach ($model->images as $image)
			$this->renderPartial('/images/view', ['model' => $image]);
	else:
		$this->renderPartial('/images/view', ['model' => new Image]);
	endif
?>
</div>

<header>
    <h2><?= $model->title ?></h2>
    <strong><?= $model->formatedPrice ?></strong>
</header>

<div class="product-options"> 
	<?php $this->renderPartial('/products/_add_to_cart', ['model' => $model]); ?>
</div>

<div class="product-description">
	<?= $model->description ?>
</div>

<?php if ($model->specifications): ?>
<table>
	<tr><td colspan="2"><strong>Specification</strong></td></tr>
<?php
	foreach ($model->specifications as $key => $spec)
	{
		if (!empty($spec))
			printf('<tr><td>%s:</td><td>%s</td></td>', $key, $spec);
	}
?>
</table>
<?php endif ?>

<div id="support">
	All prices are including VAT
	All prices excluding shipping costs
	<?php $this->renderPartial('/shippingMethods/index') ?>
</div>