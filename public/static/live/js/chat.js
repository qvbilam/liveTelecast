import { Base64 } from './base.js'
var getData = window.location.search
var index = getData.substr(1).lastIndexOf("=");
var game_id = getData.substring(index + 1, getData.length);
game_id = game_id.substr(1)
var WsChatUrl = "ws://39.97.177.28:9504"
var websocketChat = new WebSocket(WsChatUrl);

//链接websock服务
websocketChat.onopen = function (evt) {
    console.log(game_id)
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
    let res = Base64.decode(data)
    if (!res || typeof res != "string") {
        return false;
    }
    if (typeof res == "string") {
        res = JSON.parse(res)
    }
    // res = JSON.parse(res)
    console.log(res)
    if (res.type == "chat" && res.game_id == game_id) {
        var html = '<div class="comment" oncontextmenu = "javascript:showMenu(e);" >'

        if (res.vip == 1) {
            html += '<span class="vip">' + res.user + '：</span>'
        } else {
            html += '<span id="user">' + res.user + '：</span>'
        }
        html += '<span>' + res.content + '</span>'
        html += '</div>'

        $('#comments').append(html)
        setTimeout(() => {
            let comments = document.getElementById('comments')
            comments.scrollTop = comments.scrollHeight
        }, 1)

    }
    var content = $('.comment')
    console.log(content)
}
console.log(window)
function showMenu(e) {
    console.log(e, '!!!!!!!!')
    // var menu = '<div id="menu"><span class="username">' + $("#username").text()
    // menu += '</span><span class="menu">去TA的个人空间</span>'
    // menu += '<span class="menu">屏蔽发送者</span>'
    // menu += '<span class="menu">举报选中弹幕</span>'
    // menu += '</div>'
    // $('#comments').append(menu)
    $('#username').html($("#user").text())
    var menu = document.querySelector("#menu");

    menu.style.left = e.clientX + 'px';
    menu.style.top = e.clientY + 'px';

    menu.style.display = 'block';
}
window.onclick = function (e) {
    document.querySelector('#menu').style.height = 0;
}