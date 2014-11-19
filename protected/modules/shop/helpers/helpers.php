<?php

function price($value=0, $fmt='$')
{
	Yii::app()->numberFormatter->formatCurrency($value, $fmt);
}