<?php 
//Add Dropdown box for the page.
function drop_list($label,$varname,$options,$texts) {
	global $$varname;
	echo "<td id='label2'>$label</td>";
	echo "<td><select name=\"$varname\"";
	echo ">";

	$i = 0;
	foreach($options as $opt) 
		drop_option($texts[$i++],$varname, $opt);
	echo "</select></td>";
}

function drop_option($text,$varname, $opt) {
	global $$varname;
	
	echo "<option value=\"$opt\" ";
	if (!empty($$varname) && $$varname==$opt ) echo "selected"; 
	echo ">$text</option>\n";
}

function search_button() {	
	echo "<tr><td id='submit'><input type=\"submit\"  name=\"submit\" border=0 value=\"Search\"></td></tr>";
}
?>