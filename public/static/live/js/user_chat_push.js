import { Base64 } from './base.js'
$(function () {
	var $submitBtn = $('#submit-btn');
	// var token = $.cookie('token')
	var token = localStorage.getItem('token')
	console.log(typeof token)
	$('#chatPush').keydown(function (event) {
		var host = window.location.host;
		//获取当前协议
		var agreement = window.location.protocol;
		var send_url = agreement + '//' + host + '/index/chat/index'
		/*回车事件*/
		if (event.keyCode == 13) {
			var text = $(this).val();
			$(this).val('')
			var getData = window.location.search
			var token = localStorage.getItem("token")
			var index = getData.substr(1).lastIndexOf("=");
			var game_id = getData.substring(index + 1, getData.length);
			var data = { 'content': text, 'game_id': game_id }
			console.log(JSON.stringify(data))
			var getdata = Base64.encode(JSON.stringify(data))
			console.log(getdata)
			/*向服务端发送数据*/
			// $.post(send_url, data, function (result) {
			//     /**/
			//
			// }, 'json')

			// chat(data,function(res){
			// 	console.log(res)
			// })
			if (token) {
				$.ajax({
					type: "GET",
					contentType: "application/json;charset=UTF-8",
					url: agreement + '//' + host + '/index/token/checkToken',
					data: null,
					beforeSend: function (XMLHttpRequest) {
						XMLHttpRequest.setRequestHeader("AUTHORIZATION", token);
					},
					success: function (result) {
						$.ajax({
							type: "post",
							url: send_url,
							data: getdata,
							beforeSend: function (XMLHttpRequest) {
								XMLHttpRequest.setRequestHeader("AUTHORIZATION", token);
							},
							success: function (res) {
								var res = Base64.decode(res);
								if (typeof res == "string") {
									if (res && JSON.parse(res).code == 403 || res && JSON.parse(res).code == -1) {
										alert(JSON.parse(res).msg)
										window.location.href = agreement + '//' + host + '/live/login.html'
									}
								}
							}
						});
					},
					error: function (err) {
						alert(err)
						window.location.href = agreement + '//' + host + '/live/login.html'
						return
					}
				});
			} else {
				alert("用户未登录")
				window.location.href = agreement + '//' + host + '/live/login.html'
			}
		}


	})
})
