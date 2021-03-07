require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify';
import store from './store';

Vue.use(Vuetify);

Vue.component('income-component', require('./components/tabs/IncomeComponent.vue').default);
Vue.component('details-component', require('./components/tabs/DetailsComponent.vue').default);
Vue.component('givers-component', require('./components/tabs/GiversComponent.vue').default);
Vue.component('detail-cards-component', require('./components/tabs/DetailCardsComponent.vue').default);
Vue.component('detail-dict-component', require('./components/tabs/DetailDictComponent.vue').default);
Vue.component('users-component', require('./components/tabs/UsersComponent').default);
Vue.component('history-component', require('./components/HistoryComponent.vue').default);
Vue.component('transport-component', require('./components/tabs/Transports.vue').default);

const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    store,
});
