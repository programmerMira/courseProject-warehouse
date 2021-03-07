import Vue from 'vue'
import Vuex from 'vuex'
import logs from './parts/logs'
import products from './parts/products'
import providers from './parts/providers'
import transports from "./parts/transports"
import users from "./parts/users"
import cards from "./parts/cards"
import dictionaries from "./parts/dictionaries"
import companies from './parts/companies'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        logs,
        products,
        providers,
        transports,
        users,
        cards,
        dictionaries,
        companies,
    }
})
