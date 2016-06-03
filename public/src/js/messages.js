var username;
function explode(text, max) {
    text = text.replace(/  +/g, " ").replace(/^ /, "").replace(/ $/, "");
    if (typeof text === "undefined") return "";
    if (typeof max === "undefined") max = 15;
    if (text.length <= max) return text;
    var exploded = text.substring(0, max);
    text = text.substring(max);
    if (text.charAt(0) !== " ") {
        while (exploded.charAt(exploded.length - 1) !== " " && exploded.length > 0) {
            text = exploded.charAt(exploded.length - 1) + text;
            exploded = exploded.substring(0, exploded.length - 1);
        }
        if (exploded.length == 0) {
            exploded = text.substring(0, max);
            text = text.substring(max);
        } else {
            exploded = exploded.substring(0, exploded.length - 1);
        }
    } else {
        text = text.substring(1);
    }
    return exploded + "\n" + explode(text);
}

$(document).ready(function(){
    username=$('#username').html();
    pullData();
    $(document).keyup(function(e){
        if(e.keyCode==13){
            sendMessage();
        }
        else{
            //isTyping();
        }
    });
});

function pullData(){
    retrieveChatMessages();
    //retrieveTypingStatus();
    setTimeout(pullData,700);
}

function retrieveChatMessages(){
    $.ajax({
        url: retrieveUrl,
        type:'POST',
        data:{username:username,chatId:chatId,_token:token}
    }).done(function(msg){
        if(msg.length>0){
            var d = new Date();
            var n = d.getHours();
            var b= d.getMinutes();
            var text=explode(msg,15);
            $('#chat-window').append('<br/>' +
                '<div class="retrieved-message">'+text+'</div>' +
                '<div class="usertext-div"><span class="usertext">'+username+'</span>' +
                '<span class="time-span">Time:  '+n+':'+b+'</span></div><hr>');
            var objDiv = document.getElementById("chat-window");
            objDiv.scrollTop = objDiv.scrollHeight;
        }
    });
}

function sendMessage(){
    var txt=$('#text').val();
    var text=explode(txt,15);
    var d = new Date();
    var n = d.getHours();
    var b= d.getMinutes();
    if(text.length>0){
        $('#chat-window').append('<br/>'+
            '<div class="send-message">'+text+'</div>' +
            '<div class="usertext-div1"><span class="usertext1">'+selfUsername+'</span>'+
            '<span class="time-span1">Time: '+n+':'+b+'</span></div><hr>');
        $('#text').val('');
        var objDiv = document.getElementById("chat-window");
        objDiv.scrollTop = objDiv.scrollHeight;
        $.ajax({
            url: sendUrl,
            type:'POST',
            data:{text:text,username:username,chatId:chatId,_token:token},
            success: function(result){
                //notTyping();
            }
        });
    }
}
$('.retrieved-message').click(function () {
    alert("shit");
    $(this).next().animate({height:toggle});
});

$('.send-message').click(function () {
    alert("shit");
    $(this).next().animate({height:toggle});
});


//function notTyping(){
//    $.ajax({
//        url: notTypingUrl,
//        type:'POST',
//        data:{userId:userId,chatId:chatId,_token:token}
//    });
//}
//function isTyping(){
//    $.ajax({
//        url: isTypingUrl,
//        type:'POST',
//        data:{userId:userId,chatId:chatId,_token:token}
//    });
//}
//function retrieveTypingStatus(){
//    $.ajax({
//        url: retrieveTypingUrl,
//        type:'POST',
//        data:{userId:userId,chatId:chatId,_token:token},
//        success: function(result){
//            if(result.length>0){
//
//                $('#typingStatus').val(result+' is typing!');
//            }
//            else {
//                $('#typingStatus').val('');
//            }
//        }
//    });
//}

