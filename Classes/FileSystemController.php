<?php

class FileSystemController{
	public function SearchGivenName($file_name){
		$model=new FileSystem();
		$model->CreateFileSystemFromText();

		$results=$model->SearchFilePath($file_name);

		$View=new FileSystemView();
		$View->showResults($results);
	}
}
