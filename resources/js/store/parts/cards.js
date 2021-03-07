export default {
    actions:{
        fetchCards({ commit }) {
            axios.get('/api/detailCardsByCompany-list').then(response => {
                //console.log('store-cards', response.data)
                commit('LoadCards', response.data)
            });
        },
        fetchTransportCards({ commit }, transport) {
            console.log("transport",transport.title);
            axios.get('/api/detailCards-listByTransport/'+transport.title).then(response => {
                console.log("fetchTransportCards", response.data)
                commit('LoadCardsByTransport', response.data)
            });
        },
        delCard({commit}, card){
            //console.log(card)
            axios.delete('/detailCardsDelete/'+card.id).then((response)=>{
                //console.log(response)
                //console.log('deleted');
                commit('deleteCard', card)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setCard({commit}, card){
            axios.put('/detailCardsUpdate/'+card.id,{
                transportId: card.transportId,
                date: card.parseDate,
                document: card.document,
                productId: card.productId,
                qty: card.qty,
                unit: card.unit,
            }).then((response)=>{
                //console.log('updated')
                commit('updateCard',card)
            }).catch((error)=>{
                console.log(error.response)
            });
        },
        storeCard({commit}, card){
            axios.post('/detailCardCreate',{
                transportId: card.transportId,
                date: card.parseDate,
                document: card.document,
                productId: card.productId,
                qty: card.qty,
                unit: card.unit,
            }).then(response => {
                commit('createCard',card)
            }).catch((error)=>{
                console.log(error.response)
                commit('createError',error)
            });
        },
        destroyErrors({commit}){
            commit('clearError')
        }
    },
    mutations:{
        LoadCards(state, cards) {
            state.cards = cards
            for(let i=0;i<state.cards.length;i++){
                state.cards[i].transportId = state.cards[i].transport.title;
                state.cards[i].productId = state.cards[i].product.title;
                //state.cards[i].date = state.cards[i].product.qty;
            }
            //console.log("load cards",state.cards);
        },
        deleteCard(state, card){
            let index = state.cards.findIndex(card => card.id == id)
            state.cards.splice(index, 1);
        },
        updateCard(state, card){
            let newCard = state.cards.find(p => p.id === card.id)
            newCard = card
        },
        createCard(state, card){
            let index = state.cards.findIndex(card => card.id == id)
            state.cards.unshift(index)
        },
        createError(state, error){
            let index = state.errors.findIndex(card => card.id == id)
            state.errors.unshift(index)
            console.log('error created!')
        },
        clearError(state){
            //state.errors = []
            console.log("Why here");
        },
        LoadCardsByTransport(state, cards){
            state.transport_cards = cards;
            console.log("LoadCardsByTransport",state.transport_cards);
        }
    },
    state:{
        cards:[],
        errors:[],
        transport_cards:[],
    },
    getters:{
        allCards(state){
            return state.cards
        },
        allErrors(state){
            return state.errors
        },
        allTransportCards(state){
            return state.transport_cards;
        }
    }
}
