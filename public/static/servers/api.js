import { ajax } from './ajax.js';
 

export const baseUrl='http://live.qvbilam.xin:9503'

// 用户登录
export const login = (data,callBack) => ajax(baseUrl+'/index/login/index', 'POST', true, data,callBack)
//bank
export const bankBanner =(data,callBack)=> ajax(baseUrl+'/index/bank/banner' ,'POST', true,data,callBack)
export const bankIndex =(data,callBack)=> ajax(baseUrl+'/index/bank/index' ,'POST', true,data,callBack)


 // // var host = window.location.host;
      // //获取当前协议
      // // var agreement = window.location.protocol;
      // // var agreement ='http';
      // // var send_url = agreement + '//' + host + '/index/bank/index'
      // var bankIndex = host + '/index/bank/index'
      // // 提交表单
      // $.ajax({
      //   type: "get",
      //   url: bankIndex,
      //   beforeSend: function (XMLHttpRequest) {
      //     XMLHttpRequest.setRequestHeader("authorization", $.cookie(host));
      //   },
      //   success: function (res) {
      //     console.log(res)
      //     res = JSON.parse(res)
      //     console.log(res.data)
      //     if (res.code != 0) {
      //       alert(res.msg)
      //     } else {
      //       for (var i = 0; i < res.data.length; i++) {
      //         html = '<div class="section">'
      //         html += '<span class="title">' + res.data[i].bank_name + '</span>'
      //         html += '<a  href="' + host + 'bank/detail.html?bank_id=' + res.data[i].bank_id + '" class="more">查看更多</a>'
      //         // html += '<a  href="file:///D:/newFile/直播版块/git版本/liveTelecast/public/static/bank/detail.html?bank_id=' + res.data[i].bank_id + '" class="more">查看更多</a>'
      //         html += '</div>'
      //         html += '<div class="content" id="content' + i + '"></div>'
      //         addBox.append(html)
      //         var addDiv = $('#content' + i);
      //         for (var j = 0; j < res.data[i].data.length; j++) {
      //           html = '<div class="contentItem">'
      //           html += '<a href="' + host + 'bank/fight.html?program_id=' + res.data[i].data[j].id + '">'
      //           html += '<img src="' + res.data[i].data[j].image + '" alt="">'
      //           html += '<div class="contentName">' + res.data[i].data[j].name + '</div>'
      //           html += '<div class="contentTitle">给老子打冲啊冲啊冲啊司马傻逼草你妈的cnm给老子超出超出超出超出</div></a>'
      //           html += '</div>'
      //           addDiv.append(html)
      //         }
      //       }
      //     }
      //   }
      // });