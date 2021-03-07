<template>
    <div class="" id="users">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Пользователи</h1>
                </div>
            </div>
            <div class="table-responsive table-hover">
                <v-app id="bg">
                    <v-card>
                        <v-card-title>
                            <v-flex xs12>
                                <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    hide-details
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-combobox
                                    :items="AllRoles"
                                    label="Роль"
                                    v-model="role"
                                ></v-combobox>
                            </v-flex>
                            <v-flex xs12>
                                <v-combobox
                                    :items="AllCompanies"
                                    label="Компания"
                                    v-model="company"
                                ></v-combobox>
                            </v-flex>
                        </v-card-title>

                        <v-data-table
                            :headers="headers"
                            :items="AllUsers"
                            :search="search"
                            sort-by="login"
                            class="elevation-1"
                        >
                            <template v-slot:top>
                                <v-toolbar
                                    flat
                                >
                                    <v-spacer></v-spacer>
                                    <v-dialog
                                        v-model="dialog"
                                        max-width="500px"
                                    >
                                        <template v-if="can('write')" v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                dark
                                                class="mb-2"
                                                v-bind="attrs"
                                                v-on="on"
                                                icon
                                                color="primary"
                                            >
                                                <i class="fas fa-plus fa-3x" style="color: #6cb2eb"></i>
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">{{ formTitle }}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.surname"
                                                                label="Фамилия"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.name"
                                                                label="Имя"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.middlename"
                                                                label="Отчество"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.login"
                                                                label="Логин"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.email"
                                                                :rules="emailRules"
                                                                label="E-mail"
                                                                required
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.password"
                                                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                                                :rules="[rules.required, rules.min]"
                                                                :type="show1 ? 'text' : 'password'"
                                                                name="input-10-1"
                                                                label="Пароль"
                                                                hint="От 8-ми символов"
                                                                counter
                                                                @click:append="show1 = !show1"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-select
                                                                v-model="editedItem.role"
                                                                label="Роли"
                                                                :items="AllRoles"
                                                                :rules="[rules.required]"
                                                            ></v-select>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-combobox
                                                                v-model="editedItem.company"
                                                                label="Компания"
                                                                :items="AllCompanies"
                                                                :rules="[rules.required]"
                                                            ></v-combobox>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="close"
                                                >
                                                    Отмена
                                                </v-btn>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="save"
                                                >
                                                    Сохранить
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                        <v-card>
                                            <v-card-title class="headline">Вы уверены, что хотите удалить эту запись?</v-card-title>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="closeDelete">Отмена</v-btn>
                                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">ОК</v-btn>
                                                <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialogFail" max-width="500px">
                                        <v-card>
                                            <v-card-title class="headline">Данные не корректны!</v-card-title>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="closeFail">ОК</v-btn>
                                                <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialogFailLogin" max-width="500px">
                                        <v-card>
                                            <v-card-title class="headline">Логин уже есть в системе!</v-card-title>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="closeFail">ОК</v-btn>
                                                <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-toolbar>
                            </template>
                            <template v-if="can('edit')" v-slot:item.actions="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="editItem(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    @click="deleteItem(item)"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                            <template v-slot:no-data>
                                <v-btn
                                    color="primary"
                                    @click="AllUsers"
                                >
                                    Обновить
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        permissions: JSON.parse(userInfo)[0].permissions,
        roles:[],
        companies:[],
        rules: {
            required: value => !!value || 'Required.',
            min: v => v.length >= 8 || 'Min 8 characters',
            emailMatch: () => (`The email and password you entered don't match`),
        },
        show1:false,
        date: new Date().toISOString().substr(0, 10),
        modal: false,
        menu2: false,
        dialog: false,
        dialogDelete: false,
        dialogFail: false,
        dialogFailLogin: false,
        search: '',
        role: '',
        company: '',
        emailRules: [
            v => !!v || 'E-mail не может быть пустым',
            v => /.+@.+/.test(v) || 'Укажите e-mail в нужном формате',
        ],
        editedIndex: -1,
        editedItem: {
            surname: '',
            name: '',
            middlename: '',
            login: '',
            email: '',
            password: '',
            role: '',
            company: '',
        },
        defaultItem: {
            surname: '',
            name: '',
            middlename: '',
            login: '',
            email: '',
            password: '',
            role: '',
            company: '',
        },
    }),

    computed: {
        headers(){
            return [
                { text: '№', align: 'start', value: 'id' },
                { text: 'Фамилия', value: 'surname' },
                { text: 'Имя', value: 'name' },
                { text: 'Отчество', value: 'middlename' },
                { text: 'Логин', value: 'login' },
                { text: 'E-mail', value: 'email' },
                { text: 'Роль', value: 'roles[0].title' , filter: value => {
                        if(value!=undefined && this.role!=undefined){
                            if (!this.role && this.role==='' && this.role===null) return true
                            return value.includes(this.role)
                        }
                    } },
                { text: 'Компания', value: 'company' , filter: value => {
                        if(value!=undefined && this.company!=undefined){
                            if (!this.company && this.company==='' && this.company===null) return true
                            return value.includes(this.company)
                        }
                    } },
                { text: '', value: 'actions', sortable: false },
            ]
        },

        formTitle () {
            return this.editedIndex === -1 ? 'Добавить' : 'Редактировать'
        },
        AllUsers(){
            //console.log(this.$store.getters.allUsers);
            return this.$store.getters.allUsers;
        },
        AllRoles(){
            this.roles.push("");
            let roles_arr = this.$store.getters.allRoles;
            roles_arr.forEach(element => this.roles.push(element.title));
            return this.roles;
        },
        AllCompanies(){
            let companies_arr = this.$store.getters.allUsers;
            companies_arr.forEach(element => this.companies.push(element.company));
            let unique = [...new Set(this.companies)];
            unique.push("");
            this.companies = unique;
            //console.log("this.companies:",this.companies);
            return this.companies;
        }
    },

    async mounted(){
        await this.$store.dispatch("fetchUsers");
        await this.$store.dispatch("fetchRoles");
        await this.$store.dispatch("fetchCompanies");
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    methods: {
        can(permission){
            //console.log("permissions : "+this.permissions);
            if(this.permissions.hasOwnProperty(permission)){
                //console.log(permission+" : "+this.permissions[permission]);
                return this.permissions[permission];
            } else {
                //console.log(permission+" : false (NOT FOUND)");
                return false;
            }
        },

        editItem (item) {
            this.editedIndex = this.AllUsers.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.editedIndex = this.AllUsers.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            let user = this.editedItem;
            this.$store.dispatch("delUser",user);
            this.AllUsers.splice(this.editedIndex, 1);
            this.closeDelete();
            this.$store.dispatch("fetchUsers");
            this.$store.dispatch("fetchRoles");
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeFail(){
            this.dialogFail = false;
            this.dialogFailLogin = false;
        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save () {
            if(this.editedItem.login && this.editedItem.password && this.editedItem.email && this.editedItem.role){

                let foundLogin = -1;

                for(let i = 0; i<this.AllUsers.length; i++){
                    if(this.AllUsers[i].login==this.editedItem.login)
                        foundLogin++;
                }

                let roleId = null;
                for(let i=0; i<this.$store.getters.allRoles.length; i++){
                    if(this.$store.getters.allRoles[i].title==this.editedItem.role){
                        roleId = this.$store.getters.allRoles[i].id;
                    }
                }

                this.editedItem.role = roleId;

                if (this.editedIndex > -1) {
                    //console.log("vue user update:",this.editedItem);
                    this.$store.dispatch("setUser", this.editedItem);
                    Object.assign(this.AllUsers[this.editedIndex], this.editedItem);
                    this.close();
                    this.$store.dispatch("fetchUsers");
                    this.$store.dispatch("fetchRoles");
                } else {
                    if(foundLogin<0){
                        //console.log("vue user create:",this.editedItem);
                        this.$store.dispatch("storeUser",this.editedItem)
                        this.AllUsers.push(this.editedItem);
                        this.close();
                        this.$store.dispatch("fetchUsers");
                        this.$store.dispatch("fetchRoles");
                    } else {
                        this.dialogFailLogin = true;
                    }
                }

            } else {
                this.dialogFail = true;
            }
        },
    }
}
</script>

<style scoped>

</style>
