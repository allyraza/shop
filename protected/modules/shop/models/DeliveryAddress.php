<?php

class DeliveryAddress extends Address {

	// This address is not *required*
	public function rules()
	{
		return [
			['firstname, lastname, street, zipcode, city, country', 'length', 'max'=>255],
			['id, street, zipcode, city, country', 'safe', 'on'=>'search'],
		];
	}

}