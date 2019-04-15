var ajax_host = window.location.host;
//获取当前协议
var ajax_agreement = window.location.protocol;
var ajax_send_url = ajax_agreement + '//' + ajax_host + '/index/send/index'


$.ajax({
    type: "post",
    url: ajax_send_url,
    contentType: "application/json;charset=utf-8",
    dataType: "json",
    beforeSend: function (XMLHttpRequest) {
        XMLHttpRequest.setRequestHeader("authorization", $.cookie(ajax_host));
    },
    success: function (data) {
        console.log(data);
    }, error: function (error) {
        console.log(error);
    }

});