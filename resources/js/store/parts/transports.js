export default {
    actions:{
        async fetchTransports({ commit }) {
            axios.get('/api/transports').then(response => {
                commit('LoadTransports', response.data)
            });
        },
        async fetchTransportTypes({ commit }) {
            axios.get('/api/transportTypes').then(response => {
                commit('LoadTransportTypes', response.data)
            });
        },
        delTransport({ commit }, transport){
            axios.delete('/transportDelete/'+transport.id).then((response)=>{
                commit('deleteTransport', transport)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setTransport({ commit }, transport){
            axios.put('/transportUpdate/'+transport.id,{
                title:transport.title,
                creationDate: transport.parseCreationDate,
                commissioningDate: transport.parseCommissioningDate,
                detailsUpdateDate: transport.parseDetailsUpdateDate,
                number: transport.number,
                typeId: transport.typeId,
                model: transport.model,
                brand: transport.brand,
                color: transport.color,
                engine_volume: transport.engine_volume,
                rent: transport.rent,
                weight: transport.weight,
                certificate: transport.certificate,
                chassis_engine_number: transport.chassis_engine_number,
                factory_number: transport.factory_number,
            }).then(response => {
                commit('updateTransport', transport)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        storeTransport({ commit }, transport){
            axios.post('/transportCreate',{
                title:transport.title,
                creationDate: transport.parseCreationDate,
                commissioningDate: transport.parseCommissioningDate,
                detailsUpdateDate: transport.parseDetailsUpdateDate,
                number: transport.number,
                typeId: transport.typeId,
                model: transport.model,
                brand: transport.brand,
                color: transport.color,
                engine_volume: transport.engine_volume,
                rent: transport.rent,
                weight: transport.weight,
                certificate: transport.certificate,
                chassis_engine_number: transport.chassis_engine_number,
                factory_number: transport.factory_number,
            }).then(response => {
                commit('createTransport', transport)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        LoadTransportTypes(state, types){
            state.transport_types = types;
            console.log("TYPES:",types);
        },
        LoadTransports(state, transports) {
            state.transports = transports;
            for(let i=0; i<state.transports.length;i++){
                if(state.transports[i].transport_type!=null){
                    state.transports[i].typeId = state.transports[i].transport_type.title;
                    //console.log("store-transports:",i,state.transports[i].typeId);
                }
            }
        },
        deleteTransport(state, transport){
            let index = state.transports.findIndex(transport => transport.id == id)
            state.transports.splice(index, 1);
        },
        updateTransport(state, transport){
            let newTransports = state.transports.find(p => p.id === transport.id)
            newTransports = transport
        },
        createTransport(state, transport){
            let index = state.transports.findIndex(transport => transport.id == id)
            state.transports.unshift(index)
        },
    },
    state:{
        transports:[],
        transport_types:[],
    },
    getters:{
        allTransports(state){
            return state.transports
        },
        allTransportTypes(state){
            return state.transport_types
        }
    }
}
