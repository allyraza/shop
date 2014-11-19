<?php
Yii::import('shop.components.cart.IECartPosition');

class Product extends CActiveRecord implements IECartPosition {

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->controller->module->productsTable;
	}

	public function getUrl()
	{
		return ['/shop/products/view', 
            'category' => $this->category->title,
            'product'=> preg_replace('/[^a-zA-Z0-9]/', '-', $this->title),
            'id' => $this->id];
	}

	public function beforeValidate()
	{
		if (Yii::app()->language == 'de')
			$this->price = str_replace(',', '.', $this->price);
		return parent::beforeValidate();
	}

	public function rules()
	{
		return [
			['title, category_id', 'required'],
			['id, category_id', 'numerical', 'integerOnly'=>true],
			['title, price, language', 'length', 'max'=>45],
			['description, specifications', 'safe'],
			['id, title, description, price, category_id', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'variations'=>[self::HAS_MANY, 'Variation', 'id', 'order'=>'position'],
			'orders'=>[self::MANY_MANY, 'Order', 'ShopProductOrder(order_id, id)'],
			'category'=>[self::BELONGS_TO, 'Category', 'category_id'],
			'tax'=>[self::BELONGS_TO, 'Tax', 'tax_id'],
			'images'=>[self::HAS_MANY, 'Image', 'id'],
			'carts'=>[self::HAS_MANY, 'ShoppingCart', 'id'],
		];
	}

	public function getSpecification($spec)
	{
		$specs = json_decode($this->specifications, true);
		if (isset($specs[$spec]))
			return $specs[$spec];
		return false;
	}

	public function getImage($image=0, $thumb=false)
	{
		if (isset($this->images[$image]))
			return Yii::app()->controller->renderPartial('/images/view', ['model' => $this->images[$image], 'thumb' => $thumb], true); 
	}

	public function getSpecifications()
	{
		$specs = json_decode($this->specifications, true);
		return $specs === null ? [] : $specs;
	}

	public function setSpecification($spec, $value)
	{
		$specs = json_decode($this->specifications, true);
		$specs[$spec] = $value;
		return $this->specifications = json_encode($specs);
	}

	public function setSpecifications($specs)
	{
		foreach ($specs as $k => $v)
			$this->setSpecification($k, $v);
	}

	public function setVariations($variations)
	{
		$db = Yii::app()->db;
		$db->createCommand()->delete('shop_product_variation', 'id = :id', [':id' => $this->id]);
		foreach ($variations as $key => $value)
		{
			if ($value['specification_id'] && !empty($value['title']))
			{

				if (isset($value['sign']) && $value['sign'] == '-')
					$value['price_adjustion'] -= 2 * $value['price_adjustion'];

				$db->createCommand()->insert('shop_product_variation', [
					'id' => $this->id,
					'specification_id' => $value['specification_id'],
					'position' => $value['position'] ?: 0,
					'title' => $value['title'],
					'price_adjustion' => $value['price_adjustion'] ?: 0,
				]);	
			}
		}
	}

	public function getVariations()
	{
		$variations = [];
		foreach ($this->variations as $variation)
			$variations[$variation->specification_id][] = $variation;
		return $variations;
	}

	public function attributeLabels()
	{
		return [
			'id' => Yii::t('ShopModule.shop', 'Product'),
			'title' => Yii::t('ShopModule.shop', 'Title'),
			'description' => Yii::t('ShopModule.shop', 'Description'),
			'price' => Yii::t('ShopModule.shop', 'Price'),
			'category_id' => Yii::t('ShopModule.shop', 'Category'),
		];
	}

	public function getTaxRate($variations = [], $amount = 1)
	{
		if (isset($this->tax))
		{
			$taxrate = $this->tax->percent;	
			$price = (float) $this->price;
			foreach ($variations as $key => $variation)
			{
				if ($variation = Variation::model()->findByPk($variation))
					$price += (int) $variation->price_adjustion;
			}

			return ($price * $amount) * ($taxrate / 100);
		}
	}

	public function getFormatedPrice()
	{
		return Yii::app()->numberFormatter->formatCurrency($this->price, '$');
	}

	public function getPrice()
	{
		$this->price;
	}

	public function getId()
	{
		return $this->id;
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider('Product', array(
			'criteria'=>$criteria,
		));
	}

}