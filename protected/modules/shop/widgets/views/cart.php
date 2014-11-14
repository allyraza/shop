<header>
	<?= CHtml::link(Shop::t('Cart'), ['/shop/cart']) ?>
</header>

<div id="dropdown">
	<table id="items" cellpadding="0" cellspacing="0">
	<?php if (!empty($products)): ?>

		<?php foreach ($products as $num => $position): ?>
		<?php $model = Product::model()->findByPk($position['product_id']) ?>
		<tr>
			<td class="cart-left widget_amount_<?= $num ?>"><?= $position['amount'] ?></td>
			<td class="cart-middle"><?= $model->title ?></td>
			<td class="cart-right price_<?= $num ?>"><?= Yii::app()->numberFormatter->formatCurrency($position['amount'] * $model->getPrice(@$position['Variations']), '$') ?></td>
		</tr>
		<?php endforeach ?>

		<?php if ($shippingMethod = Shop::getShippingMethod()): ?>
		<tr>
			<td class="cart-left">1</td>
			<td class="cart-middle"><?= Shop::t('Shipping costs') ?></td>
			<td class="cart-right"><?= $shippingMethod->formatedPrice ?></td>
		</tr>
		<?php endif ?>

		<tr>
			<td colspan="3" class="cart-right cart-total"><strong><?= Shop::getPriceTotal() ?></strong></td>
		</tr>

		<?php else: ?>
		<tr>
			<td colspan="3">
				<p>Your cart is empty.</p>
			</td>
		</tr>
		<?php endif ?>
	</table>
	<!-- /items -->

	<footer>
		<?= CHtml::link("Continue Shopping", ["/shop/products"], ['class' => 'continue-shopping']) ?>
		<?= CHtml::link("Checkout", ["/shop/cart"], ['class' => 'checkout']) ?>
	</footer>
</div>