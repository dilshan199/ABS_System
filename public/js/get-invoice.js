function getThisId(q_id){
    var token = $('#_token_2').val();
    var invoice_id = $('#q_id_' + q_id).val();
    add_quotation(token, invoice_id);
}

function add_quotation(token, invoice_id){
    $.ajax({
        url: "get-invoice/"+invoice_id,
        method: 'POST',
        data: {'_token': token,'invoice_id': invoice_id},
        success: function(data){
            // $('#qty_' + product_id).val(qty);
             window.location.reload();
        }
    });
}
