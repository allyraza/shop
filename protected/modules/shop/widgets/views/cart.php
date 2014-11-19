<header>
	<?= CHtml::link('Cart', ['/shop/cart']) ?>
</header>

<div id="dropdown">
	<table id="items" cellpadding="0" cellspacing="0">
	<?php if (!$cart->isEmpty()): ?>

		<?php foreach ($cart as $p): ?>
		<tr>
			<td class="cart-left widget-amount-<?= $p->id ?>"><?= $p->quantity ?></td>
			<td class="cart-middle"><?= $p->title ?></td>
			<td class="cart-right price-<?= $p->id ?>"><?= price($p->price) ?></td>
		</tr>
		<?php endforeach ?>

		<?php if (isset($cart->shippingMethod)): ?>
		<tr>
			<td class="cart-left">1</td>
			<td class="cart-middle">Shipping Cost</td>
			<td class="cart-right"><?= $cart->shippingMethod->formatedPrice ?></td>
		</tr>
		<?php endif ?>

		<tr>
			<td colspan="3" class="cart-right cart-total">
				<strong><?= $cart->cost ?></strong>
			</td>
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