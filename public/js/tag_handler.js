$(document).ready(function(){
    $("#tag_input").on("input", function(){
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "fetch_tags.php",
                method: "POST",
                data: { query: query },
                success: function(data){
                    $("#tag_suggestions").html(data);
                }
            });
        } else {
            $("#tag_suggestions").html("");
        }
    });
});

// Function to add tag from user input
function addTagFromInput() {
    let tagName = $("#tag_input").val().trim();
    if (tagName) {
        addTag(tagName);
    }
}

function addTag(tagName){
    let tagList = $("#tag_list");
    tagName = tagName.toLowerCase();

    if (!tagList.find("[data-tag='" + tagName + "']").length) {
        tagList.append(`<span data-tag='${tagName}' class='tag-item'>${tagName} <button type='button' onclick='removeTag("${tagName}")'>x</button></span>`);
        $("#tags").append(`<input type='hidden' name='tags[]' value='${tagName}' data-tag='${tagName}'>`);
    }
    $("#tag_input").val("");
    $("#tag_suggestions").html("");
}

function removeTag(tagName) {
    $(`[data-tag='${tagName}']`).remove();
}
