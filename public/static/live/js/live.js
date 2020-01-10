var WsUrl = "ws://39.97.177.28:9505"
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
    console.log(data.type)
    if ($('#number_' + data.type).length > 0) {
        content_html = '<div class="frame-item">'
        content_html += '<span class="frame-dot"></span>'
        content_html += '<div class="frame-item-author">'
        if (data.u_image != null) {
            content_html += '<img src="' + data.u_image + '" width="20px" height="20px"/>'
        }

        if (data.u_name != null) {
            content_html += data.u_name
        } else {
            content_html += '解说员：'
        }
        content_html += '</div>'
        content_html += '<p>' + data.content + '</p>'
        if (data.image != null) {
            content_html += '<image width="200px" src="' + data.image + '"/>'
        }
        content_html += '</div>'
        $('#number_' + data.type).append(content_html)
        console.log('success')
    } else {
        html = '<div class="frame" id="number_' + data.type + '">'
        html += '<h3 class="frame-header">'
        html += '<i class="icon iconfont icon-shijian"></i>第' + data.type + '节</h3>'
        html += '<div class="frame-item">'
        html += '<span class="frame-dot"></span>'
        html += '<div class="frame-item-author">'
        if (data.u_image != null) {
            html += '<img src="' + data.u_image + '" width="20px" height="20px" />'
        }
        if (data.u_name != null) {
            html += data.u_name
        } else {
            html += '解说员'
        }
        html += '</div>'
        html += '<p>' + data.content + '</p>'
        if (data.image != null) {
            html += '<image src="' + data.image + '" style="width: 200px" />'
        }
        html += '</div>'
        html += '</div>'
        $('#match-result').prepend(html)
        console.log('eles')
    }
        let matchResult = document.getElementById('match-result')
        matchResult.scrollTop = matchResult.scrollHeight
    // setTimeout(function(){
    //     let matchResult = document.getElementById('match-result')
    //     matchResult.scrollTop = matchResult.scrollHeight
    // },1)
}