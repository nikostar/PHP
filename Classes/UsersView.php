<?php

class UsersView extends User{

	public function showResults($results){
		if(!empty($results)){
			$withComma = implode("<br>", $results);
			echo $withComma;
		}
	}
}
