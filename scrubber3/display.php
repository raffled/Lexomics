<?php session_start(); ?>
<html>
<head>
<title>Success!</title>
</head>
<body>
<?php 
$file = file_get_contents($_SESSION["file"]);
echo htmlspecialchars($file) . "<p></p>";
echo $_SESSION["scrubbed"];
?>

<form action='scrub.php' method="post">
<input type="submit" name="submit" value="Scrub">
</form>

<form action="uploader.php" method="post"
enctype="multipart/form-data">
<input type="hidden" name="type" value="stopwords" /> 
<label for="file">Stop Words:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="stopwords" value="Upload Stop Words" />
</form>

<form action="uploader.php" method="post"
enctype="multipart/form-data">
<input type="hidden" name="type" value="lemmas" /> 
<label for="file">Lemmas:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="stopwords" value="Upload Lemmas" />
</form>

<form action="uploader.php" method="post"
enctype="multipart/form-data">
<input type="hidden" name="type" value="orth" /> 
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="stopwords" value="Upload Orthographical Replacements" />
</form>


</body>
</html>
