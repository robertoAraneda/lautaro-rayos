<template>
    <div>
        <v-card>
            <v-card-title class="body-1">
                Lista funcionarios
            </v-card-title>
            <v-divider class="pt-1 burdeo" />
            <v-card-text>
                <table-users
                    @createItem="createItem"
                    @editItem="editItem"
                    @deleteItem="deleteItem"
                />
            </v-card-text>
        </v-card>
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
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.rut"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Nombre*"
                                        required
                                        placeholder="Nombre"
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Apellido paterno*"
                                        required
                                        placeholder="pellido paterno"
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.lastname"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Apellido materno*"
                                        required
                                        dense
                                        placeholder="Apellido materno"
                                        outlined
                                        color="burdeo"
                                        v-model="editedItem.motherLastname"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Correo electrónico*"
                                        required
                                        placeholder="Correo electrónico"
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.email"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Teléfono*"
                                        required
                                        dense
                                        placeholder="Teléfono"
                                        outlined
                                        color="burdeo"
                                        v-model="editedItem.phone"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-text-field
                                        label="Contraseña*"
                                        required
                                        placeholder="Contraseña"
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.password"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6" xl="4">
                                    <v-select
                                        v-model="editedItem.role"
                                        :items="roles"
                                        item-text="description"
                                        item-value="id"
                                        label="Rol"
                                        dense
                                        outlined
                                        return-object
                                    >
                                        <template
                                            v-slot:selection="{ item, index }"
                                        >
                                            <v-chip
                                                color="burdeo"
                                                dark
                                                v-if="index === 0"
                                            >
                                                <span>{{
                                                    item.description
                                                }}</span>
                                            </v-chip>
                                        </template>
                                    </v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn color="secondary" @click="closeDialog(dialog)"
                            >Cerrar</v-btn
                        >
                        <v-btn color="burdeo" dark @click="handleItem(dialog)"
                            >Crear</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
        <v-dialog v-model="confirmDeleteDialog" persistent max-width="290">
            <template v-slot:default="dialog">
                <v-card>
                    <v-card-title class="headline">
                        Atención
                    </v-card-title>
                    <v-card-text
                        >¿Está seguro de eliminar el registro?</v-card-text
                    >
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="closeDialog(dialog)"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="handleDeleteItem"
                        >
                            Confirmar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import TableUsers from '../../../components/settings/users/TableUsers.vue';
import User from '../../../models/User';

export default {
    components: { TableUsers },
    data: () => ({
        dialog: false,
        editedItem: new User(),
        defaultItem: new User(),
        editedIndex: -1,
        confirmDeleteDialog: false,
    }),
    mounted() {
        this.getUsers();
        this.getRoles();
    },
    computed: {
        ...mapGetters({
            users: 'user/users',
            roles: 'user/roles',
        }),
    },
    methods: {
        ...mapActions({
            getUsers: 'user/fetchUsers',
            getRoles: 'user/fetchRoles',
            storeUser: 'user/postUser',
            updateUser: 'user/putUser',
            destroyUser: 'user/deleteUser',
        }),
        createItem() {
            this.dialog = true;
        },
        handleItem(dialog) {
            if (this.editedIndex === -1) {
                this.storeUser(this.editedItem);
            } else {
                this.updateUser(this.editedItem);
            }

            this.closeDialog(dialog);
        },
        editItem(item) {
            this.dialog = true;
            this.editedIndex = this.users.indexOf(item);
            this.editedItem = { ...item };
        },
        deleteItem(item) {
            this.editedIndex = this.users.indexOf(item);
            this.editedItem = { ...item };
            this.confirmDeleteDialog = true;
        },
        handleDeleteItem() {
            this.destroyUser(this.editedItem);
            this.$nextTick(() => {
                this.confirmDeleteDialog = false;
                this.clear();
            });
        },
        closeDialog(dialog) {
            dialog.value = false;
            this.$nextTick(() => {
                this.clear();
            });
        },
        clear() {
            this.editedIndex = -1;
            this.editedItem = { ...this.defaultItem };
        },
    },
};
</script>

<style lang="scss" scoped></style>
