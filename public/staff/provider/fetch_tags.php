<?php
require_once("../../../private/functions/initialization.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query"])) {
    $query = mysqli_real_escape_string($connection, $_POST["query"]);
    
    $tagQuery = "SELECT content FROM tags WHERE content LIKE '%$query%' LIMIT 10";
    $result = mysqli_query($connection, $tagQuery);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='tag-suggestion' onclick='addTag(\"" . $row['content'] . "\")'>" . htmlspecialchars($row['content']) . "</div>";
        }
    } else {
        echo "<div class='tag-suggestion'>No matching tags found</div>";
    }
}
?>
