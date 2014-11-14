<?php
$points=[
	Shop::t('Customer information'),
	Shop::t('Shipping'),
	Shop::t('Payment'),
	Shop::t('Confirm'),
	Shop::t('Success')
];

$links = [
	['/shop/customer/create'],
	['/shop/shippingMethod/choose'],
	['/shop/paymentMethod/choose'],
	['/shop/order/create']
];
$cssClass = $point == 0 ? 'active' : '';
?>

<div id="waypointarea" class="waypointarea">

	<span class="waypoint <?= $cssClass ?>">
		<?= CHtml::link(Shop::t('Shopping Cart'), ['//shop/cart/view']) ?>
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