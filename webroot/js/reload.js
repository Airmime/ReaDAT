function reload() {
    $("#reload_img").show();
    $.ajax({
        type: 'post',
        url: myUrlReload,
        data: {
            reload: true
        },
        dataType: 'html',
        success: function() {
            $("#reload_img").hide();
            $(".refresh").show();
        },
        error : function(){
            $("#reload_img").hide();
        }
    })
}