<template>
    <div>
        <v-card v-if="foundedPatients">
            <v-data-table :headers="headers" :items="foundedPatients">
                <template v-slot:item.actions="{ item }">
                    <v-tooltip color="verde darken-1" bottom>
                        <template v-slot:activator="{ on }">
                            <v-btn
                                @click="handleSearchedPatient(item)"
                                color="verde"
                                icon
                                text
                                v-on="on"
                            >
                                <v-icon>
                                    mdi-account-search
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Ver</span>
                    </v-tooltip>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card>
                <v-toolbar dark color="burdeo">
                    <v-toolbar-title>Reportes de resultados</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar-items> </v-toolbar
                ><v-card-text class="mt-6">
                    <v-row>
                        <v-col cols="4">
                            <patient-info-card-component
                                :render="renderPatientInfoCard"
                            />
                        </v-col>
                        <v-col cols="8">
                            <v-card>
                                <v-card-text>
                                    <span
                                        class="overline burdeo--text font-weight-bold"
                                        >Reportes</span
                                    >
                                    <table-report-patient class="mt-6" />
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';
import PatientInfoCardComponent from './PatientInfoCardComponent.vue';
import TableReportPatient from './TableReportPatient.vue';
export default {
    components: { PatientInfoCardComponent, TableReportPatient },
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
        dialog: false,
        renderPatientInfoCard: false,
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
        ...mapMutations({
            SET_FOUNDED_PATIENT: 'patient/SET_FOUNDED_PATIENT',
        }),
        ...mapActions({
            findReportsByPatient: 'report/findReportsByPatient',
        }),
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
        async handleSearchedPatient(patient) {
            this.SET_FOUNDED_PATIENT(patient);
            await this.findReportsByPatient(patient);
            this.$nextTick(() => {
                this.renderPatientInfoCard = true;
                this.dialog = true;
            });
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
