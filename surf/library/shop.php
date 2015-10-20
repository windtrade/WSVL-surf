<?php

class shop {
	function newArray($eenProd_ID, $number){
		//Makes new cart
		
		$cart = array($eenProd_ID, $number);
		return $cart;
	}
	
	function updateCart($oldArray, $eenProd_ID, $number){
		//Updates cart
		$oldArray[] = $eenProd_ID;
		$oldArray[] = $number;
		return $oldArray;
		
	}
	
	function searchCart($array, $eenProd_ID){
		//finds the product in the array
		$length = count($array);
		$status = green;
		for ($i = 0; $i<$length; $i = $i +2){
			if($array[$i] == $eenProd_ID){
				//Prod is in array
				$status = red;
			}
		}
		return $status;
	}
	
	
	function remove($array, $id){
		//Removes thing from id.
		$array[$id] = null;
		$id ++;
		$array[$id] = null;
		return $array;
	}
	
	function increase($array, $id){
		//Removes thing from id.
		//$array[$id] = null;
		$id ++;
		
		$array[$id] = $array[$id] + 1;
		return $array;
	}
	
	function decrease($array, $id){
		//Removes thing from id.
		//$array[$id] = null;
		$id ++;
		
		$array[$id] = $array[$id] -1;
		return $array;
	}
}
	?>