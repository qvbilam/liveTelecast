import { ajax } from './ajax.js';
 

export const baseUrl='http://live.qvbilam.xin:9503'

// 用户登录
// export const login = (data,dataType) => get(baseUrl+'/index/login/index', data,dataType)
//bank的banner
// export const bankBanner =()=> get(baseUrl+'/index/bank/banner')

export const login = (data) => ajax(baseUrl+'/index/login/index', 'GET', true, data)




// banner
// type: "get",
//         url: bannerIndex,
//         beforeSend: function (XMLHttpRequest) {
//           XMLHttpRequest.setRequestHeader("authorization", $.cookie(host));
//         },