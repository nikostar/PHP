<?php

class FileSystemController{
	//reset the table from textfile
	//and prompt view to display search results
	public function SearchGivenName($file_name){
		$model=new FileSystem();
		$model->CreateFileSystemFromText();

		$results=$model->SearchFilePath($file_name);

		$View=new FileSystemView();
		$View->showResults($results);
	}
}
