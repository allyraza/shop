<div class="view product-view">

    <h3><?= CHtml::link(CHtml::encode($data->title), ['products/view', 'id' => $data->product_id]) ?></h3>
    
    <div class="media">	
    <?php
        if ($data->images)
            $this->renderPartial('/image/view', ['thumb' =>true, 'model' => $data->images[0]]);
        else
            echo CHtml::image(Shop::register('no-pic.jpg'));
    ?>
	</div>
    
    <div class="product-info">
        <strong><?= Shop::priceFormat($data->price) ?></strong><br />
        <p><?= Shop::pricingInfo() ?></p>
        <?= CHtml::link(Shop::t('Buy Now'), ['products/view', 'id' => $data->product_id]) ?>
    </div>

    <div class="description">
        <?= CHtml::encode($data->description) ?>
    </div>

</div>