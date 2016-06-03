// $(document).on('click','.hashtag-helper', function() {
//
//     var status=$('#status');
//     var str=status.val();
//     var strHelper=str;
//     str=strHelper.substr(0,strHelper.indexOf('#'));
//
//     str=str+$('.hashtag-helper').val();
//     console.log($('.hashtag-helper'));
//     //status.val(str);
// });

$(document).ready(function(){
    var hashed=0;
    var status=$('#status');
    var reply=$('.replier');
    
    reply.keyup(function (e) {
        var str=reply.val();
        var hashtagHelper=$(this);
        if ( str.indexOf("#") >= 0 )  {
            hashed=1;
            var thehashtag=str.substr(str.indexOf('#'));
            var firstspace=thehashtag.indexOf(' ');
            var query=thehashtag.substr(1);
            // if(firstspace<=0){
            //     query=query.substr(0,firstspace);
            // }
            if(query.indexOf(' ')<0){
                $.ajax({
                    url:hashtagUrl,
                    method:'POST',
                    data:{query:query,_token:token},
                    success:function(response){
                        var i=0;
                        $('.hashtag-helper').remove();
                        if(response[0]!=null){
                            while(response[i]){
                                hashtagHelper.after('<span class="help-block hashtag-helper">'+response[i].username+'</span>');
                                i++;
                            }
                        }
                    }
                });
            }
        }
        else {
            $('.hashtag-helper').remove();
            hashed=0;
        }
    });
    status.keyup(function(e){
        var str=status.val();
        var hashtagHelper=status;
        if ( str.indexOf("#") >= 0 )  {
            hashed=1;
            var thehashtag=str.substr(str.indexOf('#'));
            var firstspace=thehashtag.indexOf(' ');
            var query=thehashtag.substr(1);
            // if(firstspace!=null){
            //     query=query.substr(0,firstspace);
            // }
            if(query.indexOf(' ')<0){
                $.ajax({
                    url:hashtagUrl,
                    method:'POST',
                    data:{query:query,_token:token},
                    success:function(response){
                        var i=0;
                        $('.hashtag-helper').hide();
                        if(response[0]!=null){
                            while(response[i]){

                                hashtagHelper.after('<span class="help-block hashtag-helper">'+response[i].username+'</span>');
                                i++;
                            }
                        }
                    }
                });
            }
        }
        else {
            $('.hashtag-helper').hide();
            hashed=0;
        }
    });
});

