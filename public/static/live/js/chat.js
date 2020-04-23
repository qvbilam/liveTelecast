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
	var data = JSON.parse(data)
	var html = '<div class="comment">'
	html += '<span>' + data.user + '：</span>'
	html += '<span>' + data.connect + '</span>'
	html += '</div>'

	$('#comments').append(html)
	setTimeout(() => {
		let comments = document.getElementById('comments')
		comments.scrollTop = comments.scrollHeight
	}, 1)

}
