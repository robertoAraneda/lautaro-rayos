<template>
    <v-card v-if="users">
        <v-data-table :headers="headers" :items="users" :search="search">
            <template v-slot:progress>
                <v-progress-linear
                    color="blueS"
                    :height="3"
                    indeterminate
                ></v-progress-linear>
            </template>
            <template v-slot:top>
                <v-toolbar tile class="mb-1 elevation-0">
                    <v-text-field
                        v-model="search"
                        clearable
                        flat
                        dense
                        solo
                        outlined
                        color="burdeo"
                        hide-details
                        prepend-inner-icon="mdi-magnify"
                        label="Buscar"
                    ></v-text-field>
                    <v-spacer></v-spacer>
                    <v-tooltip color="verde darken-2" bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on" icon @click="createItem">
                                <v-icon color="burdeo" size="36"
                                    >mdi-plus-circle</v-icon
                                >
                            </v-btn>
                        </template>
                        <span>Crear funcionario</span>
                    </v-tooltip>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-tooltip color="verde darken-2" bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon text v-on="on">
                            <v-icon @click.prevent="editItem(item)">
                                mdi-pencil
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Editar</span>
                </v-tooltip>
                <v-tooltip color="verde darken-2" bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon text v-on="on">
                            <v-icon @click.prevent="deleteItem(item)">
                                mdi-delete
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Eliminar</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data: () => ({
        search: '',
        headers: [
            {
                text: '#',
                value: 'id',
            },
            {
                text: 'Nombre',
                value: 'name',
            },
            {
                text: 'Acciones',
                value: 'actions',
                sortable: false,
            },
        ],
    }),
    mounted() {
        this.initialize();
    },
    computed: {
        ...mapGetters({
            users: 'user/users',
        }),
    },
    methods: {
        initialize() {
            const headerLength = this.headers.length;
            for (let index = 0; index < headerLength; index++) {
                Object.assign(this.headers[index], {
                    class: [
                        'redS--text',
                        'text-subtitle-2',
                        'font-weight-bold',
                    ],
                });
            }
        },
        createItem() {
            this.$emit('createItem');
        },
        editItem(item) {
            this.$emit('editItem', item);
        },
        deleteItem(item) {
            this.$emit('deleteItem', item);
        },
    },
};
</script>

<style lang="scss" scoped></style>
