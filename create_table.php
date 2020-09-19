<?php

	include_once'includes/dbh.php';

	$sql="alter table test1 auto_increment=1;";
	mysqli_query($conn,$sql);

	$sql="DROP TABLE test1;";
	mysqli_query($conn,$sql);

	$sql="CREATE TABLE test1 (
	        category_id INT AUTO_INCREMENT PRIMARY KEY,
	        name VARCHAR(20) NOT NULL,
	        lft INT NOT NULL,
	        rgt INT NOT NULL
		);";

	mysqli_query($conn,$sql);

	$myfile = fopen("Text_file.txt", "r") or die("Unable to open file!");
	$prevIdent=-1;
	$left=1;
	$right=2;

	while(!feof($myfile)) {
	  	$line=fgets($myfile);

	  	$identSize = strlen($line)-strlen(ltrim($line));

	  	$name= ltrim($line);

	  	if($prevIdent==-1)
	  	{
	  		$sql="INSERT INTO test1(name,lft,rgt) VALUES('$name',$left,$right);";
	  		mysqli_query($conn,$sql);
	  	}
	  	else
	  	{
	  		$left+=2-($identSize-$prevIdent);
	  		$right=$left+1;
	  		$sql="UPDATE test1 SET rgt=rgt+2 WHERE rgt>=$left;";
			mysqli_query($conn,$sql);
	  		$sql="INSERT INTO test1(name,lft,rgt) VALUES('$name',$left,$right);";
	  		mysqli_query($conn,$sql);
	  	}

	  	$prevIdent=$identSize;

	}


	fclose($myfile);


