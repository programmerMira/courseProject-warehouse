export default {
    actions:{
        async fetchProviders({ commit }) {
            axios.get('/api/providers').then(response => {
                //console.log('store', response.data)
                commit('LoadProviders', response.data)
            });
        },
        delProvider({commit}, provider){
            console.log(provider)
            axios.delete('/providersDelete/'+provider.id).then((response)=>{
                //console.log(response)
                //console.log('deleted');
                commit('deleteProvider', provider)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setProvider({commit}, provider){
            axios.put('/providersUpdate/'+provider.id,{
                title: provider.title,
                phone: provider.phone,
                code: provider.code,
                inn: provider.inn,
                certificateNumber: provider.certificateNumber,
                adress: provider.adress,
            }).then((response)=>{
                commit('updateProvider', provider)
            }).catch((error)=>{
                console.log(error.response.data)
            });
        },
        storeProvider({commit}, provider){
            axios.post('/providerCreate',{
                title: provider.title,
                phone: provider.phone,
                code: provider.code,
                inn: provider.inn,
                certificateNumber: provider.certificateNumber,
                adress: provider.adress,
            }).then(response => {
                //console.log(response)
                commit('createProvider', provider)
            }).catch((error)=>{
                console.log(error.response)
            });
        },
    },
    mutations:{
        LoadProviders(state, providers) {
            state.providers = providers
        },
        deleteProvider(state, provider){
            let index = state.providers.findIndex(provider => provider.id == id)
            state.providers.splice(index, 1);
        },
        updateProvider(state, provider){
            let newProvider = state.providers.find(p => p.id === provider.id)
            newProvider = provider
        },
        createProvider(state, provider){
            //console.log("Create provider", provider);
            let index = state.providers.findIndex(card => provider.id == id)
            state.providers.unshift(index)
        },
    },
    state:{
        providers:[],
    },
    getters:{
        allProviders(state){
            return state.providers
        }
    }
}
