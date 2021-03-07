<template>
    <div class="" id="incomes">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Поставки товара</h1>
                </div>
            </div>
            <v-flex style="display:none">
                <v-card>
                    <v-card-title primary-title>
                        <h3>Filters log:</h3>
                    </v-card-title>
                    <ul>
                        search:{{search}}
                    </ul>
                    <ul>
                        waybill:{{waybill}}
                    </ul>
                    <ul>
                        giver:{{giver}}
                    </ul>
                    <ul>
                        warehouse:{{warehouse}}
                    </ul>
                </v-card>
            </v-flex>
            <div class="table-responsive table-hover">
                <v-app id="bg">
                    <v-card>
                        <v-card-title>
                            <v-flex xs12>
                                <v-text-field
                                    append-icon="mdi-magnify"
                                    label="Поиск"
                                    single-line
                                    hide-details
                                    v-model="search"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-combobox
                                    :items="AllWaybills"
                                    label="Накладная"
                                    v-model="waybill"
                                ></v-combobox>
                            </v-flex>
                            <v-flex xs12>
                                <v-combobox
                                    :items="AllProviders"
                                    label="Поставщики"
                                    v-model="giver"
                                ></v-combobox>
                            </v-flex>
                            <v-flex xs12>
                                <v-combobox
                                    :items="AllWarehouses"
                                    label="Склад"
                                    v-model="warehouse"
                                ></v-combobox>
                            </v-flex>
                        </v-card-title>

                        <v-data-table
                            :headers="headers"
                            :items="AllProducts"
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
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-menu
                                                                v-model="dateMenu"
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
                                                                        v-model="editedItem.parseDate"
                                                                        prepend-icon="event"
                                                                        label="Дата"
                                                                        readonly
                                                                        v-on="on"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.parseDate" @input="dateMenu = false"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.title"
                                                                label="Товар"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.qty"
                                                                type="number"
                                                                label="Количество"
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
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.price"
                                                                label="Цена за ед."
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
                                                                v-model="editedItem.vendorCode"
                                                                label="Код"
                                                                type="text"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-select
                                                                v-model="editedItem.providerId"
                                                                :items="AllProviders"
                                                                label="Поставщик"
                                                                :rules="[rules.required]"
                                                            ></v-select>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-combobox
                                                                v-model="editedItem.waybillTitle"
                                                                :items="AllWaybills"
                                                                label="Накладная"
                                                                :rules="[rules.required]"
                                                            ></v-combobox>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-combobox
                                                                v-model="editedItem.warehouseTitle"
                                                                :items="AllWarehouses"
                                                                label="Склад"
                                                                :rules="[rules.required]"
                                                            ></v-combobox>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-combobox
                                                                v-model="editedItem.contractTitle"
                                                                :items="AllContracts"
                                                                label="Договор"
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
                                    @click="AllProducts"
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
var formated_date = new Date();
export default {
    data: () => ({
        permissions: JSON.parse(userInfo)[0].permissions,
        givers:[],
        transports: [],
        contracts: [],
        warehouses:[],
        waybills:[],
        date: new Date().toISOString().substr(0, 10),
        modal: false,
        dateMenu: false,
        rules: {
            required: value => !!value || 'Required.',
        },
        dialog: false,
        dialogDelete: false,
        dialogFail: false,
        search:'',
        warehouse:'',
        giver:'',
        waybill:'',
        editedIndex: -1,
        editedItem: {
            contractTitle:'',
            parseDate: '',
            title: '',
            transport: '',
            vendorCode: '',
            qty: 0,
            unit: 'шт.',
            price: 0.0,
            providerId: '',
            waybillTitle: '',
            warehouseTitle: '',
            snippedUserId: JSON.parse(userInfo)[0].id,
            created_at: formated_date,
        },
        defaultItem: {
            contractTitle:'',
            parseDate: '',
            title: '',
            transport: '',
            vendorCode: 'code',
            qty: 0,
            unit: 'шт.',
            price: 0.0,
            providerId: '',
            waybillTitle: '',
            warehouseTitle: '',
            snippedUserId: JSON.parse(userInfo)[0].id,
            created_at: formated_date,
        },
    }),

    created(){
        //console.log(userInfo);
    },

    mounted() {
        this.$store.dispatch("fetchProducts");
        this.$store.dispatch("fetchProviders");
        this.$store.dispatch("fetchTransports");
    },

    computed: {
        headers () {
            return [
                { text: 'Накладная', align: 'start', value: 'waybillTitle', filter:  value => {
                        if (this.waybill)
                            console.log("this.waybill:",this.waybill);
                            return value.includes(this.waybill)
                        return true
                    }
                },
                { text: 'Дата', value: 'parseDate' },
                { text: 'Товар', value: 'title' },
                { text: 'Код', value: 'vendorCode' },
                //{ text: 'Транспорт', value: 'transport' },
                { text: 'Количество', value: 'qty' },
                { text: 'Ед.изм.', value: 'unit' },
                { text: 'Цена', value: 'price' },
                { text: 'Поставщик', value: 'providerId', filter:  value => {
                        if(value!=undefined && this.giver!=undefined){
                            if (!this.giver && this.giver==='' && this.giver===null) return true
                            return value.includes(this.giver)
                        }
                    }
                },
                { text: 'Договор', value: 'contractTitle' },
                { text: 'Склад', value: 'warehouseTitle' , filter:  value => {
                        if(value!=undefined && this.waybill!=undefined){
                            if (!this.warehouse && this.warehouse==='' && this.warehouse===null) return true
                            return value.includes(this.warehouse)
                        }
                    }},
                //{ text: 'Отгружено', value: 'writtenOffQty'},
                { text: '', value: 'actions', sortable: false },
            ]},
        formTitle () {
            return this.editedIndex === -1 ? 'Добавить' : 'Редактировать'
        },
        AllProducts(){
            return this.$store.getters.allProducts;
        },
        AllProviders(){
            //console.log("providers-HERE:", this.$store.getters.allProviders);
            this.givers=[];
            this.givers.push("");
            let providers = this.$store.getters.allProviders;
            providers.forEach(element => this.givers.push(element.title+" ("+element.inn+")"));
            //console.log("this.givers:",this.givers);
            return this.givers;
        },
        AllTransports(){
            //console.log("transports", this.$store.getters.allTransports);
            this.transports=[];
            this.transports.push("");
            let transport = this.$store.getters.allTransports;
            transport.forEach(element => this.transports.push(element.title));
            return this.transports;
        },
        AllWarehouses(){
            //console.log("warehouse", this.$store.getters.allProducts);
            this.warehouses=[];
            this.warehouses.push("");
            let warehouse = this.$store.getters.allProducts;
            warehouse.forEach(element => this.warehouses.push(element.warehouseTitle));
            return this.warehouses;
        },
        AllContracts(){
            this.contracts=[];
            this.contracts.push("");
            let contracts = this.$store.getters.allProducts;
            contracts.forEach(element => this.contracts.push(element.contractTitle));
            //console.log("contracts", this.contracts);
            return this.contracts;
        },
        AllWaybills(){
            this.waybills=[];
            this.waybills.push("");
            let waybills = this.$store.getters.allProducts;
            waybills.forEach(element => this.waybills.push(element.waybillTitle));
            //console.log("Waybills", this.waybills);
            return this.waybills;
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
            this.editedIndex = this.AllProducts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.editedIndex = this.AllProducts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.$store.dispatch("delProduct",this.editedItem);
            this.AllProducts.splice(this.editedIndex, 1);
            this.closeDelete();
            this.$store.dispatch("fetchProducts");
            this.$store.dispatch("fetchProviders");
            this.$store.dispatch("fetchTransports");
        },

        closeFail(){
            this.dialogFail = false;
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
            if(this.editedItem.title && this.editedItem.parseDate && this.editedItem.qty && this.editedItem.unit
                 && this.editedItem.warehouseTitle && this.editedItem.providerId
                && this.editedItem.price && this.editedItem.vendorCode
                && this.editedItem.contractTitle){

                if (this.editedIndex > -1) {
                    console.log("vue set product", this.editedItem);
                    this.$store.dispatch('setProduct', this.editedItem);
                    Object.assign(this.AllProducts[this.editedIndex], this.editedItem);
                } else {
                    //console.log("vue store product", this.editedItem);
                    this.$store.dispatch('storeProduct', this.editedItem);
                    this.AllProducts.push(this.editedItem);
                }
                this.close();
                this.$store.dispatch("fetchProducts");
                this.$store.dispatch("fetchProviders");
                this.$store.dispatch("fetchTransports");

            } else {
                this.dialogFail = true;
                console.log(this.editedItem)
            }
        },
    }
}
</script>

<style scoped>

</style>
