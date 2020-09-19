<?php	
	include_once'includes/classloader.php';	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search from database</title>
</head>
<body>

	<form action="" method="GET">
		<input type="text" name="search" placeholder="Search for...">
		<button type="submit" name="submit">Search</button>
	</form>

<?php
	
	//if search button clicked...
	if(isset($_GET['submit'])){
		$search_name=$_GET['search'];
		$modelObj=new FileSystemController();
		$modelObj->SearchGivenName($search_name);
	}
?>
</body>
</html>