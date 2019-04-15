var WsUrl = "ws://127.0.0.1:9505"
var websocketLive = new WebSocket(WsUrl);

//链接websock服务
websocketLive.onopen = function (evt) {
    console.log("live connet success")
    //向服务端发送消息hhhh
    // websocket.send('hhhhhh');
}

//接受服务端消息
websocketLive.onmessage = function (evt) {
    //获取服务端传来的数据push
    messagePush(evt.data)
}

websocketLive.onclose = function (evt) {
    console.log("cloes")
}

websocketLive.onerror = function (evt, e) {
    console.log(evt.data)
}


function messagePush(data) {
    data = JSON.parse(data);
    console.log(data)
    console.log(data.type)
    var div_type = '#number_' . data.type
    console.log(div_type)
    if($(div_type).size>0){
        content_html = '<div class="frame-item">'
        content_html += '<span class="frame-dot"></span>'
        content_html += '<div class="frame-item-author">'
        if (data.uimage != null) {
            content_html += '<img src="' + data.u_image + '" width="20px" height="20px"/>'
        }

        if (data.u_name != null) {
            content_html += data.u_name
        } else {
            content_html += '解说员：'
        }
        content_html += '</div>'
        content_html += '<p>' + data.content + '</p>'
        if (data.data.live[i][j].image != null) {
            content_html += '<image width="200px" src="' + data.image + '"/>'
        }
        content_html += '</div>'
        $('#number_' + data.type).append(content_html)
    }else{
        html = '<div class="frame">'
        html += '<h3 class="frame-header">'
        html += '<i class="icon iconfont icon-shijian"></i>第' + data.type + '节</h3>'
        html += '<div class="frame-item">'
        html += '<span class="frame-dot"></span>'
        html += '<div class="frame-item-author">'
        html += '<img src="' + data.u_image + '" width="20px" height="20px" />'
        html += data.u_name
        html += '</div>'
        html += '<p>' + data.content + '</p>'
        html += '<image src="' + data.image + '" style="width: 200px" />'
        html += '</div>'
        html += '</div>'
        $('#match-result').prepend(html)
    }



}