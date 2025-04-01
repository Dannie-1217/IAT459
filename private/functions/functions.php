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

// check user type
function check_user_type($connection, $user_name) {
    // Query to get user type based on user_name
    $type_query = "SELECT user_type FROM user WHERE user_name = '$user_name'";
    $type_res = mysqli_query($connection, $type_query);
    
    if ($type_res) {
        $userType = mysqli_fetch_assoc($type_res)['user_type'];
        return $userType;
    } else {
        return null; // In case of an error, return null
    }
}
?>