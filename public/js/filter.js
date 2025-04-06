$(document).ready(function() {
    let currentPage = 1;
    let currentPetType = '';
    let currentLocation = '';

    // Function to load pets 
    function loadPets(petType = '', location = '',page = 1) {
        currentPage = page;
        currentPetType = petType;
        currentLocation = location;

        // Show loading indicator
        $("#search_res").html('<div class="loading">Loading pets...</div>');
        
        $.ajax({
            url: "../../private/functions/filter_result.php",
            method: "GET",
            data: {
                pet_type: petType,
                location: location,
                page: page,
            },
            success: function(data) {
                $("#search_res").html(data);
                totalPages = parseInt($('#total_pages').val()) || 1;
                // update pagination buttons state
                updatePaginationButtons();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#search_res").html(
                    '<div class="error">Error loading pet data. Please try again.</div>'
                );
            }
        });
    }

    // update pagination buttons state
    function updatePaginationButtons(){
        $('#prev_page').prop('disabled', currentPage <= 1);
        $('#next_page').prop('disabled', currentPage >= totalPages);
        $('.pagination_controls span').text(`Page ${currentPage} of ${totalPages}`);
    }

    // Load all pets when page first loads
    loadPets();

    // Handle form submission
    $("#searchForm").on('submit', function(event) {
        event.preventDefault();
        currentPage = 1;
        const petType = $('select[name="pet_type"]').val();
        const location = $('select[name="location"]').val();
        loadPets(petType, location);
    });

    // Handle pagination button click
    $(document).on('click', '.pagination_btn', function(){
        const action = $(this).attr('id');
        if(action === 'prev_page' && currentPage > 1){
            loadPets(currentPetType, currentLocation, currentPage-1);
        }
        else if(action === 'next_page' && currentPage < totalPages){
            loadPets(currentPetType, currentLocation, currentPage+1);
        }
    })
});