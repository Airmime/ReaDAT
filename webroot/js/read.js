function read(all,websites,id,category) {
    if(all == "all"){
        $.ajax({
            type: 'post',
            url: myUrlRead,
            data: {
                all : "all",
                websites : null,
                id : null,
                category : null
            },
            dataType: 'html',
            success: function() {
                $(".unread").hide();
                $("#buttonallread").hide();
                $("#counterread").hide();
            }
        })
    }else{
        if(websites != null){
            $.ajax({
                type: 'post',
                url: myUrlRead,
                data: {
                    all : null,
                    websites : websites,
                    id : null,
                    category : null
                },
                dataType: 'html',
                success: function() {
                    $(".unread").hide();
                    $("#buttonallread").hide();
                    $("#counterread").hide();
                }
            })
        }else{
            if(id != null){
                $.ajax({
                    type: 'post',
                    url: myUrlRead,
                    data: {
                        all : null,
                        websites : null,
                        id: id,
                        category : null
                    },
                    dataType: 'html',
                    success: function() {
                        $("#read"+id).hide();
                    },
                    error : function(){
                        alert('Error :(');
                    }
                })
            }else {
                $.ajax({
                    type: 'post',
                    url: myUrlRead,
                    data: {
                        all : null,
                        websites : null,
                        id: null,
                        category : category
                    },
                    dataType: 'html',
                    success: function() {
                        $(".unread").hide();
                        $("#buttonallread").hide();
                        $("#counterread").hide();
                    },
                    error : function(){
                        alert('Error :(');
                    }
                })
            }
        }
    }
}
