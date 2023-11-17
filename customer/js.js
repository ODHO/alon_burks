$(document).ready(function () {
    $(".searchTerm").on("input", function () {
        var searchTerm = $(this).val();

        // Send AJAX request to get suggestions
        $.ajax({
            url: 'search_providers.php',
            type: 'POST',
            data: { searchTerm: searchTerm },
            success: function (response) {
                $("#suggestions").html(response);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});