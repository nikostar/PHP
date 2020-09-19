<?php

class UsersContr extends User{

	public function update_table_onreload(){
		$this->update_table();
	}

	public function search_for($to_search){
		$results=$this->search_query($to_search);
		//echo $results;
		$View_obj=new UsersView();
		$View_obj->showResults($results);
	}
}
