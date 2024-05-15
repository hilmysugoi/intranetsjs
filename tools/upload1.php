<!DOCTYPE html>
<html>
<head>
	<title>Upload CSV</title>
</head>
<body>
	<h1>Upload Data CSV ke Database</h1>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
		<label for="file">Pilih file CSV:</label>
		<input type="file" name="file" id="file"><br><br>
		<input type="submit" name="submit" value="Upload">
	</form>
</body>
</html>