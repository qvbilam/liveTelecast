import axios from 'axios'
import QS from 'qs'

axios.defaults.timeout = 10000;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
// XMLHttpRequest.setRequestHeader("authorization", $.cookie(host));
// axios.defaults.headers.common['Authorization'] = ''; // 设置请求头为 Authorization
// http request 拦截器（所有发送的请求都要从这儿过一次），
// 通过这个，就可以把token传到后台，这里是使用sessionStorage来存储token等权限信息和用户信息，
// 若要使用cookie可以封装一个函数并import便可使用
axios.interceptors.request.use(
    config => {
        const token = localStorage.getItem("user") ? JSON.parse(localStorage.getItem("user")).token : '';
        if (token) {
            config.data = config.data ? { ...config.data } : {};
            config.params = config.params ? { ...config.params } : {};
            config.data.token = token;
            config.params.token = token;
        } else {
            if (config.url.indexOf('login') == -1) {
                window.location.href = '/login'
            }
        }
        // console.log(config)
        config.data = QS.stringify(config.data)
        return config;
    },
    err => {
        return Promise.reject(err);
    }
);


// http response 拦截器（所有接收到的请求都要从这儿过一次）
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        return Promise.reject(error.response.data)
    });

export default axios;

/**
 * fetch 请求方法
 * @param url
 * @param params
 * @returns {Promise}
 */
export function get(url, params = {}) {

    return new Promise((resolve, reject) => {
        axios.get(url, {
            params: params
        })
            .then(response => {
                resolve(response.data);
            })
            .catch(err => {
                reject(err)
            })
    })
}

/**
 * post 请求方法
 * @param url
 * @param data
 * @returns {Promise}
 */
export function post(url, data = {}) {
    return new Promise((resolve, reject) => {
        axios.post(url, data)
            .then(response => {
                resolve(response.data);
            }, err => {
                reject(err);
            })
    })
}

/**
 * head 请求方法
 * @param url
 * @param data
 * @returns {Promise}
 */
export function head(url, params = {}) {
    return new Promise((resolve, reject) => {
        axios.head(url, {
            params: params
        })
            .then(response => {
                resolve(response.data);
            })
            .catch(err => {
                reject(err)
            })
    })
}

/**
 * patch 方法封装
 * @param url
 * @param data
 * @returns {Promise}
 */
export function patch(url, data = {}) {
    return new Promise((resolve, reject) => {
        axios.patch(url, data)
            .then(response => {
                resolve(response.data);
            }, err => {
                reject(err);
            })
    })
}

/**
 * put 方法封装
 * @param url
 * @param data
 * @returns {Promise}
 */
export function put(url, data = {}) {
    return new Promise((resolve, reject) => {
        axios.put(url, data)
            .then(response => {
                resolve(response.data);
            }, err => {
                reject(err);
            })
    })
}