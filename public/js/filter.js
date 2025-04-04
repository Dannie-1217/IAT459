$(document).ready(function() {

    $("#searchForm").submit(function(event) {
        event.preventDefault();  // Prevent the form from submitting in the traditional way

        // Get the values of the selected filters using jQuery
        const petType = $('select[name="pet_type"]').val();
        const location = $('select[name="location"]').val();

        // Build the query string with the selected filters
        const queryString = `../../private/functions/filter_result.php?pet_type=${encodeURIComponent(petType)}&location=${encodeURIComponent(location)}`;

        // Fetch the filtered results from the server using jQuery's AJAX
        $.ajax({
            url: queryString,
            method: "GET",
            success: function(data) {
                // Insert the result into the search results container
                $("#search_res").html(data);
            },
            error: function(error) {
                console.error("Error:", error);
            }
        });
    });
});
