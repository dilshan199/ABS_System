$(document).ready(function() {
    $('#findJob').click(function() {
        var job_id = $('#job_id').val();
        var _token = $('#_token').val();

        // Send job id using ajax
        $.ajax({
            type: 'POST',
            url: 'search-by-job',
            data: {'_token': _token, 'job_id': job_id},
            success:function(data){
                location.reload();
            }
        });

    });
});
