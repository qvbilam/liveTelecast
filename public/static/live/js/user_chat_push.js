$(function () {
    var $submitBtn = $('#submit-btn');
//获取当前的请求地址
    var host = window.location.host;
//获取当前协议
    var agreement = window.location.protocol;
    var send_url = agreement + '//' + host + '/index/chat/index'
    $('#chatPush').keydown(function (event) {

        /*回车事件*/
        if (event.keyCode == 13) {
            var text = $(this).val();
            $(this).val('')
            var data = {'content': text, 'game_id': 1}
            /*向服务端发送数据*/
            // $.post(send_url, data, function (result) {
            //     /**/
            //
            // }, 'json')

            $.ajax({
                type: "post",
                url: send_url,
                data:data,
                beforeSend: function (XMLHttpRequest) {
                    XMLHttpRequest.setRequestHeader("authorization", $.cookie(host));
                }
            });
        }

    })
})
