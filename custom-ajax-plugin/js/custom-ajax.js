jQuery(document).ready(function($) {
    $('#custom-ajax-button').on('click', function() {
        $.ajax({
            url: custom_ajax_object.ajax_url,
            type: 'GET',
            dataType: 'json',
            data: { action: 'custom_ajax_get_data' },
            success: function(response) {
                if (response.success) {
                    var tableHtml = '<table><thead><tr><th>Customer ID</th><th>Ingredients</th></tr></thead><tbody>';
                    $.each(response.data, function(index, customer) {
                        tableHtml += '<tr><td>' + customer.customer_id + '</td><td>' + customer.ingredients.join(', ') + '</td></tr>';
                    });
                    tableHtml += '</tbody></table>';
                    $('#custom-ajax-table').html(tableHtml);
                } else {
                    console.log('Error:', response.data);
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
            }
        });
    });
});
