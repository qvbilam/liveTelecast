import { ajax } from './ajax.js';


const baseUrl = 'http://live.qvbilam.xin:9503'
//live
// live/login
export const login = (data, callBack) => ajax(baseUrl + '/index/login/index', 'POST', true, data, callBack, false)
export const sendCode = (data, callBack) => ajax(baseUrl + '/index/send/index', 'POST', true, data, callBack, true)
//live/js/VerToken
export const send = (callBack) => ajax(baseUrl + '/index/send/index', 'POST', true, null, callBack, true, 'json')
//bank/js/user_chat_push 
export const chat = (data, callBack) => ajax(baseUrl + '/index/chat/index', 'POST', true, data, callBack, true)
//live/detail
export const game = (callBack) => ajax(baseUrl + '/index/game/getdata', 'POST', false, null, callBack, true)
//live/perfect
export const editUser = (data, callBack) => ajax(baseUrl + '/index/login/perfect', 'POST', true, data, callBack, true, 'json')

//bank
//bank/index
export const bankBanner = (callBack) => ajax(baseUrl + '/index/bank/banner', 'POST', true, null, callBack, true)
export const bankIndex = (callBack) => ajax(baseUrl + '/index/bank/index', 'POST', true, null, callBack, true)
//bank/detail
export const detail = (data, callBack) => ajax(baseUrl + '/index/bank/detail?' + data, 'GET', true, null, callBack, true)
//bank/fight
export const fight = (data, callBack) => ajax(baseUrl + '/index/bank/fight?' + data, 'GET', true, null, callBack, true)


