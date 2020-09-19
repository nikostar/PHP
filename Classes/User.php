<?php

class User extends Dbh{

	//
	// update_table:
	// Reset database given textfile
	protected function update_table(){
		//reset autoincrement
		$sql="alter table test1 auto_increment=1;";
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

		$myfile = fopen("Text_file.txt", "r") or die("Unable to open file!");
		$prevIdent=-1;
		$left=1;
		$right=2;

		while(!feof($myfile)) {
		  	$line=fgets($myfile);
		  	$name= ltrim($line);
		  	$identSize = strlen($line)-strlen($name);
//lala
		  	if($prevIdent==-1)
		  	{
		  		$sql="INSERT INTO test1(name,lft,rgt) VALUES('$name', $left, $right);";
		  		$this->run_sql($sql);
		  	}
		  	else
		  	{
		  		$left+=2-($identSize-$prevIdent);
		  		$right=$left+1;

		  		$sql="UPDATE test1 SET rgt=rgt+2 WHERE rgt>=$left;";
				$this->run_sql($sql);

		  		$sql="INSERT INTO test1(name,lft,rgt) VALUES('$name', $left, $right);";
		  		$this->run_sql($sql);

		  	}
		  	$prevIdent=$identSize;

		}

		fclose($myfile);		
	}

	protected function search_query(string $to_search){
		if($to_search==Null){
			return Null;
		}

		$sql="SELECT * FROM test1 WHERE name LIKE '%$to_search%';";
		$stmt=$this->connect()->prepare($sql);
		$stmt->execute();

		//return all valid files.
		while($row=$stmt->fetch()){
			$temp_lft=$row['lft'];
			$temp_rgt=$row['rgt'];
			$printed="";
			
			$sql="SELECT name FROM test1 WHERE lft<=$temp_lft AND rgt>=$temp_rgt ORDER BY lft ASC;";
			$to_print=$this->connect()->prepare($sql);
			$to_print->execute();

			//return parents of each file
			while($row2=$to_print->fetch()){				
				$printed=$printed . trim($row2['name']) . "\\";
			}
			
			$new_str = substr($printed, 0,-1);
			$array[]=$new_str;
		}
		if(empty($array)){
			$array[]="No files found!";
		}		
		return $array;
	}

	private function run_sql($sql){
		$stmt=$this->connect()->prepare($sql);
		$stmt->execute();
	}

}
