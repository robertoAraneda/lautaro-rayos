<template>
    <v-card v-if="foundedPatients">
        <v-data-table :headers="headers" :items="foundedPatients">
            <template v-slot:item.actions="{ item }">
                <v-tooltip color="verde darken-1" bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn color="verde" icon text v-on="on">
                            <v-icon>
                                mdi-account-search
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Editar</span>
                </v-tooltip>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data: () => ({
        headers: [
            {
                text: 'rut',
                value: 'rut',
            },
            {
                text: 'bdup',
                value: 'bdup',
            },
            {
                text: 'Nombres',
                value: 'names',
            },
            {
                text: 'Apellido paterno',
                value: 'lastname',
            },
            {
                text: 'Apellido materno',
                value: 'motherLastname',
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
            foundedPatients: 'patient/foundedPatients',
        }),
    },
    methods: {
        initialize() {
            const headerLength = this.headers.length;
            for (let index = 0; index < headerLength; index++) {
                Object.assign(this.headers[index], {
                    class: [
                        'grey--text',
                        'text-subtitle-2',
                        'font-weight-bold',
                        'text--darken-3',
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
