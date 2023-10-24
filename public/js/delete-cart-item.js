function getThisId(q_id){
    var token = $('#_token_2').val();
    var quotation_id = $('#q_id_' + q_id).val();
    add_quotation(token, quotation_id);
}

function add_quotation(token, quotation_id){
    $.ajax({
        url: "get-quotation/"+quotation_id,
        method: 'POST',
        data: {'_token': token,'quotation_id': quotation_id},
        success: function(data){
            // $('#qty_' + product_id).val(qty);
             window.location.reload();
        }
    });
}
