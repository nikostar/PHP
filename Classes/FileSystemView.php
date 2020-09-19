<?php

class FileSystemView{

	public function showResults($results){
		if(!empty($results)){
			$path_to_file=implode("<br>", $results);
			echo $path_to_file;
		}
	}
}
