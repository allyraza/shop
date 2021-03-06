<?php

class ProductsController extends Controller
{

	public $_model;

	public function filters()
	{
		return array(
			'accessControl',
		);
	}	

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('view', 'index'),
					'users' => array('*'),
					),
				array('allow',
					'actions'=>array('admin','delete','create','update', 'view'),
					'users' => array('admin'),
					),
				array('deny',  // deny all other users
						'users'=>array('*'),
						),
				);
	}

	public function beforeAction($action)
	{
		$this->layout = $this->module->layout;
		return parent::beforeAction($action);
	}

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$model=new Product;

		 $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if(isset($_POST['Specifications']))
				$model->setSpecifications($_POST['Specifications']);


			if($model->save())
				$this->redirect(array('shop/admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id, $return = null)
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if (isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if (isset($_POST['Specifications']))
				$model->setSpecifications($_POST['Specifications']);
			if (isset($_POST['Variations']))
				$model->setVariations($_POST['Variations']);

			if ($model->save())
			{
				if ($return == 'product')
					$this->redirect(array('products/update', 'id' => $model->product_id));
				else
					$this->redirect(array('products/admin'));
			}
		}

		$this->render('update', compact('model'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if (Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_POST['ajax']))
				$this->redirect(['index']);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Product');
		$this->render('index', compact('dataProvider'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		if (isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin', compact('model'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if ($this->_model===null)
		{
			if (isset($_GET['id']))
				$this->_model=Product::model()->findbyPk($_GET['id']);
			if ($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}