<?php
$this->breadcrumbs=array(
	'Products',
);
?>

<h2>Products</h2>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
