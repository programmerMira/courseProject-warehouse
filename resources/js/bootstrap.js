window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import axios from 'axios';
import Vue from 'vue';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
let api_token = document.head.querySelector('meta[name="api-token"]').content;

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
if (api_token!=""){
    localStorage.setItem('store-api-token',JSON.stringify(api_token));
    window.axios.defaults.headers.common['Authorization'] = 'Bearer '+api_token;
} else {
    let store_api_token = JSON.parse(localStorage.getItem('store-api-token'));
    window.axios.defaults.headers.common['Authorization'] = 'Bearer '+store_api_token;
}

/*axios.get('/api/detailCardsByCompany-list').then(response => {
    console.log("AXIOS-GET: ",response.data)
}).catch((error)=>{
    console.log(error.response);
});*/

window.Vue = Vue;
window.userInfo = document.head.querySelector('meta[name="userInfo"]').content;


