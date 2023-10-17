$(document).ready(function() {
    $('body').on('click', '#editButton', function () {
        var userURL = $(this).data('url');
        $.get(userURL, function (data) {
            $('#editModal').show();
            $('#p_id_2').val(data.p_id);
            $('#cat_id_2').val(data.cat_id);
            $('#item_2').val(data.item);
            $('#department_2').val(data.department);
            $('#unit_2').val(data.unit);
            $('#line_no_2').val(data.line_no);
            $('#description_2').val(data.description);
            $('#cost_2').val(data.cost);
            $('#selling_price_2').val(data.selling_price);
            $('#rol_2').val(data.rol);
            $('#capacity_2').val(data.capacity);
            $('#open_stock_2').val(data.open_stock);
        })
     });

     $('#updateCategory').click(function() {
        var p_id = $('#p_id_2').val();
        var _token = $('#_token').val();
        var cat_id = $('#cat_id_2').val();
        var item = $('#item_2').val();
        var department = $('#department_2').val();
        var unit = $('#unit_2').val();
        var line_no = $('#line_no_2').val();
        var description = $('#description_2').val();
        var cost = $('#cost_2').val();
        var selling_price = $('#selling_price_2').val();
        var rol = $('#rol_2').val();
        var capacity = $('#capacity_2').val();
        var open_stock = $('#open_stock_2').val();
        var url = 'update/'+ p_id;

        // Send form data using ajax
        $.ajax({
            type: 'POST',
            url: url,
            data: {'_token': _token,'p_id': p_id, 'cat_id': cat_id, 'item': item, 'department': department, 'unit': unit, 'line_no': line_no, 'description': description, 'cost': cost, 'selling_price': selling_price, 'rol': rol, 'capacity': capacity, 'open_stock': open_stock},
            success: function(data){
                alert("Record updated successfully...");
                location.reload();
            },
            error: function(data){
                alert('Sorry! Can\'t update record...');
                location.reload();
            }
        });

     });

     $('#closeBtn').click(function() {
        $('#editModal').hide();
     });

     $('#closeBtn_2').click(function() {
        $('#editModal').hide();
     });
});
