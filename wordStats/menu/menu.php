
<script type="text/javascript">
// function getURLParam( string )
// copied from :: 
// and adapted for use
// takes the string passed and parses it and it's value from the URL
//   easy way to do PHP's $_GET['strParamName']
function getURLParam( strParamName ) {

	var strReturn = "";
	var strHref = window.location.href;

	if ( strHref.indexOf( "?" ) > -1 ) {

		var strQueryString = strHref.substr( strHref.indexOf( "?" ) );
		var aQueryString = strQueryString.split( "&" );

		for ( var iParam = 0; iParam < aQueryString.length; iParam++ ) {

			if ( aQueryString[iParam].indexOf( strParamName + "=" ) > -1 ) {

				var aParam = aQueryString[iParam].split( "=" );
				strReturn = aParam[1];
				break;

			}

		}

	}

	return strReturn;

}

function isNumber( num ) {



}

</script>
<script src="<? echo $menujs ?>" type="text/javascript"></script>

<form action="index.php" method="GET">
<div id="fullmenu">

	<div class="leftcol">

		<div>Text Options</div>		
		<div>Sort by</div>
		<div>Tags</div>
		<div>Consolidations</div>
		<div>Top N Words</div>
		<div>  
			<input type="submit" value="Get Stats" /></td>
		</div>
		<div>Text Selections</div>

	</div>

	<div class="rightcol">

		<div>	
			<? include( "../menu/menudropdown.php" ) /* for the texts menu */ ?>
		</div>

		<div>
			<select name="sort">
				<option value="count">Count</option>
				<option value="alpha" <? if ($_GET['sort']=="alpha"){echo"selected='selected'";} ?>>Word</option>
			</select>
		</div>
		
		<div>
			<select name="tags">
				<option value="keep">Keep</option>
				<option value="discard" <? if ($_GET['tags']=="discard"){echo"selected='selected'";} ?>>Discard</option>
			</select>
		</div>
		
        <div>
			<select name="consolidation">
				<option value="none">None</option>
				<option value="eth" <? if ($_GET['consolidation']=="eth"){echo"selected='selected'";} ?>>eth=thorn</option>
				<option value="and" <? if ($_GET['consolidation']=="and"){echo"selected='selected'";} ?>>and=ond=&</option>
				<option value="both" <? if ($_GET['consolidation']=="both"){echo"selected='selected'";} ?>>Both</option>
			</select>
		</div>

		<div>
			<input type="text" name="top" size="6" 
				onblur="if(isNaN(this.value)){alert(this.value+' is not a number');this.value=0;}" 
				value='<?php if ($_GET['top'] == "" || $_GET['top'] < 0) {echo "0";} else {echo $_GET['top'];} ?>' /> 
		</div>


                 <br><br>
		<div id='selections' style="max-width:376px; margin:2em; margin-left:auto; margin-right:auto; clear: none !important; clear: right; text-align:justify;">

		</div>		

<div class="warning" style="max-width:376px; margin:2em; margin-left:auto; margin-right:auto; clear: none !important; clear: right; text-align:justify; "> 
			Be patient, some selections can take a long time to load.
		</div>
	
	</div>

	<div style="display:none;">
		<input type="text" 
			value='<?php //if ($_GET['file'] == "") {echo "Entire_Corpus";} else {echo $_GET['file'];} ?>' 
			readonly="yes" name="file" id="print" />
	</div>

	<hr class="tablebottom" />
</div>
</form>









