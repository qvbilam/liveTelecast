import { ajax } from './ajax.js';
 

const baseUrl='http://live.qvbilam.xin:9503'
//live
// live/login
export const login = (data,callBack) => ajax(baseUrl+'/index/login/index', 'POST', true, data,callBack)
export const sendCode = (data,callBack) => ajax(baseUrl+'/index/send/index', 'POST', true, data,callBack)
//live/js/VerToken
export const send = (callBack) => ajax(baseUrl+'/index/send/index', 'POST', true, null,callBack,'json')
//bank/js/user_chat_push 
export const chat =(data,callBack)=> ajax(baseUrl+'/index/chat/index' ,'POST', true,data,callBack)
//live/detail
export const game =(callBack)=> ajax(baseUrl+'/index/game/getdata' ,'POST', true,null,callBack)
//live/perfect
export const editUser =(data,callBack)=> ajax(baseUrl+'/index/login/perfect' ,'POST', true,data,callBack,'json')

//bank
//bank/index
export const bankBanner =(callBack)=> ajax(baseUrl+'/index/bank/banner' ,'POST', true,null,callBack)
export const bankIndex =(callBack)=> ajax(baseUrl+'/index/bank/index' ,'POST', true,null,callBack)
//bank/detail
export const detail =(data,callBack)=> ajax(baseUrl+'/index/bank/detail' ,'POST', true,data,callBack)
//bank/fight
export const fight =(data,callBack)=> ajax(baseUrl+'/index/bank/fight' ,'POST', true,data,callBack)


