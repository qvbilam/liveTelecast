import { ajax } from './ajax.js';


const baseUrl = 'http://live.qvbilam.xin:9503'
//live
// live/login
export const login = (data, callBack) => ajax(baseUrl + '/index/login/index', 'POST', true,false, data, callBack, 'text',false)
export const sendCode = (data, callBack) => ajax(baseUrl + '/index/send/index', 'POST', true,true, data, callBack)
//live/js/VerToken
export const send = (callBack) => ajax(baseUrl + '/index/send/index', 'POST', true,true, null, callBack, 'json')
//bank/js/user_chat_push 
export const chat = (data, callBack) => ajax(baseUrl + '/index/chat/index', 'POST', true, true,data, callBack)
//live/detail
export const game = (data, callBack) => ajax(baseUrl + '/index/game/getdata?' + data, 'GET', true,true, null, callBack)
//live/perfect
export const editUser = (data, callBack) => ajax(baseUrl + '/index/login/perfect?'+data, 'GET', true,true, data, callBack, 'json')

//bank
//bank/index
export const bankBanner = (callBack) => ajax(baseUrl + '/index/bank/banner', 'POST', true,true, null, callBack)
export const bankIndex = (callBack) => ajax(baseUrl + '/index/bank/index', 'POST', true, true,null, callBack)
//bank/detail
export const detail = (data, callBack) => ajax(baseUrl + '/index/bank/detail?' + data, 'GET', true,true, null, callBack)
//bank/fight
export const fight = (data, callBack) => ajax(baseUrl + '/index/bank/fight?' + data, 'GET', true,true, null, callBack)


