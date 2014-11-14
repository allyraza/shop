<?php

$this->breadcrumbs=[
	Shop::t('Shop')=>['/shop/products/'],
	Shop::t('Cart')
]
?>

<h2><?= Shop::t('Shopping cart') ?></h2>

<?php $this->renderPartial('/orders/waypoint', ['point' => 0]) ?>

<?php if (!empty($products)): ?>
	<table cellpadding="0" cellspacing="0" class="shopping_cart">
	<tr>
		<th><?= Shop::t('Image') ?></th>
		<th><?= Shop::t('Amount') ?></th>
		<th><?= Shop::t('Product') ?></th>
		<th><?= Shop::t('Variation') ?></th>
		<th style="width: 60px;"><?= Shop::t('Price') ?></th>
		<th style="width: 60px;"><?= Shop::t('Sum') ?></th>
		<th><?= Shop::t('Actions') ?></th>
	</tr>
	<?php foreach ($products as $position => $product): ?>
		<?php if (isset($product['Variations']) && $model = Products::model()->findByPk($product['product_id']) ): ?>
			<?php
				$variations = '';
				foreach ($product['Variations'] as $specification => $variation)
				{
					$specification = ProductSpecification::model()->findByPk($specification);
					if ($specification->is_user_input)
						$variation = $variation[0];
					else
						$variation = ProductVariation::model()->findByPk($variation);
					$variations .= $specification . ': ' . $variation . '<br />';
				}
			?>
	<tr>
		<td><?= $model->getImage(0, true) ?></td>
		<td><?= CHtml::textField('amount_'.$position, $product['amount'], ['size'=>4, 'class'=>'amount_'.$position]) ?></td>
		<td><?= $model->title ?></td>
		<td><?= $variations ?></td>
		<td class="text-right"><?= $model->getPrice($product['Variations']) ?></td>
		<td class="text-right price_'<?= $position ?>"><?= $model->getPrice($product['Variations'], $product['amount']) ?></td>
		<td><?= CHtml::link(Shop::t('Remove'), ['/shop/cart/delete', 'id' => $position], ['confirm' => Shop::t('Are you sure?')]) ?></td>
	</tr>
	<?php endif ?>
	<?php endforeach ?>
<?php 
Yii::app()->clientScript->registerScript('amount_'.$position,
	"$('.amount_".$position."').keyup(function() {
		$.ajax({
			url: '".$this->createUrl('/shop/cart/updateAmount')."',
			data: $('#amount_".$position."'),
			success: function(res) {
				$('.amount_".$position."').css('background-color', 'lightgreen');
				$('.widget_amount_".$position."').css('background-color', 'lightgreen');
				$('.widget_amount_".$position."').html($('.amount_".$position."').val());
				$('.price_".$position."').html(res);	
				$('.price-total').load('".$this->createUrl('/shop/cart/getPriceTotal')."');
			},
			error: function() {
				$('#amount_".$position."').css('background-color', 'red');
			}
		});
	});"
) ?>
		<?php if ($shippingMethod = Shop::getShippingMethod()): ?>
		<tr>
			<td></td>
			<td>1</td>
			<td><?= Shop::t('Shipping costs') ?></td>
			<td></td>
			<td class="text-right"><?= $shippingMethod->formatedPrice ?></td>
			<td class="text-right"><?= $shippingMethod->formatedPrice ?></td>
			<td><?= CHtml::link(Shop::t('edit'), ['/shop/shippingMethod/choose']) ?></td>
		</tr>
		<?php endif ?>
		<tr>
			<td class="text-right no-border" colspan="6">
				<p class="price-total"><?= Shop::getPriceTotal() ?></p>
			</td>
			<td class="no-border"></td>
		</tr>
	</table>

	<?php if (Yii::app()->controller->id != 'order'): ?>
	<div class="buttons">
		<?= CHtml::link('Continue Shopping', ['/shop/products']) ?>
		<?= CHtml::link('Checkout', ['/shop/order/create']) ?>
	</div>
	<?php endif ?>

<?php else: ?>
	<?= Shop::t('Your shopping cart is empty') ?>
<?php endif ?>

