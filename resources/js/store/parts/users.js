export default {
    actions:{
        async fetchUsers({ commit }) {
            axios.get('/api/usersList').then(response => {
                //console.log('store-users', response.data)
                commit('LoadUsers', response.data)
            });
        },
        async fetchRoles({ commit }) {
            axios.get('/api/roles').then(response => {
                //console.log('store-roles', response.data)
                commit('LoadRoles', response.data)
            });
        },
        delUser({commit}, user){
            //console.log(user)
            axios.delete('/userDelete/'+user.id).then((response)=>{
                //console.log(response)
                //console.log('deleted');
                commit('deleteUser', user)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
        setUser({commit}, user){
            //console.log('setUser:', user);
            axios.put('/userUpdate/'+user.id,{
                surname: user.surname,
                name: user.name,
                middlename: user.middlename,
                login: user.login,
                email: user.email,
                password: user.password,
                role: user.role,
                company: user.company,
            }).then((response)=>{
                commit('updateUser', user)
            }).catch((error)=>{
                console.log(error.response.data)
            });
        },
        storeUser({commit},user){
            console.log('storeUser:',user);
            axios.post('/register',{
                surname: user.surname,
                name: user.name,
                middlename: user.middlename,
                login: user.login,
                email: user.email,
                password: user.password,
                role: user.role,
                company: user.company,
            }).then(response => {
                //console.log("createUser",response,user)
                commit('createUser', user)
            }).catch((error)=>{
                console.log(error.response);
            });
        },
    },
    mutations:{
        LoadUsers(state, users) {
            state.users = users
        },
        LoadRoles(state, roles) {
            state.roles = roles
        },
        deleteUser(state, user){
            let index = state.users.findIndex(user => user.id == id)
            state.users.splice(index, 1);
        },
        updateUser(state, user){
            let newUser = state.users.find(p => p.id === user.id)
            newUser = user
        },
        createUser(state,user){
            //console.log('createUser',user)
            let index = state.users.findIndex(user => user.id == id)
            state.users.unshift(index)
        },
    },
    state:{
        users:[],
        roles:[],
    },
    getters:{
        allUsers(state){
            return state.users
        },
        allRoles(state){
            return state.roles
        },
    }
}
