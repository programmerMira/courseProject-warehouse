export default {
    actions:{
        async fetchProducts({ commit }) {
            axios.get('/api/productsByCompany-list').then(response => {
                //console.log(response.data)
                commit('LoadProducts', response.data)
            });
        },
        storeProduct({ commit }, product){
            console.log('storeProduct:',product,product.providerId.split('(')[0]);
            axios.post('/productsCreate',{
                contractTitle:product.contractTitle,
                date: product.parseDate,
                title: product.title,
                transport: product.transport,
                vendorCode: product.vendorCode,
                qty: product.qty,
                unit: product.unit,
                price: product.price,
                providerId: product.providerId.split('(')[0],
                waybillTitle: product.waybillTitle,
                warehouseTitle: product.warehouseTitle,
                snippedUserId: product.snippedUserId,
                created_at: product.created_at,
            }).then(response => {
                commit('createProduct', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setProduct({ commit }, product){
            console.log('setProduct:',product,product.providerId.split('(')[0]);
            axios.put('/productsUpdate/'+product.id,{
                contractTitle:product.contractTitle,
                date: product.parseDate,
                title: product.title,
                transport: product.transport,
                vendorCode: product.vendorCode,
                qty: product.qty,
                unit: product.unit,
                price: product.price,
                providerId: product.providerId.split('(')[0],
                waybillTitle: product.waybillTitle,
                warehouseTitle: product.warehouseTitle,
                snippedUserId: product.snippedUserId,
            }).then((response)=>{
                commit('updateOneProduct', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        delProduct({commit}, product){
            console.log(product)
            axios.delete('/productsDelete/'+product.id).then((response)=>{
                //console.log('deleted');
                commit('deleteProduct', product)
            }).catch((error)=>{
                console.log(error.response);
            });
        }
    },
    mutations:{
        LoadProducts(state, products) {
            state.products = products
            for(let i = 0; i<state.products.length; i++){
                state.products[i].providerId = state.products[i].provider.title +" ("+state.products[i].provider.inn+")";
            }
            console.log("store-products",state.products);
        },
        createProduct(state, product){
            let index = state.products.findIndex(product => product.id == id)
            state.products.unshift(index)
        },
        updateOneProduct(state, product){
            let newProduct = state.products.find(p => p.id === product.id)
            newProduct = product
        },
        deleteProduct(state, product){
            let index = state.products.findIndex(product => product.id == id)
            state.products.splice(index, 1);
        }
    },
    state:{
        products:[],
    },
    getters:{
        allProducts(state){
            return state.products
        }
    }
}
