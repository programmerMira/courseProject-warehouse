export default {
    actions:{
        async fetchHistory({ commit }) {
            axios.get('/api/logs').then(response => {
                //console.log(response.data)
                commit('updateHistory', response.data)
            });
        },
    },
    mutations:{
        updateHistory(state, logs) {
            state.history = logs
        },
    },
    state:{
        history:[],
    },
    getters:{
        AllHistory(state){
            return state.history
        }
    }
}
