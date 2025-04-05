$(document).ready(function() {
    // Function to load pets (used for both initial load and searches)
    function loadPets(petType = '', location = '') {
        // Show loading indicator
        $("#search_res").html('<div class="loading">Loading pets...</div>');
        
        $.ajax({
            url: "../../private/functions/filter_result.php",
            method: "GET",
            data: {
                pet_type: petType,
                location: location
            },
            success: function(data) {
                $("#search_res").html(data);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#search_res").html(
                    '<div class="error">Error loading pet data. Please try again.</div>'
                );
            }
        });
    }

    // Load all pets when page first loads
    loadPets();

    // Handle form submission
    $("#searchForm").on('submit', function(event) {
        event.preventDefault();
        const petType = $('select[name="pet_type"]').val();
        const location = $('select[name="location"]').val();
        loadPets(petType, location);
    });
});