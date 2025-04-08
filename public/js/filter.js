$(document).ready(function () {
    let currentPage = 1;
    let currentPetType = '';
    let currentLocation = '';

    let recPage = 1;
    let recTotalPages = 1;

    function loadPets(petType = '', location = '', page = 1) {
        currentPage = page;
        currentPetType = petType;
        currentLocation = location;

        $("#search_res").html('<div class="loading">Loading pets...</div>');

        $.ajax({
            url: "../../private/functions/filter_result.php",
            method: "GET",
            data: { pet_type: petType, location: location, page: page },
            success: function (data) {
                $("#search_res").html(data);
                totalPages = parseInt($('#total_pages').val()) || 1;
                updatePaginationButtons();
            },
            error: function () {
                $("#search_res").html('<div class="error">Error loading pet data.</div>');
            }
        });
    }

    function updatePaginationButtons() {
        $('#prev_page').prop('disabled', currentPage <= 1);
        $('#next_page').prop('disabled', currentPage >= totalPages);
        $('.pagination_controls span').text(`Page ${currentPage} of ${totalPages}`);
    }

    function loadRecommendations(page = 1) {
        recPage = page;
        $("#recommendation_res").html('<div class="loading">Loading recommendations...</div>');

        $.ajax({
            url: "../../private/functions/fetch_recommendations.php",
            method: "GET",
            data: { page: page },
            success: function (data) {
                $("#recommendation_res").html(data);
                recTotalPages = parseInt($('#recommend_total_pages').val()) || 1;
                updateRecommendationPagination();
            },
            error: function () {
                $("#recommendation_res").html('<div class="error">Error loading recommendations.</div>');
            }
        });
    }

    function updateRecommendationPagination() {
        $('#recommend_prev').prop('disabled', recPage <= 1);
        $('#recommend_next').prop('disabled', recPage >= recTotalPages);
        $('#recommend_page_info').text(`Page ${recPage} of ${recTotalPages}`);
    }

    // Initial load
    loadPets();
    loadRecommendations();

    $("#searchForm").on("submit", function (event) {
        event.preventDefault();
        const petType = $('select[name="pet_type"]').val();
        const location = $('select[name="location"]').val();
        loadPets(petType, location);
    });

    $(document).on("click", ".pagination_btn", function () {
        const id = $(this).attr("id");

        if (id === "prev_page" && currentPage > 1) {
            loadPets(currentPetType, currentLocation, currentPage - 1);
        } else if (id === "next_page" && currentPage < totalPages) {
            loadPets(currentPetType, currentLocation, currentPage + 1);
        }

        if (id === "recommend_prev" && recPage > 1) {
            loadRecommendations(recPage - 1);
        } else if (id === "recommend_next" && recPage < recTotalPages) {
            loadRecommendations(recPage + 1);
        }
    });
});
