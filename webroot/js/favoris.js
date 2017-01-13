function sendfav(id) {
    $.ajax({
        type: 'post',
        url: myUrlFavorite,
        data: {
            idposts: id
        },
        dataType: 'html',
        success: function() {
            if($("#"+id).attr("src").indexOf("fav_on") >= 0){
                $("#"+id).attr("src", "/Readat/img/content/bloc/post/socialtools/fav_off.png");
            }else{
                $("#"+id).attr("src", "/Readat/img/content/bloc/post/socialtools/fav_on.png");
            }
        }
    })
}