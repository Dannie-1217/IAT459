<?php 

function drop_list($label, $varname, $options, $texts) {
    global $$varname;
    echo "<select name=\"$varname\">";
    
    // Add the first option as the placeholder (with value="")
    echo "<option value=\"\" disabled selected>$label</option>";

    $i = 0;
    foreach($options as $opt) {
        drop_option($texts[$i++], $varname, $opt);
    }
    echo "</select>";
}

function drop_option($text, $varname, $opt) {
    global $$varname;
    
    echo "<option value=\"$opt\" ";
    if (!empty($$varname) && $$varname == $opt) {
        echo "selected";
    }
    echo ">$text</option>\n";
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