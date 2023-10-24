$(document).ready(function(){
    $('#customer_name').keyup(function () {
        $.ajax({
            type: "POST",
            url: "search-customer",
            data: {"_token": $('#_token_2').val(), "customer_name":$(this).val()},
            // beforeSend: function () {
            //     $('#item').css("background","#fff url(../image/loading.gif) no-repeat 99% 5%");
            // },
            success: function (data) {
                $('#cus-drop-box').show();
                $('#cus-drop-box').html(data);
                $('#customer_name').css("background","#fff");
            }
        });
    });

});

//To select country name
function selectItem(customer_id) {
    $('#customer').val(customer_id);
    $('#cus-drop-box').hide();

    $.ajax({
        type: "GET",
        url: "get-customer/"+customer_id,
        data: "customer_id="+customer_id,
        success: function (result) {
            $('#customer_name').val(result.customer_name);
            $('#customer_id').val(result.customer_id);
            $('#address').val(result.address);
            $('#contact_no').val(result.contact_no);
        }
    });
}
