$(document).ready(function(){
    // Function to fetch products
    function fetchProducts(searchQuery, categoryId) {
        $.ajax({
            url: 'fetch_products.php', // the PHP file to handle the request
            type: 'GET',
            data: {
                search: searchQuery,
                category: categoryId
            },
            success: function(data) {
                // Replace the content of the product-container with the new data
                $('.product-container').html(data);
            }
        });
    }
    
    // Event listener for the search bar
    $('input[name="search"]').on('input', function() {
        var searchQuery = $(this).val();
        var categoryId = $('#categories').val();
        fetchProducts(searchQuery, categoryId);
    });

    // Event listener for the category selector
    $('#categories').on('change', function() {
        var categoryId = $(this).val();
        var searchQuery = $('input[name="search"]').val();
        fetchProducts(searchQuery, categoryId);
    });
});