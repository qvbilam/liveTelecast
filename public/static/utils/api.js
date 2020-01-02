import { get, post, patch, put, head } from './axios';
export const baseUrl='http://live.qvbilam.xin:9503'
// 版块首页
export const getBank = (data) => post(baseUrl+'/index/bank/index', data)


