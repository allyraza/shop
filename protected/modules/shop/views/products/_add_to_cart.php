<?= Shop::renderFlash() ?>

<?= CHtml::beginForm(['cart/create']) ?>
<?php foreach ($model->variations as $i => $variation): ?>
	<?php $field = sprintf("Variations[%s][]", $variation->specification_id) ?>
	<div id="product-variation-<?= $i ?>" class="product-variation">
	<?= CHtml::label($variation->specification->title, $field) ?>
	<?php
	if ($variation->specification->is_user_input)
		echo CHtml::textField($field);
	else
		echo CHtml::radioButtonList($field, $variation->specification->required ? $variation->id : null, ProductVariation::listData($variation));
	?>
	</div>
<?php endforeach ?>
<?= CHtml::hiddenField('product_id', $model->product_id) ?>
<?= CHtml::label(Shop::t('Amount'), 'Cart_amount') ?>:
<?= CHtml::textField('amount', 1, ['size'=>3]) ?>
<br/>
<?= CHtml::submitButton(Shop::t('Add to Cart'), ['class'=>'add-to-cart']) ?>
<?= CHtml::endForm() ?>