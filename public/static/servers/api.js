import { ajax } from './ajax.js';
 

export const baseUrl='http://live.qvbilam.xin:9503'

// 用户登录
export const login = (data,callBack) => ajax(baseUrl+'/index/login/index', 'POST', true, data,callBack)
// export const sendCode = (data,callBack) => ajax(baseUrl+'/index/send/index', 'POST', true, data,callBack)
//bank
export const bankBanner =(callBack)=> ajax(baseUrl+'/index/bank/banner' ,'POST', true,null,callBack)
export const bankIndex =(callBack)=> ajax(baseUrl+'/index/bank/index' ,'POST', true,null,callBack)
