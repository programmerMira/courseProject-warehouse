<template>
    <div class="" id="deals">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Договоры на услуги</h1>
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
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>

                        <v-data-table
                            v-model="selected"
                            :headers="headers"
                            :items="deals"
                            :search="search"
                            show-select
                            item-key="deal_number"
                            sort-by="date"
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
                                        <template v-slot:activator="{ on, attrs }">
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
                                                                v-model="editedItem.deal_number"
                                                                label="№"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.deal_name"
                                                                label="Договор"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-menu
                                                                v-model="menu2"
                                                                :close-on-content-click="false"
                                                                :nudge-right="40"
                                                                lazy
                                                                transition="scale-transition"
                                                                offset-y
                                                                full-width
                                                                min-width="290px"
                                                            >
                                                                <template v-slot:activator="{ on }">
                                                                    <v-text-field
                                                                        v-model="editedItem.date"
                                                                        prepend-icon="event"
                                                                        label="Дата"
                                                                        readonly
                                                                        v-on="on"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.date" @input="menu2 = false"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-combobox
                                                                v-model="editedItem.customer"
                                                                label="Физ./Юр. лицо"
                                                                :items="givers"
                                                            ></v-combobox>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.amount"
                                                                label="Кол-во товара"
                                                                type="number"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.cost"
                                                                type="number"
                                                                label="Сумма"
                                                            ></v-text-field>
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
                                </v-toolbar>
                            </template>
                            <template v-slot:item.actions="{ item }">
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
                                    @click="initialize"
                                >
                                    Reset
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
// For adding the token to axios header (add this only one time).
const token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

export default {
    data: () => ({
        selected:[],
        givers: [
            'Поставшик 1',
            'Поставшик 2',
            'Поставшик 3',
            'Поставшик 4',
            'Поставшик 5',
        ],
        date: new Date().toISOString().substr(0, 10),
        modal: false,
        menu2: false,
        dialog: false,
        dialogDelete: false,
        search: '',
        headers: [
            {
                text: '№',
                align: 'start',
                value: 'deal_number',
            },
            { text: 'Договор', value: 'deal_name' },
            { text: 'Дата', value: 'date' },
            { text: 'Физ./Юр. лицо', value: 'customer' },
            { text: 'Кол-во товара', value: 'amount' },
            { text: 'Сумма', value: 'cost' },
            { text: 'Actions', value: 'actions', sortable: false },
        ],
        deals: [],
        editedIndex: -1,
        editedItem: {
            deal_number: 0,
            deal_name: '',
            date: '',
            customer: '',
            cost: 0,
        },
        defaultItem: {
            deal_number: 0,
            deal_name: '',
            date: '',
            customer: '',
            cost: 0,
        },
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'Добавить' : 'Редактировать'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    created () {
        this.initialize()
    },

    methods: {
        initialize () {
            /*axios.get('/api/products-list').then(response => {
                console.log(response.data);
                this.deals = response.data;
            });*/
        },

        editItem (item) {
            this.editedIndex = this.deals.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
            console.log(item);
            axios.post('/detailsUpdate', item).then((response)=>{
                console.log(response)
            }).catch((error)=>{
                console.log(error.response.data)
            });
        },

        deleteItem (item) {
            this.editedIndex = this.deals.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            console.log(this.editedIndex);
            console.log(this.editedItem);
            axios.post('/detailsDelete', this.editedItem).then((response)=>{
                console.log(response)
                this.deals.splice(this.editedIndex, 1)
                this.closeDelete()
            }).catch((error)=>{
                console.log(error.response.data)
            });
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

        save () {
            if (this.editedIndex > -1) {
                Object.assign(this.deals[this.editedIndex], this.editedItem)
            } else {
                console.log(this.editedItem);
                /*axios.post('').then(response => {
                    console.log(response.data);
                    this.deals.push(this.editedItem)
                });*/
            }
            this.close()
        },
    },
    mounted() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    }
}
</script>

<style scoped>

</style>
