<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php	
		require_once('connectdb.php');

	if (isset($_GET['id'])) {
  	// Get the ID from the URL parameter
  	$id = $_GET['id'];

  	// Delete the project from the database
  	$sql = "DELETE FROM projects WHERE pid = $id";
  	$result = $db->query($sql);

  	// Check if the query was successful
  	if ($result) {
    	echo "<script>alert('Project deleted successfully'); window.location.href='index.php';</script>";
  	} else {
    	echo "Error deleting project: " . $db->error;
  	}
	} else {
  		echo "No project ID specified";
}

// Close the database connection
$db->close();
?>

</body>
</html>