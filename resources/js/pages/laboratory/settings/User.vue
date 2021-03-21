<template>
    <div>
        <table-users
            @createItem="createItem"
            @editItem="editItem"
            @deleteItem="deleteItem"
        />
        <v-dialog
            v-model="dialog"
            transition="dialog-bottom-transition"
            max-width="600"
            persistent
        >
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="burdeo" dark>Crear funcionario</v-toolbar>
                    <v-card-text class="grey lighten-3">
                        <v-container>
                            <v-row class="mt-3">
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Rut*"
                                        required
                                        placeholder="Rut"
                                        solo
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Nombre*"
                                        required
                                        placeholder="Nombre"
                                        solo
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Apellido paterno*"
                                        required
                                        placeholder="pellido paterno"
                                        solo
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Apellido materno*"
                                        required
                                        placeholder="Apellido materno"
                                        solo
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Correo electrónico*"
                                        required
                                        placeholder="Correo electrónico"
                                        solo
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Teléfono*"
                                        required
                                        placeholder="Teléfono"
                                        solo
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn color="secondary" @click="closeDialog(dialog)"
                            >Cerrar</v-btn
                        >
                        <v-btn color="burdeo" dark @click="closeDialog(dialog)"
                            >Crear</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import TableUsers from '../../../components/settings/users/TableUsers.vue';
export default {
    components: { TableUsers },
    data: () => ({
        dialog: false,
    }),
    mounted() {
        this.getUsers();
    },
    methods: {
        ...mapActions({
            getUsers: 'user/fetchUsers',
        }),
        createItem() {
            this.dialog = true;
            console.log('creando registro');
        },
        editItem() {
            console.log('editando registro');
        },
        deleteItem() {
            console.log('eliminando registro');
        },
        closeDialog(dialog) {
            dialog.value = false;
        },
    },
};
</script>

<style lang="scss" scoped></style>
