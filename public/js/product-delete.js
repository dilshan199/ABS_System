$(document).ready(function() {
    // Click delete button
    $('.remove').click(function() {
        // Get entry id after click delete button
        var id = $(this).attr('id');

        // Open confirm dialog
        $('#confirmDialog').show();

        // Path
        var url = 'delete/'+id;

        // Ajax action
        $('#confirm').click(function() {
            $.ajax({
                type: 'GET',
                url: url,
                data: 'p_id='+id,
                success: function(data){
                    alert("Records delete successfully. Record ID:"+id);
                    location.reload();
                },
                error: function(data){
                    alert("Recods not delete. Try again");
                    location.reload();
                }
            });
        });

        // Close model
        $('#cancel').click(function() {
            $('#confirmDialog').hide();
        });

    });
});
