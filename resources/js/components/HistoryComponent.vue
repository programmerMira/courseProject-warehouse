<template>
    <div class="" id="history">
        <div class="container">
            <div class="row mb-5 mt-3">
                <div class="col-6">
                    <h1>История изменений</h1>
                </div>
            </div>
            <div class="table-responsive table-hover">
                <v-app id="bg">
                    <v-card>
                        <v-card-title>
                            <v-flex xs-12>
                                <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    hide-details
                                ></v-text-field>
                            </v-flex>
                        </v-card-title>
                        <v-data-table
                            :headers="headers"
                            :items="AllHistory"
                            :search="search"
                            sort-by="change_date"
                            class="elevation-1"
                        >
                            <template v-slot:no-data>
                                <v-btn
                                    color="primary"
                                    @click="$mount"
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
            { text: '№', value: 'id'},
            { text: 'Пользователь', value: 'user.login'},
            { text: 'Дата', value: 'created_at' },
            { text: 'Изначально', value: 'oldValue' },
            { text: 'Изменено', value: 'newValue' },
        ],
    }),

    computed: mapGetters(["AllHistory"]),
    methods: mapActions(["fetchHistory"]),
    async mounted() {
        await this.fetchHistory();
    }
}
</script>

<style scoped>

</style>
