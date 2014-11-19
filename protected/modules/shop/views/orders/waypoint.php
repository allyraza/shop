<?php
$points=[
	'Customer information',
	'Shipping',
	'Payment',
	'Confirm',
	'Success'
];

$links = [
	['/shop/customers/create'],
	['/shop/shippingMethods/choose'],
	['/shop/paymentMethods/choose'],
	['/shop/orders/create']
];
$cssClass = $point == 0 ? 'active' : '';
?>

<div id="waypointarea" class="waypointarea">

	<span class="waypoint <?= $cssClass ?>">
		<?= CHtml::link('Shopping Cart', ['/shop/cart']) ?>
	</span>

<?php
foreach ($points as $p => $label) 
{
	printf('<span class="waypoint %s">%s</span>',
		$cssClass,
		$point < ++$p ? $label : CHtml::link($label, $links[$p-2])
	);
}
?>
</div>