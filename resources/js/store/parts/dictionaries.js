export default {
    actions:{
        async fetchDict({ commit }) {
            axios.get('/api/detailDictionaries-list').then(response => {
                //console.log('store-dict', response.data)
                commit('LoadDict', response.data)
            });
        },
        delDict({commit}, dict){
            console.log(dict)
            axios.delete('/detailDictionaryDelete/'+dict.id).then((response)=>{
                //console.log(response)
                //console.log('deleted');
                commit('deleteDict', dict)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setDict({commit}, dict){
            axios.put('/detailDictionaryUpdate/'+dict.id,{
                transportId: dict.transportId,
                productId: dict.productId,
                qty: dict.qty,
                unit: dict.unit,
            }).then((response)=>{
                commit('updateDict', dict)
            }).catch((error)=>{
                console.log(error.response.data)
            });
        },
        storeDict({commit}, dict){
            axios.post('/detailDictionaryCreate',{
                transportId: dict.transportId,
                productId: dict.productId,
                qty: dict.qty,
                unit: dict.unit,
            }).then(response => {
                commit('createDict', dict)
            }).catch((error)=>{
                console.log(error.response)
            });
        },
    },
    mutations:{
        LoadDict(state, dict) {
            state.dicts = dict;
            for(let i=0;i<state.dicts.length;i++){
                state.dicts[i].transportId = state.dicts[i].transport.title;
                state.dicts[i].productId = state.dicts[i].product.title;
            }
            console.log("load dict",state.dicts);
        },
        deleteDict(state, dict){
            let index = state.dicts.findIndex(dict => dict.id == id)
            state.dicts.splice(index, 1);
        },
        updateDict(state, dict){
            let newdict = state.dicts.find(p => p.id === dict.id)
            newdict = dict
        },
        createDict(state, dict){
            //console.log("Create dict", dict);
            let index = state.dicts.findIndex(dict => dict.id == id)
            state.dicts.unshift(index)
        },
    },
    state:{
        dicts:[],
    },
    getters:{
        allDict(state){
            return state.dicts
        },
    }
}
