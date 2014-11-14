<div class="view product-view">

    <div class="media"> 
    <?php
        if ($data->images)
            $this->renderPartial('/images/view', ['thumb' =>true, 'model' => $data->images[0]]);
        else
            echo CHtml::image($this->module->publishAssets().'img/no-pic.jpg');
    ?>
    </div>

    <h3><?= CHtml::link(CHtml::encode($data->title), $data->url) ?></h3>
    
    <div class="product-info">
        <strong><?= $data->formatedPrice ?></strong>
        <br>
        <?= CHtml::link(Shop::t('Buy Now'), [
            '/shop/products/view', 
            'category'=> $data->category->title,
            'product'=> preg_replace('/[^a-zA-Z0-9]/', '-', $data->title),
            'id' => $data->product_id]
        ) ?>
    </div>
</div>