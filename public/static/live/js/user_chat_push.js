// import { chat } from './../../servers/api.js'
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
			console.log(getData);
			var getData = getData.substr(1) //去掉?asd=123前面的问号
			var data = { 'content': text, 'game_id': 1 }
			/*向服务端发送数据*/
			// $.post(send_url, data, function (result) {
			//     /**/
			//
			// }, 'json')

			// chat(data,function(res){
			// 	console.log(res)
			// })
			$.ajax({
				type: "post",
				url: send_url,
				data: data,
				beforeSend: function (XMLHttpRequest) {
					XMLHttpRequest.setRequestHeader("authorization", localStorage.getItem("token"));
				},
				success: function (res) {
					if (typeof res == "string") {
						if (res && JSON.parse(res).code == 403 || res && JSON.parse(res).code == -1) {
							alert(JSON.parse(res).msg)
							window.location.href = agreement + '//' + host + '/live/login.html'
						}
					}
				}
			});
		}


	})
})
