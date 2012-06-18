<?php 
error_reporting (E_ALL ^ E_NOTICE);
session_start(); 
$file = file_get_contents($_SESSION["file"]);
if(is_null($_SESSION["file"])) {
    header('Location: ' . "index.html");
    die();
}
if (is_null($_SESSION["POST"])) {
    $_SESSION["POST"]["punctuationbox"] = "on";
    $_SESSION["POST"]["digitsbox"] = "on";
    if(preg_match("'<[^>]+>'U", $file) > 0)
        $_SESSION["POST"]["formattingbox"] = "on";
    $_SESSION["POST"]["lowercasebox"] = "on";
    if(strpos($file, "&ae;") or strpos($file, "&d;") or strpos($file, "&t;"))
        $_SESSION["POST"]["specialbox"] = "on";
    $_SESSION["POST"]["stopwordbox"] = "on";
    $_SESSION["POST"]["lemmabox"] = "on";
    $_SESSION["POST"]["consolidationbox"] = "on";
    $_SESSION["POST"]["tags"] = "keep";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Scrubber</title>
<link rel="stylesheet" type="text/css" href="display.css"/>
<script type="text/javascript">
    <!--
        function tagSelect() {
            var formatting = document.getElementById("formattingbox");
            var tags = document.getElementById("tagBox");
            if(formatting.checked == 1) 
               tags.style.display = 'inline'; 
            else
                tags.style.display = 'none';
        }
    //-->
</script>
</head>
<body style="display: inline">
    <div id="header">
        &nbsp;<b>Scrubber</b>
    </div>
<div id="sidebar">
    <div class="sidetitles">
    <legend><b>Tools </b></legend>
    </div>
    <fieldset class="sidebar_field">
        <div id="buttons">
        <div id="download">
            <?php if(isset($_SESSION["scrubbed"])) : ?>
            <form action='downloader.php' method="post">
                <input type="submit" name="submit" value="Download">
            </form>
            <?php endif; ?>
        </div>
        <div id="clear">
            <form action='clear.php' method="post">
                <input type="submit" name="submit" value="Clear">
            </form>
        </div>
        <form action='scrub.php' method="post">
            <div id="scrub">
                <input type="submit" name="submit" value="Scrub">
            </div>
            <br />
        </div>
        </fieldset>
        <br />
        <div class="sidetitles">
            <legend><b>Scrubbing Options </b></font></legend>
            </div>
        <fieldset class="sidebar_field">
            
            <input type="checkbox" name="punctuationbox" <?php if(isset($_SESSION["POST"]["punctuationbox"])) echo "checked" ?>/> Remove Punctuation
            <br /><input type="checkbox" name="digitsbox" <?php if(isset($_SESSION["POST"]["digitsbox"])) echo "checked" ?>/> Remove Digits
            <?php if(preg_match("'<[^>]+>'U", $file) > 0): ?>
            <br /><input type="checkbox" name="formattingbox" id="formattingbox" <?php if(isset($_SESSION["POST"]["formattingbox"])) echo "checked" ?> onClick="tagSelect()"/> Strip Tags
            <div id="tagBox" style=<?php if(is_null($_SESSION["POST"]["formattingbox"])) echo "display: none;" ?>/>
                <br /><input type="radio" name="tags" value="keep" <?php if($_SESSION["POST"]["tags"] == "keep") echo "checked" ?> /> Keep Words Inside Tags<br />
                <input type="radio" name="tags" value="discard" <?php if($_SESSION["POST"]["tags"] == "discard") echo "checked" ?> /> Discard Words Inside Tags
            </div>
            <?php endif; ?>
            <br /><input type="checkbox" name="lowercasebox" <?php if(isset($_SESSION["POST"]["lowercasebox"])) echo "checked" ?>/> Make Lowercase
            <?php if(strpos($file, "&ae;") or strpos($file, "&d;") or strpos($file, "&t;")) : ?>
                <br /><input type="checkbox" name="specialbox" <?php if(isset($_SESSION["POST"]["specialbox"])) echo "checked" ?>/> Format Special Characters
            <?php endif; ?>
            <?php if(isset($_SESSION["stopwords"])) : ?>
                <br /><input type="checkbox" name="stopwordbox" <?php if(isset($_SESSION["POST"]["stopwordbox"])) echo "checked" ?>/> Remove Stopwords
            <?php endif; ?>
            <?php if(isset($_SESSION["lemmas"])) : ?>
                <br /><input type="checkbox" name="lemmabox" <?php if(isset($_SESSION["POST"]["lemmabox"])) echo "checked" ?>/> Lemmatize
            <?php endif; ?>
            <?php if(isset($_SESSION["consolidations"])) : ?>
                <br /><input type="checkbox" name="consolidationbox" <?php if(isset($_SESSION["POST"]["consolidationbox"])) echo "checked" ?>/> Consolidate
            <?php endif; ?>
            <br />
            </form>
        </fieldset>
    <br />
    <div class="sidetitles">
        <legend><b>Upload </b></legend>
    </div>
    <fieldset class="sidebar_field">
        <form action="uploader.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="stopwords" /> 
            <label for="file">Stop Words:</label><br />
            <input type="file" name="file" id="file" required="required"/> 
            <br />
            <input type="submit" name="stopwords" value="Upload Stop Words" />
        </form>
        <form action="uploader.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="lemmas" /> 
            <label for="file">Lemmas:</label><br />
            <input type="file" name="file" id="file" required="required"/> 
            <br />
            <input type="submit" name="lemmas" value="Upload Lemmas" />
        </form>
        <form action="uploader.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="consolidations" /> 
            <label for="file">Consolidations:</label><br />
            <input type="file" name="file" id="file" required="required"/> 
            <br />
            <input type="submit" name="consolidations" value="Upload Consolidations" />
        </form>
    </fieldset><br />
    </div>
</div>
<div id="main">
<div class="titles">
<b>Unscrubbed: </b>
</div>
<div id="unscrubbedtext">
<?php 
    echo htmlspecialchars($file);
?>
</div>

<?php if(isset($_SESSION["scrubbed"])) : ?>
<div class="titles">
<b>Scrubbed: </b>
</div>
<div id="scrubbedtext">
<?php 
	echo $_SESSION["scrubbed"];
?>
</div>
<?php endif; ?>

<div id="buffer">
</div>


<?php if(isset($_SESSION["stopwords"])) : ?>
<div class="bottomtitles">
    Stop Words:
</div>
<?php endif; ?>
<?php if(isset($_SESSION["lemmas"])) : ?>
<div class="bottomtitles">
    Lemmas:
</div>
<?php endif; ?>
<?php if(isset($_SESSION["consolidations"])) : ?>
<div class="bottomtitles">
    Consolidations:
</div>
<?php endif; ?>

<div id="buffer">
</div>

<?php if(isset($_SESSION["stopwords"])) : ?>
    <div id='stopwordtext'>
    <?php
    $explodedsw = explode(", ", file_get_contents($_SESSION["stopwords"]));
    sort($explodedsw);
    $resultarr = array();
    foreach(array_values($explodedsw) as $swvalue)
        $resultarr[] = $swvalue;
    $result = implode(", ",$resultarr);
    echo $result;
    ?>
    </div>
<?php endif; ?>


<?php if(isset($_SESSION["lemmas"])) : ?>
<div id='lemmatext'>
    <?php echo preg_replace("/(\r?\n)/", "<br />", str_replace(", ", " → ", file_get_contents($_SESSION["lemmas"]))) ?>
</div>
<?php endif; ?>

<?php if(isset($_SESSION["consolidations"])) : ?>
<div id='consolidationtext'>
    <?php echo preg_replace("/(\r?\n)/", "<br />", str_replace(", ", " → ", file_get_contents($_SESSION["consolidations"]))) ?>
</div>
<?php endif; ?>

</div>


<div id="info">
    &nbsp;<a href="http://wheatoncollege.edu/lexomics/"> Lexomics @ Wheaton College</a>
</div>
</body>

<script type="text/javascript">
    tagSelect(document.getElementById());
</script>
</html>