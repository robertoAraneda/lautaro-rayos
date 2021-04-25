<template>
    <div>
        <v-card>
            <v-card-text>
                <span class="overline burdeo--text font-weight-bold"
                    >Buscar paciente</span
                >
                <v-row class="d-flex mt-3">
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
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="d-flex">
                <div class="ml-auto">
                    <v-btn color="secondary" dark @click="clearFields"
                        >Limpiar</v-btn
                    >
                    <v-btn
                        :loading="loadingSearchButton"
                        color="burdeo"
                        dark
                        @click="handleSearch"
                        >Buscar</v-btn
                    >
                </div>
            </v-card-actions>
        </v-card>
        <v-card elevation="0" color="grey lighten-4" class="mt-3">
            <v-row v-if="renderPatientInfoCard">
                <v-col cols="4">
                    <patient-info-card-component
                        :render="renderPatientInfoCard"
                    />
                </v-col>
                <v-col cols="8">
                    <upload-report-component
                        @typeReport="typeReport = $event"
                        @establishment="establishment = $event"
                        @files="files = $event"
                        @date="date = $event"
                    />
                </v-col>
                <v-col cols="12">
                    <v-btn dark color="burdeo" block @click="save"
                        >Guardar reporte del paciente
                    </v-btn>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>
<script>
import TableFoundedPatient from '@components/patient/TableFoundedPatient.vue';
import Patient from '@models/Patient';
import { mapActions, mapGetters } from 'vuex';
import UploadReportComponent from '@components/patient/UploadReportComponent.vue';
import PatientInfoCardComponent from '@components/patient/PatientInfoCardComponent.vue';

export default {
    components: {
        TableFoundedPatient,
        UploadReportComponent,
        PatientInfoCardComponent,
    },
    data: () => ({
        editedItem: new Patient(),
        files: [],
        typeReport: null,
        establishment: null,
        date: null,
        renderPatientInfoCard: false,
        loadingSearchButton: false,
    }),

    computed: {
        ...mapGetters({
            foundedPatients: 'patient/foundedPatients',
            foundedPatient: 'patient/foundedPatient',
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
            findByRut: 'patient/findPatientByRut',
            findByBdup: 'patient/findPatientByBdup',
            storeReport: 'report/postReport',
        }),

        save() {
            this.files.forEach(file => {
                this.storeReport({
                    patient: this.foundedPatient,
                    linkFile: file.url,
                    nameFile: file.name,
                    typeReport: this.typeReport,
                    establishment: this.establishment,
                    dateReport: this.date,
                });
            });

            this.clearFields();
        },
        handleSearch() {
            this.loadingSearchButton = true;
            if (this.rut) {
                this.prepareRut();
                this.findByRut(this.editedItem);
            } else if (this.bdup) {
                this.prepareBdup();
                this.findByBdup(this.editedItem);
            }
            setTimeout(() => {
                this.renderPatientInfoCard = true;
                this.loadingSearchButton = false;
            }, 1000);
        },
        prepareRut() {
            this.editedItem.bdup = '';
        },
        prepareBdup() {
            this.editedItem.rut = '';
        },
        clearFields() {
            this.editedItem.rut = '';
            this.editedItem.bdup = '';
            this.renderPatientInfoCard = false;
        },
    },
};
</script>

<style scoped>
.v-image.v-image__image {
    opacity: 0.2 !important;
}
</style>
