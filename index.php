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
	$userObj=new UsersContr();
	$userObj->update_table_onreload();
	//if search button clicked...
	if(isset($_GET['submit'])){
		$search=$_GET['search'];
		$userObj=new UsersContr();
		$userObj->search_for($search);
	}
	?>
</body>
</html>