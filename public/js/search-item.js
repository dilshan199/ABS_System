$(document).ready(function(){
    $('#item').keyup(function () {
        $.ajax({
            type: "POST",
            url: "search-item",
            data: {"_token": $('#_token').val(), "item":$(this).val()},
            // beforeSend: function () {
            //     $('#item').css("background","#fff url(../image/loading.gif) no-repeat 99% 5%");
            // },
            success: function (data) {
                $('#item-drop-box').show();
                $('#item-drop-box').html(data);
                $('#item').css("background","#fff");
            }
        });
    });

});

//To select country name
function selectItem(p_id) {
    $('#item').val(p_id);
    $('#item-drop-box').hide();

    $.ajax({
        type: "GET",
        url: "get-item/"+p_id,
        data: "p_id="+p_id,
        success: function (result) {
            $('#item').val(result.item);
            $('#cat_id').val(result.cat_id);
            $('#amount').val(result.selling_price);
            $('#p_id_2').val(result.p_id);
        }
    });
}
