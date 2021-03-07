<template>
    <div class="" id="transport">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Транспорт</h1>
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
                                hide-details
                            ></v-text-field>
                        </v-card-title>

                        <v-data-table
                            :headers="headers"
                            :items="AllTransports"
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
                                                            <v-combobox
                                                                :items="AllTypes"
                                                                v-model="editedItem.typeId"
                                                                label="Тип транспорта"
                                                                :rules="[rules.required]"
                                                            ></v-combobox>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.title"
                                                                label="Транспорт"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.model"
                                                                label="Модель"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.brand"
                                                                label="Бренд"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.color"
                                                                label="Цвет"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.engine_volume"
                                                                label="Мощность двигателя"
                                                                type="number"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-checkbox
                                                                v-model="editedItem.rent"
                                                                label="Аренда"
                                                            ></v-checkbox>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.weight"
                                                                label="Вес"
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
                                                                v-model="editedItem.certificate"
                                                                label="Сертефикат"
                                                                :rules="[rules.required]"
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
                                                                        v-model="editedItem.parseCreationDate"
                                                                        prepend-icon="event"
                                                                        label="Дата выпуска"
                                                                        readonly
                                                                        :rules="[rules.required]"
                                                                        v-on="on"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.parseCreationDate" @input="menu2 = false"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-menu
                                                                v-model="menu"
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
                                                                        v-model="editedItem.parseCommissioningDate"
                                                                        prepend-icon="event"
                                                                        label="Дата начала эксплуатации"
                                                                        readonly
                                                                        :rules="[rules.required]"
                                                                        v-on="on"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.parseCommissioningDate" @input="menu = false"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-menu
                                                                v-model="menu3"
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
                                                                        v-model="editedItem.parseDetailsUpdateDate"
                                                                        prepend-icon="event"
                                                                        label="Дата последнего ремонта"
                                                                        readonly
                                                                        :rules="[rules.required]"
                                                                        v-on="on"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.parseDetailsUpdateDate" @input="menu3 = false"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.number"
                                                                label="Гос.номер"
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
                                                                v-model="editedItem.chassis_engine_number"
                                                                label="№ двигателя"
                                                                :rules="[rules.required]"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col
                                                            cols="12"
                                                            sm="6"
                                                            md="4"
                                                        >
                                                            <v-text-field
                                                                v-model="editedItem.factory_number"
                                                                label="заводской №"
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
                                    <v-dialog
                                        v-model="transportDialog"
                                        max-width="800px"
                                    >
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">Список деталей для транспорта: {{transportTitle}}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-data-table
                                                        :headers="headers2"
                                                        :items="detailCards"
                                                        :items-per-page="5"
                                                    >
                                                        <template v-slot:item="{ item }">
                                                            <tr :style="{'background-color': item.product.qty<1 ? 'red' : item.product.qty<5 ? 'orange' : 'transparent'}">
                                                                <td>{{ item.parseDate }}</td>
                                                                <td>{{ item.document }}</td>
                                                                <td>{{item.product.title}}</td>
                                                                <td>{{item.transport.title}}</td>
                                                                <td>{{item.product.qty}}</td>
                                                                <td>{{item.qty}}</td>
                                                                <td>{{item.unit}}</td>
                                                            </tr>
                                                        </template>
                                                    </v-data-table>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="blue darken-1"
                                                    text
                                                    @click="closeTransportDialog"
                                                >
                                                    Ок
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
                                    @click="watchTransport(item)"
                                >
                                    mdi-wrench
                                </v-icon>
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
                                    @click="AllTransports"
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
        transportDialog: false,
        dialogDelete: false,
        dialogFail: false,
        menu3: false,
        menu2: false,
        menu: false,
        search: '',
        headers: [
            { text: 'Тип транспорта', value: 'typeId'},
            { text: 'Транспорт', value: 'title'},
            { text: 'Модель', value: 'model'},
            { text: 'Бренд', value: 'brand'},
            { text: 'Цвет', value: 'color'},
            { text: 'Можность двигателя', value: 'engine_volume'},
            { text: 'Аренда', value: 'rent'},
            { text: 'Вес', value: 'weight'},
            { text: 'Сертификат', value: 'certificate'},
            { text: 'Дата выпуска', value: 'parseCreationDate'},
            { text: 'Дата начала эксплуатации', value: 'parseCommissioningDate'},
            { text: 'Дата последнего ремонта', value: 'parseDetailsUpdateDate'},
            { text: 'Гос.номер', value: 'number'},
            { text: 'Номер двигателя', value: 'chassis_engine_number'},
            { text: 'Заводской номер', value: 'factory_number'},
            { text: '', value: 'actions', sortable: false},
        ],
        headers2: [
            { text: 'Дата', value: 'parseDate' },
            { text: 'Документ', value: 'document' },
            { text: 'Деталь', value: 'product.title' },
            { text: 'Транспорт', value: 'transport.title' },
            { text: 'Кол-во', value: 'product.qty' },
            { text: 'Списано', value: 'qty' },
            { text: 'Ед.изм.', value: 'unit' },
        ],
        editedIndex: -1,
        editedItem: {
            title: '',
            parseCreationDate:'',
            parseCommissioningDate:'',
            parseDetailsUpdateDate:'',
            number:0,
            typeId:'',
            model: '',
            brand: '',
            color: '',
            engine_volume: 0,
            rent: false,
            weight: 0,
            certificate: '',
            chassis_engine_number: '',
            factory_number: '',
        },
        defaultItem: {
            title: '',
            parseCreationDate:'',
            parseCommissioningDate:'',
            parseDetailsUpdateDate:'',
            number:0,
            typeId:'',
            model: '',
            brand: '',
            color: '',
            engine_volume: 0,
            rent: false,
            weight: 0,
            certificate: '',
            chassis_engine_number: '',
            factory_number: '',
        },
        detailCards:[],
        transport_types:[],
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'Добавить' : 'Редактировать'
        },
        AllTransports(){
            return this.$store.getters.allTransports;
        },
        transportTitle(){
            return this.editedItem.title;
        },
        AllTypes(){
            let types_arr = this.$store.getters.allTransportTypes;
            types_arr.forEach(element => this.transport_types.push(element.title));
            return this.transport_types;
        }
    },

    async mounted(){
        await this.$store.dispatch("fetchTransports");
        await this.$store.dispatch("fetchTransportTypes");
        await this.$store.dispatch("fetchCards");
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
        transportDialog (val) {
            val || this.closeTransportDialog()
        }
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
            this.editedIndex = this.AllTransports.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true;
        },

        watchTransport (item) {
            this.editedIndex = this.AllTransports.indexOf(item)
            this.editedItem = Object.assign({}, item)

            for(let i = 0; i<this.$store.getters.allCards.length; i++){
                if(this.$store.getters.allCards[i].transport.title==item.title){
                    this.detailCards.push(this.$store.getters.allCards[i]);
                }
            }
            console.log("watchTransport",this.detailCards);
            this.transportDialog = true;
        },

        deleteItem (item) {
            this.editedIndex = this.AllTransports.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.$store.dispatch("delTransport",this.editedItem);
            this.AllTransports.splice(this.editedIndex, 1);
            this.closeDelete();
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

        closeTransportDialog(){
            this.transportDialog = false;
            this.detailCards=[];
        },

        save () {
            if (this.editedItem.title && this.editedItem.parseCommissioningDate && this.editedItem.parseCreationDate
                && this.editedItem.parseDetailsUpdateDate && this.editedItem.number && this.editedItem.typeId && this.editedItem.factory_number
                && this.editedItem.chassis_engine_number && this.editedItem.certificate && this.editedItem.weight
                && this.editedItem.engine_volume && this.editedItem.color && this.editedItem.brand && this.editedItem.model) {

                if (this.editedIndex > -1) {

                    this.$store.dispatch('setTransport', this.editedItem);
                    Object.assign(this.AllTransports[this.editedIndex], this.editedItem);
                    this.close();
                    this.$store.dispatch("fetchTransports");

                } else {
                    this.$store.dispatch('storeTransport', this.editedItem);
                    this.AllTransports.push(this.editedItem);
                    this.close();
                    this.$store.dispatch("fetchTransports");
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
