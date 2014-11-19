<?= CHtml::beginForm(['/shop/cart/update']) ?>
<?php foreach ($model->variations as $i => $variation): ?>
	<?php $field = sprintf("Variations[%s][]", $variation->specification_id) ?>
	<div id="product-variation-<?= $i ?>" class="product-variation">
	<?= CHtml::label($variation->specification->title, $field) ?>
	<?php
	if ($variation->specification->is_user_input)
		echo CHtml::textField($field);
	else
		echo CHtml::radioButtonList($field, $variation->specification->required ? $variation->id : null, Variation::listData($variation));
	?>
	</div>
<?php endforeach ?>
<?= CHtml::hiddenField('product', $model->id) ?>
<?= CHtml::label('Qty', 'qty') ?>:
<?= CHtml::textField('qty', 1, ['size'=>3]) ?>
<br/>
<?= CHtml::submitButton('Add to Cart', ['class'=>'add-to-cart']) ?>
<?= CHtml::endForm() ?>