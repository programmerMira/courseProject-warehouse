<template>
    <div class="" id="details">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>Движения товара</h1>
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
                            :headers="headers"
                            :items="allProducts"
                            :search="search"
                            item-key="detail_number"
                            sort-by="date"
                            class="elevation-1"
                        >
                           <template v-slot:no-data>
                                <v-btn
                                    color="primary"
                                    @click="allProducts"
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
import { mapGetters, mapActions } from "vuex";
export default {
    data: () => ({
        search: '',
        headers: [
            { text: 'Название з/части', value: 'title' },
            { text: 'Цена за ед.', value: 'price' },
            { text: 'Количество', value: 'qty' },
            { text: 'Списано', value: 'writtenOffQty' }
        ],
    }),

    computed: mapGetters(["allProducts"]),
    methods: mapActions(["fetchProducts"]),
    async mounted() {
        await this.fetchProducts();
    }
}
</script>

<style scoped>

</style>
