// export function ajax({ url, type, data, dataType }) {
//   return new Promise(function (open, err) {
//     //1. 创建xhr对象
//     var xhr = new XMLHttpRequest();
//     //2.绑定监听事件
//     xhr.onreadystatechange = function () {
//       if (xhr.readyState == 4 && xhr.status == 200) {
//         var res = xhr.responseText;
//         if (dataType === "json")
//           res = JSON.parse(res)
//         open(res);
//       }
//     }
//     if (type == "get" && data != undefined) {
//       url += "?" + data;
//     }
//     //3.打开连接
//     xhr.open(type, url, true);
//     if (type === "post")
//       //设置请求消息头
//       xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     //4.发送请求
//     if (type == "post" && data !== undefined)
//       xhr.send(data);
//     else
//       xhr.send(null);
//   })
// }


/**
 * 封装简单的ajax 函数
 * @param url  请求地址
 * @param method 请求方法 get||post
 * @param async 是否异步 true 异步 || false  同步
 * @param data 发送数据,只支持post方式
 * @param Callback  回调函数(数据,对象)
 * @param type  回调数据类型 text||xml
 */
export function ajax(url, method, async, data, callBack, type) {
  //设置参数默认值
  method = method || "GET";
  method = method.toUpperCase();
  async = async || true;
  data = data || null;
  callBack = callBack || function () {
      console.log("默认回调函数");
  };
  type = type || "xml";
  type = type.toLowerCase();

  var xhr = false;
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
              return callBack(xhr.responseXML, xhr);
          } else if (type == "text") {
              return callBack(xhr.responseText, xhr);
          }
      }
  };

}