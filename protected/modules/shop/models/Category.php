<?php

class Category extends CActiveRecord {

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->controller->module->categoriesTable;
	}

	public function rules()
	{
		return array(
			array('category_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('title, description, language', 'length', 'max'=>45),
			array('title', 'required'),
			array('category_id, parent_id, title, description, language', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'products' => array(self::HAS_MANY, 'Product', 'category_id'),
			'parent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
			'childs' => array(self::HAS_MANY, 'Category', 'parent_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'category_id' => '#',
			'parent_id' => Yii::t('ShopModule.shop', 'Parent'),
			'title' => Yii::t('ShopModule.shop', 'Category'),
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title,true);
		return new CActiveDataProvider('Category', [
			'criteria'=>$criteria,
		]);
	}
}
