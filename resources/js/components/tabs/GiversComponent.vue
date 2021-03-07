<template>
    <div class="" id="givers">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Перечень поставщиков</h1>
                </div>
            </div>
            <div class="table-responsive table-hover">
                <v-app id="bg">
                    <v-card>
                        <v-card-title>
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                            ></v-text-field>
                        </v-card-title>

                        <v-data-table
                            :headers="headers"
                            :items="AllProviders"
                            :search="search"
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
                                                        <v-text-field
                                                            v-model="editedItem.title"
                                                            label="Поставщик"
                                                            :rules="[rules.required]"
                                                            class="w-full"
                                                        ></v-text-field>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.phone"
                                                                label="Телефон"
                                                                type="number"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.code"
                                                                label="Код по ЕГРПОУ"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.inn"
                                                                label="ИНН"
                                                                type="number"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.certificateNumber"
                                                                label="№ свид."
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-text-field
                                                            v-model="editedItem.adress"
                                                            label="Адрес"
                                                            :rules="[rules.required]"
                                                            class="w-full"
                                                        ></v-text-field>
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
                                    <v-dialog v-model="dialogFailInn" max-width="500px">
                                        <v-card>
                                            <v-card-title class="headline">ИНН уже есть в системе!</v-card-title>
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
                                    @click="AllProviders"
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
        rules: {
            required: value => !!value || 'Required.',
        },
        dialog: false,
        dialogDelete: false,
        dialogFail: false,
        dialogFailInn: false,
        search: '',
        headers: [
            { text: 'Поставщик', value: 'title' },
            { text: 'Телефон', value: 'phone' },
            { text: 'Код по ЕГРПОУ', value: 'code' },
            { text: 'ИНН', value: 'inn' },
            { text: '№ свид.', value: 'certificateNumber' },
            { text: 'Адрес', value: 'adress' },
            { text: '', value: 'actions', sortable: false },
        ],
        editedIndex: -1,
        editedItem: {
            title: '',
            phone: 0,
            code: 0,
            inn: 0,
            certificateNumber: 0,
            adress: '',
        },
        defaultItem: {
            title: '',
            phone: 0,
            code: 0,
            inn: 0,
            certificateNumber: 0,
            adress: '',
        },
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'Добавить' : 'Редактировать'
        },
        AllProviders(){
            return this.$store.getters.allProviders;
        }
    },

    async mounted(){
        await this.$store.dispatch("fetchProviders");
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
            this.editedIndex = this.AllProviders.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true;
        },

        deleteItem (item) {
            this.editedIndex = this.AllProviders.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.$store.dispatch("delProvider",this.editedItem);
            this.AllProviders.splice(this.editedIndex, 1);
            this.closeDelete();
            this.$store.dispatch("fetchProviders");
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeFail(){
            this.dialogFail = false;
            this.dialogFailInn = false;
        },

        save () {
            if (this.editedItem.title && this.editedItem.adress && this.editedItem.certificateNumber
                && this.editedItem.inn && this.editedItem.code && this.editedItem.phone) {

                let foundInn = -1;
                for(let i = 0; i<this.AllProviders.length; i++){
                    if(this.AllProviders[i].inn == this.editedItem.inn)
                        foundInn++;
                }

                if (this.editedIndex > -1) {

                    this.$store.dispatch('setProvider', this.editedItem);
                    Object.assign(this.AllProviders[this.editedIndex], this.editedItem);
                    this.close();
                    this.$store.dispatch("fetchProviders");

                } else {

                    if(foundInn < 0){
                        this.$store.dispatch('storeProvider', this.editedItem);
                        this.AllProviders.push(this.editedItem);
                        this.close();
                        this.$store.dispatch("fetchProviders");
                    } else {
                        this.dialogFailInn = true;
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
