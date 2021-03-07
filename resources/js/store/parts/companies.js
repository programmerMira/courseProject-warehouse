export default {
    actions:{
        async fetchCompanies({ commit }) {
            axios.get('/api/companies').then(response => {
                //console.log(response.data)
                commit('updateCompanies', response.data)
            });
        },
    },
    mutations:{
        updateCompanies(state, companies) {
            state.companies = companies
        },
    },
    state:{
        companies:[],
    },
    getters:{
        AllCompanies(state){
            return state.companies
        }
    }
}
