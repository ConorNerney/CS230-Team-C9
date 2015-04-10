<?php

function populateSingleBasketEntryHtml($sqlRow, $html, $quantity)
{
    return str_replace(
    array("<!--INST_BE_NAME-->", "<!--INST_BE_AUTHOR-->", "<!--INST_BE_UNITCOST-->", "<!--INST_BE_TOTALCOST-->", "<!--INST_BE_QUANTITY-->"),
	array($sqlRow['title'], $sqlRow['author'], $sqlRow['price'], $sqlRow['price']*$quantity, $quantity),
	$html);
}


class Basket
{

	//Format: 'id:?' => quantity
	var $items = [];

	function addItem($id, $quantity)
	{
		if($quantity != 0)
		{
			//use prefix to treat it as a string.
			if(isset($this->items["id:".$id]))
				$this->items["id:".$id] += $quantity;
			else
				$this->items["id:".$id] = $quantity;
		}

	}

	/*
	* Assumes that sql is initialised.
	*/
	function printBasket($baskethtml)
	{
		$basketentry = file_get_contents("content/singlebasketentry.html");
		$entries = "";

		foreach($this->items as $idstr => $quantity)
		{
			$id = substr($idstr, 3);
			$qry = makeQuery("SELECT * FROM testanima WHERE id=".$id);
			if(count($qry)==0)
				reportError("Invalid basket state.");
			$row = $qry[0];

			$entries = $entries . populateSingleBasketEntryHtml($row, $basketentry, $quantity);
		}

		return str_replace("<!--INST_BS_ENTRYLIST-->", $entries, $baskethtml);

	}

}

?>