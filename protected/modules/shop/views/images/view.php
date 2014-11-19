<?php 
$folder = Yii::app()->getModule('shop')->uploads;

if($model->filename) 
	$path = Yii::app()->baseUrl. '/' . $folder . '/' . $model->filename;
	else
	$path = $this->module->publishAssets().'img/no-pic.jpg';

	echo CHtml::image(
		$path,
		$model->title,
		[
			'title' => $model->title,
			'style' => 'margin: 10px;',
			'width' => isset($thumb) ? Yii::app()->getModule('shop')->thumbWidth : Yii::app()->getModule('shop')->imageWidth
		]
	);
?>
<?php if (Yii::app()->getModule('shop')->userModule && Yii::app()->user->isAdmin()): ?>
	<?= CHtml::link(Yii::t('ShopModule.shop', 'Delete Image'), ['delete', 'id'=>$model->id]) ?>
<?php endif ?>
