$(document).ready(function() {
    $('body').on('click', '#editButton', function () {
        var userURL = $(this).data('url');
        $.get(userURL, function (data) {
            $('#editModal').show();
            $('#cat_id_2').val(data.cat_id);
            $('#category_2').val(data.category);
            $('#category_status_2').val(data.category_status);
        })
     });

     $('#updateCategory').click(function() {
        var cat_id = $('#cat_id_2').val();
        var category = $('#category_2').val();
        var category_status = $('#category_status_2').val();
        var _token = $('#_token').val();
        var url = 'update/'+ cat_id;
        // Send form data using ajax
        $.ajax({
            type: 'POST',
            url: url,
            data: {'_token': _token, 'cat_id': cat_id, 'category': category, 'category_status': category_status},
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
