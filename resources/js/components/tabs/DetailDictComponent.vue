<template>
    <div class="" id="detail_dict">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Справочник по деталям</h1>
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
                                    :items="AllTransports"
                                    label="Транспорт"
                                    v-model="transport"
                                ></v-combobox>
                            </v-flex>
                            <v-flex xs12>
                                <v-combobox
                                    :items="AllProducts"
                                    label="Деталь"
                                    v-model="product"
                                ></v-combobox>
                            </v-flex>
                        </v-card-title>

                        <v-data-table
                            v-model="selected"
                            :headers="headers"
                            :items="AllDicts"
                            :search="search"
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
                                        <template v-if="$can('write')" v-slot:activator="{ on, attrs }">
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
                                                            <v-select
                                                                v-model="editedItem.transportId"
                                                                :items="AllTransports"
                                                                label="Транспорт"
                                                                :rules="[rules.required]"
                                                            ></v-select>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-select
                                                                v-model="editedItem.productId"
                                                                :items="AllProducts"
                                                                label="Деталь"
                                                                :rules="[rules.required]"
                                                            ></v-select>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.qty"
                                                                label="Количество"
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
                                                                v-model="editedItem.unit"
                                                                label="Ед.изм."
                                                                :rules="[rules.required]"
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
                                </v-toolbar>
                            </template>
                            <template v-if="$can('edit')" v-slot:item.actions="{ item }">
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
                                    @click="AllDicts"
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
        selected:[],
        transports: [],
        details: [],
        rules: {
            required: value => !!value || 'Required.',
        },
        dialog: false,
        dialogDelete: false,
        dialogFail: false,
        search: '',
        transport: '',
        product: '',
        editedIndex: -1,
        editedItem: {
            transportId: '',
            productId: '',
            qty: '',
            unit: 'шт.',
        },
        defaultItem: {
            transportId: '',
            productId: '',
            qty: '',
            unit: 'шт.',
        },
    }),

    computed: {
        headers (){
            return [
                { text: 'Наименование транспорта', value: 'transportId', filter: value => {
                        if(value!=undefined && this.transport!=undefined){
                            if (!this.transport && this.transport==='' && this.transport===null) return true
                            return value.includes(this.transport)
                        }
                    } },
                { text: 'Наимменование з/частей', value: 'productId' , filter: value => {
                        if(value!=undefined && this.product!=undefined){
                            if (!this.product && this.product==='' && this.product===null) return true
                            return value.includes(this.product)
                        }
                    } },
                { text: 'Количество', value: 'qty' },
                { text: 'Ед.изм.', value: 'unit' },
                { text: '', value: 'actions', sortable: false },
            ]
        },
        formTitle () {
            return this.editedIndex === -1 ? 'Добавить' : 'Редактировать'
        },
        AllDicts(){
            return this.$store.getters.allDict;
        },
        AllProducts(){
            this.details.push("");
            console.log("transports", this.$store.getters.allProducts);
            let products = this.$store.getters.allProducts;
            products.forEach(element => this.details.push(element.title));
            return this.details;
        },
        AllTransports(){
            this.transports.push("");
            console.log("transports", this.$store.getters.allTransports);
            let transport = this.$store.getters.allTransports;
            transport.forEach(element => this.transports.push(element.title));
            return this.transports;
        }
    },

    async mounted(){
        await this.$store.dispatch("fetchProducts");
        await this.$store.dispatch("fetchDict");
        await this.$store.dispatch("fetchTransports");
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
        $can(permission){
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
            this.editedIndex = this.AllDicts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
            console.log(item);
        },

        deleteItem (item) {
            this.editedIndex = this.AllDicts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.$store.dispatch("delDict",this.editedItem);
            this.AllDicts.splice(this.editedIndex, 1);
            this.closeDelete();
            this.$store.dispatch("fetchProducts");
            this.$store.dispatch("fetchDict");
            this.$store.dispatch("fetchTransports");
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
        },

        save () {
            if (this.editedItem.transportId && this.editedItem.productId
                && this.editedItem.qty && this.editedItem.unit){

                if (this.editedIndex > -1) {
                    this.$store.dispatch('setDict', this.editedItem);
                    Object.assign(this.AllDicts[this.editedIndex], this.editedItem);
                } else {
                    this.$store.dispatch('storeDict', this.editedItem)
                    this.AllDicts.push(this.editedItem);
                }
                this.close();
                this.$store.dispatch("fetchProducts");
                this.$store.dispatch("fetchDict");
                this.$store.dispatch("fetchTransports");

            } else {
                this.dialogFail = true;
            }
        },
    }
}
</script>

<style scoped>

</style>
