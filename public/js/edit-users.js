$(document).ready(function() {
    $('body').on('click', '#editButton', function () {
        var userURL = $(this).data('url');
        $.get(userURL, function (data) {
            $('#editModal').show();
            $('#id_2').val(data.id);
            $('#user_name_2').val(data.user_name);
        })
     });

     $('#updateCategory').click(function() {
        var id = $('#id_2').val();
        var user_name = $('#user_name_2').val();
        var _token = $('#_token').val();
        var url = 'update/'+ id;
        // Send form data using ajax
        $.ajax({
            type: 'POST',
            url: url,
            data: {'_token': _token, 'id': id, 'user_name': user_name},
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
