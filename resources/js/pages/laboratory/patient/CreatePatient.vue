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
                                <v-text-field
                                    label="Fecha de nacimiento"
                                    required
                                    placeholder="Fecha de nacimiento"
                                    outlined
                                    dense
                                    color="burdeo"
                                    v-model="editedItem.birthDate"
                                >
                                </v-text-field>
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
                    <v-btn text color="secondary" dark>Limpiar</v-btn>
                    <v-btn text color="burdeo" dark @click="handleItem"
                        >Crear</v-btn
                    >
                </div>
            </v-card-actions>
        </v-card>
        <v-card></v-card>
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
    }),
    mounted() {
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
    },
    computed: {
        ...mapGetters({
            foundedPatients: 'patient/foundedPatients',
        }),
    },
    methods: {
        ...mapActions({
            store: 'patient/postPatient',
        }),
        handleItem() {
            if (this.editedIndex === -1) {
                this.store(this.editedItem);
            } else {
                this.update(this.editedItem);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
