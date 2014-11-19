<?php
$this->breadcrumbs=[
	'Shop'=>['/shop/products/'],
	'Cart'
]
?>

<h2>Shopping cart</h2>

<?php $this->renderPartial('/orders/waypoint', ['point' => 0]) ?>

<?php if (!$cart->isEmpty()): ?>
	<table cellpadding="0" cellspacing="0" id="shopping-cart">
		<thead>
			<tr>
				<th>Image</th>
				<th>Product</th>
				<th>Variations</th>
				<th>Qty</th>
				<th style="width: 60px;">Price</th>
				<th style="width: 60px;">Sum</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($cart as $product): ?>
			<tr id="row-<?= $product->id ?>">
				<td><?= $product->getImage(0, true) ?></td>
				<td><?= $product->title ?></td>
				<td>
				<?php
				if (isset($product->variations))
				{
					foreach ($product->variations as $p)
						echo $p->title . ': ' . $p->title . '<br>';
				}
				?>
				</td>
				<td>
				<?= CHtml::textField('qty', $product->quantity, [
					'size'=>4, 
					'class'=>'qty', 
					'id'=>'qty-'.$product->id,
					'data-id'=>$product->id
				]) ?>
				</td>
				<td class="unit-price"><?= $product->price ?></td>
				<td class="price"><?= $product->quantity * $product->price ?></td>
				<td><?= CHtml::link('remove', ['/shop/cart/delete', 'id' => $product->id], ['confirm' => 'Are you sure?']) ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>

		<tfoot>
			<?php if (isset($cart->shippingMethod)): ?>
			<tr>
				<td></td>
				<td>1</td>
				<td>Shipping Cost</td>
				<td></td>
				<td><?= $shippingMethod->formatedPrice ?></td>
				<td><?= $shippingMethod->formatedPrice ?></td>
				<td><?= CHtml::link('edit', ['/shop/shippingMethod/choose']) ?></td>
			</tr>
			<?php endif ?>
			<tr>
				<td class="text-right no-border" colspan="6">
					<p class="price-total"><?= $cart->getCost() ?></p>
				</td>
				<td class="no-border"></td>
			</tr>
		</tfoot>
	</table>

	<?php if (Yii::app()->controller->id != 'order'): ?>
	<div class="buttons">
		<?= CHtml::link('Continue Shopping', ['/shop/products']) ?>
		<?= CHtml::link('Checkout', ['/shop/orders/create']) ?>
	</div>
	<?php endif ?>

<?php else: ?>
	<p>Your shopping cart is empty</p>
<?php endif ?>

<script type="text/javascript">
$(function() {
	$('table#shopping-cart').on('keyup', '.qty', function() {
		var $el = $(this);
		$.ajax({
			type: "post",
			url: '<?= $this->createUrl('/shop/cart/update') ?>',
			data: {product: $el.data('id'), qty: $el.val()},
			success: function(res) {
				$el.closest('tr').find('.price').html(res);
				$('.price-total').load('<?= $this->createUrl("/shop/cart/total") ?>');
			},
			error: function() {
				$('#amount-'+$el.data('id')).css('background-color', 'red');
			}
		});
	});
});
</script>