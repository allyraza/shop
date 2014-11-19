<h1><?= Yii::t('ShopModule.shop', 'Yii Webshop Installation') ?></h1>

<?php $module = Yii::app()->getModule('shop') ?>
<?= CHtml::beginForm(array('index')) ?>

<div class="span-12">

	<h2> Information: </h2>
	<hr />

	<p> You are about to install the Yii Webshop Module in your Web 
	Application. You require a working Database connection like sqlite, mysql, 
	pgsql or other. Please make sure your Database is Accessible
	in protected/config/main.php. </p>

	<p> This Installer will create the needed database Tables in your Database and
	some Demo Data. If you want so see, what will happen exactly, look at the 
	install.sql file in the Module Root </p>

	<?php if (Yii::app()->db): ?>
	<div class="hint"> Your Database Connection seems to be working </div>
	<?php else: ?>
	<div class="error"> Your Database Connection doesn't seem to be working </div>
	<?php endif; ?>

	<p> After the Installation, you can configure the views of your shop unter
	modules/YiiShop/views. Note that YiiShop does not contain any css files and
	almost no predefined layout, so that you can easily integrate this shop in
	your already existing Web Application. </p>

	<p> The API Documentation, examples and an Database Schema for Mysql Workbench
	can be found in the docs/ directory of the Module. </p>

	<p> You most probably want to use the Webshop combined with a Role based
	Access Manager like Srbac. You find example tutorials on how to do this in
	the docs/ directory, too. </p>

	<p> To set the language of your Webshop, set the 'language' config param of
	your Yii Web Application </p>

	</div>

	<div class="span-11 last">

	<h2>Configuration:</h2>
	<hr />

	<p>Installer will generate the following Table names: </p>

	<table>
		<tr> 
			<td>Table for Product Categories</td>
			<td><?= CHtml::textField('categoryTable', $module->categoriesTable) ?></td>
		</tr>
		<tr>
			<td>Table for Products</td>
			<td><?= CHtml::textField('productsTable', $module->productsTable); ?></td>
		</tr>
		<tr>
			<td>Table for Specifications</td>
			<td><?= CHtml::textField('productSpecificationsTable', $module->attributesTable); ?></td>
		</tr> 
		<tr>
			<td>Table for Product Variations</td>
			<td><?= CHtml::textField('productVariationTable', $module->variationsTable) ?></td>
		</tr>
		<tr>
			<td>Table for the Orderings</td>
			<td><?= CHtml::textField('orderTable', $module->ordersTable) ?></td>
		</tr>
		<tr>
			<td>Table for the Order Positions</td>
			<td><?= CHtml::textField('orderPositionTable', $module->orderProductsTable) ?></td>
		</tr>
		<tr>
			<td>Table for the Customers</td>
			<td><?= CHtml::textField('customerTable', $module->customersTable); ?></td>
		</tr>
		<tr>
			<td>Table for Addresses</td>
			<td><?= CHtml::textField('addressTable', $module->addressesTable) ?></td>
		</tr>
		<tr>
			<td>Table for the Product Images</td>
			<td><?= CHtml::textField('imageTable', $module->imagesTable); ?></td> </tr>
		<tr>
			<td>Table for the Shipping Methods</td>
			<td><?= CHtml::textField('shippingMethodTable', $module->shippingMethodsTable); ?></td> 
		</tr>
		<tr> 
			<td>Table for the Payment Methods</td>
			<td><?= CHtml::textField('paymentMethodTable', $module->paymentMethodsTable); ?></td> 
		</tr>
		<tr> 
			<td>Table for Taxes</td>
			<td><?= CHtml::textField('taxTable', $module->taxesTable); ?></td> 
		</tr>
	</table>

	<p> Your Product images will be stored under /www/<?= $module->uploads; ?> </p>
</div>

<?= CHtml::submitButton('Install'); ?>
<?= CHtml::endForm(); ?>