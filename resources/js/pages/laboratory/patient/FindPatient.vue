<template>
    <div>
        <v-card>
            <v-card-title class="body-1">
                Buscar paciente
            </v-card-title>
            <v-divider class="pt-1 burdeo" />
            <v-card-text>
                <v-row class="d-flex">
                    <v-col class="mx-auto" cols="10">
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
                            <v-col cols="4">
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
                            <v-col cols="4">
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
                            <v-col cols="4">
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
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="d-flex">
                <div class="ml-auto">
                    <v-btn text color="secondary" dark @click="clearFields"
                        >Limpiar</v-btn
                    >
                    <v-btn text color="burdeo" dark @click="handleSearch"
                        >Buscar</v-btn
                    >
                </div>
            </v-card-actions>
        </v-card>
        <v-card class="mt-3">
            <v-card-title class="body-1">
                <v-badge
                    :content="numberOfFindedUsers"
                    :value="numberOfFindedUsers"
                    color="verde"
                    overlap
                >
                    Pacientes encontrados
                    <v-icon color="burdeo" large>
                        mdi-account
                    </v-icon>
                </v-badge>
            </v-card-title>
            <v-divider class="pt-1 burdeo" />
            <v-card-text>
                <table-founded-patient />
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import TableFoundedPatient from '@components/patient/TableFoundedPatient.vue';
import Patient from '@models/Patient';
import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
    components: { TableFoundedPatient },
    data: () => ({
        editedItem: new Patient(),
    }),

    mounted() {
        this.SET_FOUNDED_PATIENTS([]);
    },
    computed: {
        ...mapGetters({
            foundedPatients: 'patient/foundedPatients',
        }),
        rut() {
            return this.editedItem.rut !== '';
        },
        bdup() {
            return this.editedItem.bdup !== '';
        },
        names() {
            return this.editedItem.names !== '';
        },
        lastname() {
            return this.editedItem.lastname !== '';
        },
        motherLastname() {
            return this.editedItem.motherLastname !== '';
        },
        numberOfFindedUsers() {
            return this.foundedPatients.length;
        },
    },
    methods: {
        ...mapActions({
            findByDemographics: 'patient/fetchFoundedPatients',
            findByRut: 'patient/findPatientByRut',
            findByBdup: 'patient/findPatientByBdup',
        }),
        ...mapMutations({
            SET_FOUNDED_PATIENTS: 'patient/SET_FOUNDED_PATIENTS',
        }),
        handleSearch() {
            if (this.rut) {
                this.prepareRut();
                this.findByRut(this.editedItem);
            } else if (this.bdup) {
                this.prepareBdup();
                this.findByBdup(this.editedItem);
            } else {
                this.prepareDemographics();
                this.findByDemographics(this.editedItem);
            }
        },
        prepareRut() {
            this.editedItem.bdup = '';
            this.editedItem.names = '';
            this.editedItem.lastname = '';
            this.editedItem.motherLastname = '';
        },
        prepareBdup() {
            this.editedItem.rut = '';
            this.editedItem.names = '';
            this.editedItem.lastname = '';
            this.editedItem.motherLastname = '';
        },
        prepareDemographics() {
            this.editedItem.bdup = '';
            this.editedItem.rut = '';
        },
        clearFields() {
            this.editedItem.rut = '';
            this.editedItem.bdup = '';
            this.editedItem.names = '';
            this.editedItem.lastname = '';
            this.editedItem.motherLastname = '';
        },
    },
};
</script>

<style lang="scss" scoped></style>
