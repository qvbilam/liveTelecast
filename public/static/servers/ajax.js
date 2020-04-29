/**
 * 封装简单的ajax 函数
 * @param url  请求地址
 * @param method 请求方法 get||post
 * @param async 是否异步 true 异步 || false  同步
 * @param data 发送数据,只支持post方式
 * @param Callback  回调函数(数据,对象)
 * @param type  回调数据类型 text||xml
 */
//获取当前的请求地址
const host = window.location.host;
//获取当前协议
const agreement = window.location.protocol;
export function ajax(url, method, async, data, callBack, type, istoken) {
  //设置参数默认值
  method = method || "GET";
  method = method.toUpperCase();
  async = async || true;
  data = data || null;
  callBack = callBack || function () {
    console.log("默认回调函数");
  };
  type = type || "text";
  type = type.toLowerCase();
  istoken = istoken || true
  var xhr = false;
  if (url.indexof('/index/login/index') !== -1) {
    istoken = false
  }
  console.log(istoken, 'istoken')
  if (istoken) {
    var token = localStorage.getItem('token');
    if (token) {
      //请求前判断是否登录
      $.ajax({
        type: "GET",
        contentType: "application/json;charset=UTF-8",
        url: agreement + '//' + host + '/index/token/checkToken',
        data: null,
        beforeSend: function (XMLHttpRequest) {
          XMLHttpRequest.setRequestHeader("AUTHORIZATION", token);
        },
        success: function (result) {
          request(true)
        },
        error: function (e) {
          console.log(e)
          window.location.href = agreement + '//' + host + '/live/login.html'
          return
        }
      });
    } else {
      alert("用户未登录")
      console.log('#########')
      window.location.href = agreement + '//' + host + '/live/login.html'
      return
    }
  } else {
    request()
  }
  function request(header) {
    //初始化XMLHttpRequest 对象
    if (window.XMLHttpRequest) {//Mozilla 浏览器
      xhr = new XMLHttpRequest();
      if (xhr.overrideMimeType) {//设置MiME 类别
        if (type == "text") {
          xhr.overrideMimeType("text/plain");
        } else if (type == "xml") {
          xhr.overrideMimeType("text/xml");
        }
      }
    } else if (window.ActiveXObject) { //IE 浏览器
      try {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        try {
          xhr = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
        }
      }
    }

    //异常，创建对象实例失败
    if (!xhr) {
      console.log("不能创建XMLHttpRequest对象实例.");
      return false;
    }

    xhr.open(method, url, async); //发起请求
    xhr.setRequestHeader("If-Modified-Since", "0"); //每次都是获取最新的内容
    if (header) {
      xhr.setRequestHeader("AUTHORIZATION", token);
    }
    if (method == "POST") { //post
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send(data);
    } else {
      xhr.send(null); //get 不能发送数据
    }

    //指定响应处理函数
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        //成功之后调用回调函数
        if (type == "xml") {
          if (!xhr.responseXML || typeof xhr.responseXML != "string") {
            var res = xhr.responseXML
          }
          if (typeof xhr.responseXML == "string") {
            var res = xhr.responseXML
            res = JSON.parse(res)
          }
          if (res.code == 403) {
            alert(res.msg)
            window.location.href = agreement + '//' + host + '/live/login.html'
          } else if (res.code == -1) {
            alert(res.msg, "token为空")
            console.log("token为空")
            window.location.href = agreement + '//' + host + '/live/login.html'
          } else {
            return callBack(res, xhr);
          }
        } else if (type == "text") {
          if (!xhr.responseText || typeof xhr.responseText != "string") {
            var res = xhr.responseText
          }
          if (typeof xhr.responseText == "string") {
            var res = xhr.responseText
            res = JSON.parse(xhr.responseText)
          }
          if (res.code == 403) {
            alert(res.msg)
            window.location.href = agreement + '//' + host + '/live/login.html'
          } else if (res.code == -1) {
            alert(res.msg, "token为空")
            console.log("token为空")
            window.location.href = agreement + '//' + host + '/live/login.html'
          } else {
            return callBack(res, xhr);
          }
        }
      }
    };
  }

}