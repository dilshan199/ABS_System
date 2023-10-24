function getThisId(job_id){
    var token = $('#_token_2').val();
    var job_id = $('#job_id_' + job_id).val();
    add_quotation(token, job_id);
}

function add_quotation(token, job_id){
    $.ajax({
        url: "get-job/"+job_id,
        method: 'POST',
        data: {'_token': token,'job_id': job_id},
        success: function(data){
            // $('#qty_' + product_id).val(qty);
             window.location.reload();
        }
    });
}
