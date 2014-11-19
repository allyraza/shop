<?php $methods = ShippingMethod::model()->findAll() ?>


<h2>Available Shipping Methods</h2>

<?php if (isset($methods)): ?>
	<table>
	<?php foreach ($methods as $method): ?>
		<tr><td><?= $method->description ?></td><td><?= $method->formatedPrice ?></td></tr>
	<?php endforeach ?>
	</table>
<?php endif ?>