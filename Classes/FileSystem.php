<?php

class FileSystem extends DatabaseHandler{

	//
	// update_table:
	// Reset database given textfile
	public function CreateFileSystemFromText(){
		//reset autoincrement
		$sql="ALTER TABLE test1 AUTO_INCREMENT=1;";
		$this->run_sql($sql);
	
		//redo the database
		$sql="DROP TABLE test1;";
		$this->run_sql($sql);

		//create database
		$sql="CREATE TABLE test1 (
		        category_id INT AUTO_INCREMENT PRIMARY KEY,
		        name VARCHAR(20) NOT NULL,
		        lft INT NOT NULL,
		        rgt INT NOT NULL
			);";
		$this->run_sql($sql);

		$myfile=fopen("Text_file.txt", "r") or die("Unable to open file!");
		$prevIdent=-1;
		$left=1;
		$right=2;

		while(!feof($myfile)) {
		  	$line=fgets($myfile);
		  	$name=ltrim($line);
		  	$identSize = strlen($line)-strlen($name);

		  	if($prevIdent==-1)
		  	{
		  		$sql="INSERT INTO test1(name, lft, rgt) VALUES('$name', $left, $right);";
		  		$this->run_sql($sql);
		  	}
		  	else
		  	{
		  		$left+=2-($identSize-$prevIdent);
		  		$right=$left+1;

		  		$sql="UPDATE test1 SET rgt=rgt+2 WHERE rgt>=$left;";
				$this->run_sql($sql);

		  		$sql="INSERT INTO test1(name, lft, rgt) VALUES('$name', $left, $right);";
		  		$this->run_sql($sql);

		  	}
		  	$prevIdent=$identSize;

		}

		fclose($myfile);		
	}

	public function SearchFilePath($file_name){
		if($file_name==Null){
			return Null;
		}

		$sql="SELECT * FROM test1 WHERE name LIKE '%$file_name%';";
		$stmt=$this->connect()->prepare($sql);
		$stmt->execute();

		//return all valid files.
		while($row=$stmt->fetch()){
			$temp_lft=$row['lft'];
			$temp_rgt=$row['rgt'];
			$file_path="";
			
			$sql="SELECT name FROM test1 WHERE lft<=$temp_lft AND rgt>=$temp_rgt ORDER BY lft ASC;";
			$statement=$this->connect()->prepare($sql);
			$statement->execute();

			//return parents of each file
			while($row2=$statement->fetch()){				
				$file_path=$file_path . trim($row2['name']) . "\\";
			}
			
			$trimmed_file_path = substr($file_path, 0, -1);
			$array_of_filepaths[]=$trimmed_file_path;
		}
		if(empty($array_of_filepaths)){
			$array_of_filepaths[]="No files found!";
		}		
		return $array_of_filepaths;
	}

	private function run_sql($sql){
		$stmt=$this->connect()->prepare($sql);
		$stmt->execute();
	}

}
