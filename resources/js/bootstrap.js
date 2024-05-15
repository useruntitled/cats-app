import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common["Content-Type"] = "application/json";

// window.axios.interceptors.response.use(
//     response => response,
//     error => {
//         if (error.response?.status === 401 || error.response?.status === 403 || error.response?.status === 419) {
//             if (location.pathname !== '/register'){
//                 location.assign('/register')
//             }
//         }
//
//         return Promise.reject(error)
//     }
// )
