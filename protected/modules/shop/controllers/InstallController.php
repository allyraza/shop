<?php

class InstallController extends Controller {

	public function actionIndex() 
	{
		if (Yii::app()->request->isPostRequest) 
		{
			$db = Yii::app()->db;
			$transaction = $db->beginTransaction();
			// Assing table names
			$categoryTable = $_POST['categoryTable'];
			$productsTable = $_POST['productsTable'];
			$orderTable = $_POST['orderTable'];
			$orderPositionTable = $_POST['orderPositionTable'];
			$customerTable = $_POST['customerTable'];
			$addressTable = $_POST['addressTable'];
			$imageTable = $_POST['imageTable'];
			$specificationTable = $_POST['productSpecificationsTable'];
			$variationTable = $_POST['productVariationTable'];
			$taxTable = $_POST['taxTable'];
			$shippingMethodTable = $_POST['shippingMethodTable'];
			$paymentMethodTable = $_POST['paymentMethodTable'];

			// Clean up existing Installation
			$sql = "SET FOREIGN_KEY_CHECKS=0;";
			$db->createCommand($sql)->execute();

			$db->createCommand(sprintf('drop table if exists %s, %s, %s, %s, %s, %s, %s, `%s`, %s, %s',
						$categoryTable, 
						$productsTable, 
						$orderTable,
						$customerTable,
						$imageTable,
						$variationTable,
						$taxTable,
						$shippingMethodTable,
						$paymentMethodTable,
						$specificationTable)
					)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$specificationTable."` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`is_user_input` tinyint(1),
				`required` tinyint(1),
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
			$db->createCommand($sql)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$variationTable."` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`product_id` int(11) NOT NULL,
				`specification_id` int(11) NOT NULL,
				`position` int(11) NOT NULL,
				`title` varchar(255) NOT NULL,
				`price_adjustion` float NOT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

			$db->createCommand($sql)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$taxTable."` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`percent` int(11) NOT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

			$db->createCommand($sql)->execute();
			$sql = "INSERT INTO `".$taxTable."` (`id`, `title`, `percent`) VALUES
				(1, '19%', 19),
				(2, '7%', 7);";

			$db->createCommand($sql)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$shippingMethodTable."` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`description` text NULL,
				`tax_id` int(11) NOT NULL,
				`price` double NOT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

			$db->createCommand($sql)->execute();
			$sql = "INSERT INTO `".$shippingMethodTable."` (`id`, `title`, `description`, `tax_id`, `price`) VALUES
				(1, 'Delivery by postal Service', 'We deliver by Postal Service. 2.99 units of money are charged for that', 1, 2.99);";

			$db->createCommand($sql)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$paymentMethodTable."` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`description` text NULL,
				`tax_id` int(11) NOT NULL,
				`price` double NOT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

			$db->createCommand($sql)->execute();

			$sql = "INSERT INTO `".$paymentMethodTable."` (`id`, `title`, `description`, `tax_id`, `price`) VALUES
				(1, 'cash', 'You pay cash', 1, 0),
				(2, 'advance Payment', 'You pay in advance, we deliver', 1, 0),
				(3, 'cash on delivery', 'You pay when we deliver', 1, 0),
				(4, 'invoice', 'We deliver and send a invoice', 1, 0),
				(5, 'paypal', 'You pay by paypal', 1, 0);";

			$db->createCommand($sql)->execute();

			// Create Category Table
			$sql = "CREATE TABLE IF NOT EXISTS `".$categoryTable."` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`parent_id` INT NULL ,
				`title` VARCHAR(45) NOT NULL ,
				`description` TEXT NULL ,
				`language` VARCHAR(45) NULL ,
				PRIMARY KEY (`id`) )
					ENGINE = InnoDB; ";

			$db->createCommand($sql)->execute();

			// Create Products Table
			$sql = "CREATE  TABLE IF NOT EXISTS `".$productsTable."` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`category_id` INT NOT NULL ,
				`tax_id` INT NOT NULL ,
				`title` VARCHAR(45) NOT NULL ,
				`description` TEXT NULL ,
				`price` VARCHAR(45) NULL ,
				`language` VARCHAR(45) NULL ,
				`specifications` TEXT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_products_category` (`category_id` ASC) ,
				CONSTRAINT `fk_products_category`
					FOREIGN KEY (`category_id` )
					REFERENCES  `".$categoryTable."` (`id` )
					ON DELETE NO ACTION
					ON UPDATE NO ACTION)
					ENGINE = InnoDB;";
			$db->createCommand($sql)->execute();

			// Create Customer Table
			$sql = "CREATE TABLE IF NOT EXISTS `".$customerTable."` (
				`id` INT NOT NULL AUTO_INCREMENT,
				`email` VARCHAR(64) NOT NULL ,
				`password` VARCHAR(64) NOT NULL ,
				PRIMARY KEY (`id`)) ENGINE = InnoDB;";

			$db->createCommand($sql)->execute();


			// Create Order Table

			$sql = "CREATE TABLE IF NOT EXISTS `".$orderTable."` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`customer_id` INT NOT NULL ,
				`delivery_address_id` INT NOT NULL ,
				`billing_address_id` INT NOT NULL ,
				`ordering_date` INT NOT NULL ,
				`ordering_done` TINYINT(1) NULL ,
				`ordering_confirmed` TINYINT(1) NULL ,
				`payment_method` INT NOT NULL ,
				`shipping_method` INT NOT NULL ,
				`comment` TEXT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_order_customer` (`customer_id` ASC) ,
				CONSTRAINT `fk_order_customer1`
					FOREIGN KEY (`customer_id` )
					REFERENCES `".$customerTable."` (`id` )
					ON DELETE NO ACTION
					ON UPDATE NO ACTION)
					ENGINE = InnoDB; ";

			$db->createCommand($sql)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$orderPositionTable."` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`order_id` int(11) NOT NULL,
				`product_id` int(11) NOT NULL,
				`amount` int(11) NOT NULL,
				`specifications` text NOT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

			$db->createCommand($sql)->execute();

			$sql = "CREATE TABLE IF NOT EXISTS `".$addressTable."` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`firstname` varchar(255) NOT NULL,
				`lastname` varchar(255) NOT NULL,
				`street` varchar(255) NOT NULL,
				`zipcode` varchar(255) NOT NULL,
				`city` varchar(255) NOT NULL,
				`country` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

			$db->createCommand($sql)->execute();

			// Create Products Table
			$sql = "CREATE TABLE IF NOT EXISTS `".$productsTable."` (
				`order_id` INT NOT NULL ,
				`product_id` INT NOT NULL ,
				`amount` FLOAT NOT NULL ,
				`product_shipped` TINYINT(1) NULL ,
				`product_arrived` TINYINT(1) NULL ,
				PRIMARY KEY (`product_id`, `order_id`) ,
				INDEX `fk_order_has_products_order` (`order_id` ASC) ,
				INDEX `fk_order_has_products_products` (`product_id` ASC) ,
				CONSTRAINT `fk_order_has_products_order`
					FOREIGN KEY (`order_id` )
					REFERENCES `".$orderTable."` (`order_id` )
					ON DELETE NO ACTION
					ON UPDATE NO ACTION,
				CONSTRAINT `fk_order_has_products_products`
					FOREIGN KEY (`product_id` )
					REFERENCES `".$productsTable."` (`product_id` )
					ON DELETE NO ACTION
					ON UPDATE NO ACTION)
					ENGINE = InnoDB; ";

			$db->createCommand($sql)->execute();

			$sql = "CREATE  TABLE IF NOT EXISTS `".$imageTable."` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`title` VARCHAR(45) NOT NULL ,
				`filename` VARCHAR(45) NOT NULL ,
				`product_id` INT NOT NULL ,
				PRIMARY KEY (`id`) ,
				INDEX `fk_Image_Products` (`product_id` ASC) ,
				CONSTRAINT `fk_Image_Products`
					FOREIGN KEY (`product_id` )
					REFERENCES `".$productsTable."` (`id` )
					ON DELETE NO ACTION
					ON UPDATE NO ACTION)
					ENGINE = InnoDB;";


			$db->createCommand($sql)->execute();

			if ($this->module->demo) 
			{
				$sql = "INSERT INTO `".$categoryTable."` (`id`, `parent_id`, `title`) VALUES
					(1, 0, 'Men'),
					(2, 0, 'Women'),
					(3, 1, 'T-Shirts'),
					(4, 1, 'Shoes'),
					(5, 2, 'Shoes');";

				$db->createCommand($sql)->execute();

				$sql = "INSERT INTO `".$productsTable."` 
(`id`, `tax_id`, `title`, `description`, `price`, `category_id`) VALUES 
(1, 1, 'Addidas Shoes with variations', 'product description goes here', '19.99', 1),
(2, 2, 'Polo T-Shirt with less Tax', '!!', '29.99', 1), 
(3, 1, 'Boss Short Sleeve T-Shirt', '', '', 2),
(4, 1, 'Long Boots', '', '7, 55', 4);";


				$db->createCommand($sql)->execute();
				$sql = "
					INSERT INTO `".$variationTable."` (`id`, `product_id`, `specification_id`, `title`, `price_adjustion`, `position`) VALUES
					(1, 1, 1, 'Small', 5, 2),
					(2, 1, 1, 'Medium', 10, 3),
					(3, 1, 1, 'Large', 15, 3),
					(4, 1, 2, 'Red', 10, 4),
					(5, 1, 2, 'Blue', 15, 4),
					(6, 1, 5, 'please enter a number here', 0, 1);
				";
				$db->createCommand($sql)->execute();
				$sql = "
					INSERT INTO `".$specificationTable."` (`id`, `title`, `is_user_input`, `required`) VALUES
					(1, 'Size', 0, 1),
					(2, 'Color', 0, 0),
					(3, 'Some random attribute', 0, 0),
					(4, 'Material', 0, 1),
					(5, 'Specific number', 1, 1);
				";
				$db->createCommand($sql)->execute();
				$sql = "SET FOREIGN_KEY_CHECKS=1;";
				$db->createCommand($sql)->execute();

			}
			$transaction->commit();
			$this->render('complete');
		}
		else
			$this->render('index');
	}

}