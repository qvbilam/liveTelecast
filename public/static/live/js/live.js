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
    html = '<div class="frame">'
    html += '<h3 class="frame-header">'
    html += '<i class="icon iconfont icon-shijian"></i>第' + data.type + '节</h3>'
    html += '<div class="frame-item">'
    html += '<span class="frame-dot"></span>'
    html += '<div class="frame-item-author">'
    html += '<img src="./imgs/team1.png" width="20px" height="20px" />'
    html += '马刺次'
    html += '</div>'
    html += '<p>' + data.content + '</p>'
    html += '</div>'
    html += '</div>'

    $('#match-result').prepend(html)


}