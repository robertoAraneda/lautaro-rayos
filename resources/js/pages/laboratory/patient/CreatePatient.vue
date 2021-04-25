<template>
    <div>
        <v-card>
            <v-card-title class="body-1">
                Crear paciente
            </v-card-title>
            <v-divider class="pt-1 burdeo" />
            <v-card-text>
                <v-row class="d-flex">
                    <v-col class="mx-auto" cols="12">
                        <v-row>
                            <v-col cols="6">
                                <v-text-field
                                    label="Rut"
                                    required
                                    placeholder="Rut"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.rut"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Bdup"
                                    required
                                    placeholder="Bdup"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.bdup"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Nombres"
                                    required
                                    placeholder="Nombres"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.names"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Apellido paterno"
                                    required
                                    placeholder="Apellido paterno"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.lastname"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Apellido materno"
                                    required
                                    placeholder="Apellido materno"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.motherLastname"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-dialog
                                    ref="dialog"
                                    v-model="modal"
                                    :return-value.sync="editedItem.birthDate"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="editedItem.birthDate"
                                            label="Fecha de nacimiento"
                                            placeholder="Fecha de nacimiento"
                                            dense
                                            outlined
                                            color="burdeo"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="editedItem.birthDate"
                                        scrollable
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="burdeo"
                                            @click="modal = false"
                                        >
                                            CANCELAR
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="burdeo"
                                            @click="
                                                $refs.dialog.save(
                                                    editedItem.birthDate
                                                )
                                            "
                                        >
                                            ACEPTAR
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Correo electrónico"
                                    required
                                    placeholder="Correo electrónico"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.email"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Teléfono"
                                    required
                                    placeholder="Teléfono"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.phone"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="d-flex">
                <div class="ml-auto">
                    <v-btn text color="secondary" dark @click="clearFields"
                        >Limpiar</v-btn
                    >
                    <v-btn text color="burdeo" dark @click="handleItem"
                        >Crear</v-btn
                    >
                </div>
            </v-card-actions>
        </v-card>
        <v-snackbar
            :timeout="snackbar.timeout"
            v-model="snackbar.model"
            :color="snackbar.color"
            absolute
            rounded="pill"
            bottom
        >
            {{ snackbar.message }}
        </v-snackbar>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Patient from '../../../models/Patient';
export default {
    data: () => ({
        editedItem: new Patient(),
        defaultItem: new Patient(),
        editedIndex: -1,
        dialog: false,
        confirmDeleteDialog: false,
        modal: false,
        snackbar: {
            model: false,
            color: 'burdeo',
            timeout: 3000,
            message: '',
        },
    }),
    /*     mounted() {
        setTimeout(() => {
            this.editedItem.rut = '15654738-7';
            this.editedItem.bdup = '45678';
            this.editedItem.names = 'roberto alejandro';
            this.editedItem.lastname = 'araneda';
            this.editedItem.motherLastname = 'espinoza';
            this.editedItem.birthDate = '06/12/1983';
            this.editedItem.phone = '+56958639620';
            this.editedItem.email = 'robaraneda@gmail.com';
        }, 1000);
    }, */
    computed: {
        ...mapGetters({
            foundedPatients: 'patient/foundedPatients',
        }),
    },
    methods: {
        ...mapActions({
            store: 'patient/postPatient',
        }),
        async handleItem() {
            if (this.editedIndex === -1) {
                const response = await this.store(this.editedItem);
                this.snackbarResponse(response.success);
            } else {
                const response = await this.update(this.editedItem);
                this.snackbarResponse(response.success);
            }
        },
        clearFields() {
            this.editedItem = { ...this.defaultItem };
        },
        snackbarResponse(status) {
            if (status) {
                this.snackbar = {
                    color: 'success',
                    message: 'Operación realizada con éxito.',
                    model: true,
                };
            } else {
                this.snackbar = {
                    color: 'error',
                    message:
                        'Ha ocurrido un error. No se pudo completar la operación',
                    model: true,
                };
            }
            this.clearFields();
        },
    },
};
</script>

<style lang="scss" scoped></style>
