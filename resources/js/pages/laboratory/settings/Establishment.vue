<template>
    <div>
        <v-card>
            <v-card-title class="body-1">
                Lista establecimientos
            </v-card-title>
            <v-divider class="pt-1 burdeo" />
            <v-card-text>
                <table-establishment
                    @createItem="createItem"
                    @editItem="editItem"
                    @deleteItem="deleteItem"
                />
            </v-card-text>
        </v-card>
        <v-dialog
            v-model="dialog"
            transition="dialog-bottom-transition"
            max-width="400"
            persistent
        >
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="burdeo" dark>{{ title }}</v-toolbar>
                    <v-card-text class="grey lighten-3">
                        <v-container>
                            <v-row class="mt-3">
                                <v-col cols="12">
                                    <v-text-field
                                        label="Nombre*"
                                        required
                                        placeholder="Nombre"
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.description"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        label="Nombre corto*"
                                        required
                                        placeholder="Nombre corto"
                                        outlined
                                        dense
                                        color="burdeo"
                                        v-model="editedItem.shortname"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn color="secondary" @click="closeDialog(dialog)"
                            >Cerrar</v-btn
                        >
                        <v-btn
                            color="burdeo"
                            dark
                            @click="handleItem(dialog)"
                            >{{ buttonName }}</v-btn
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
import Establishment from '../../../models/Establishment';
import TableEstablishment from '../../../components/settings/establishments/TableEstablishment.vue';

export default {
    components: { TableEstablishment },
    data: () => ({
        dialog: false,
        editedItem: new Establishment(),
        defaultItem: new Establishment(),
        editedIndex: -1,
        confirmDeleteDialog: false,
    }),
    mounted() {
        this.getEstablishments();
    },
    computed: {
        ...mapGetters({
            establishments: 'establishment/establishments',
        }),
        title() {
            return this.editedIndex === -1
                ? 'Crear nuevo registro'
                : 'Modificar registro';
        },
        buttonName() {
            return this.editedIndex === -1 ? 'Crear' : 'Modificar';
        },
    },
    methods: {
        ...mapActions({
            getEstablishments: 'establishment/fetchEstablishments',
            store: 'establishment/postEstablishment',
            update: 'establishment/putEstablishment',
            destroy: 'establishment/deleteEstablishment',
        }),
        createItem() {
            this.dialog = true;
        },
        handleItem(dialog) {
            if (this.editedIndex === -1) {
                this.store(this.editedItem);
            } else {
                this.update(this.editedItem);
            }

            this.closeDialog(dialog);
        },
        editItem(item) {
            this.dialog = true;
            this.editedIndex = this.establishments.indexOf(item);
            this.editedItem = { ...item };
        },
        deleteItem(item) {
            this.editedIndex = this.establishments.indexOf(item);
            this.editedItem = { ...item };
            this.confirmDeleteDialog = true;
        },
        handleDeleteItem() {
            this.destroy(this.editedItem);
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
