<?php

class Basket
{
	var $items = [];

	function addItem($id, $quantity)
	{
		//use prefix to treat it as a string.
		if(isset($this->items["id:".$id]))
			$this->items["id:".$id] += $quantity;
		else
			$this->items["id:".$id] = $quantity;
	}
}

?>