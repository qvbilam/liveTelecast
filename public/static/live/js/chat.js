import {Base64} from './base.js'
var WsChatUrl = "ws://39.97.177.28:9504"
var websocketChat = new WebSocket(WsChatUrl);

//链接websock服务
websocketChat.onopen = function (evt) {
    console.log("chat connet success")
    //向服务端发送消息hhhh
}

//接受服务端消息
websocketChat.onmessage = function (evt) {
    //获取服务端传来的数据push
    console.log(evt.data)
    chatPush(evt.data)
}

websocketChat.onclose = function (evt) {
    console.log("cloes")
}

websocketChat.onerror = function (evt, e) {
    console.log(evt.data)
}

function chatPush(data) {
    let res=Base64.decode(data)
    if (!res || typeof res != "string") {
        return false;
    }
    if (typeof res == "string") {
        res = JSON.parse(res)
    }
    // res = JSON.parse(res)
    console.log(res)
    var html = '<div class="comment">'
    html += '<span>' + res.user + '：</span>'
    html += '<span>' + res.content + '</span>'
    html += '</div>'

    $('#comments').append(html)
    setTimeout(() => {
        let comments = document.getElementById('comments')
        comments.scrollTop = comments.scrollHeight
    }, 1)

}
