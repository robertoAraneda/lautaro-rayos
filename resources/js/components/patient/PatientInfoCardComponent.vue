<template>
    <v-card v-if="render">
        <v-card-text>
            <span class="overline burdeo--text font-weight-bold"
                >Datos paciente</span
            >
            <v-row class="text-center mb-3">
                <div class="mx-auto">
                    <v-avatar size="164" tile>
                        <v-icon size="96" color="burdeo">
                            mdi-account-box-outline
                        </v-icon>
                    </v-avatar>
                </div>
                <v-col cols="12" class="mt-n4">
                    <v-list-item>
                        <v-list-item-content class="text-center">
                            <v-list-item-title class="font-weight-bold">
                                {{ patient.names }}
                            </v-list-item-title>
                            <v-list-item-title
                                class="title font-weight-bold mb-1"
                                >{{ patient.lastname }}
                                {{ patient.motherLastname }}</v-list-item-title
                            >
                            <v-list-item-title class="headline mb-3">{{
                                patient.rut
                            }}</v-list-item-title>
                            <v-list-item-title class="text-h6"
                                ><span class="title-patient-card-main"
                                    >BDUP</span
                                ><span class="separator">:</span
                                >{{ patient.bdup }}</v-list-item-title
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-col>
            </v-row>
            <v-divider />
            <v-row>
                <v-col cols="12">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title
                                ><span class="title-patient-card">Edad</span
                                ><span class="separator">:</span
                                >{{
                                    patient.age !== -1
                                        ? patient.age
                                        : 'Sin información'
                                }}</v-list-item-title
                            >
                            <v-list-item-title
                                ><span class="title-patient-card">Teléfono</span
                                ><span class="separator">:</span
                                >{{
                                    patient.phone
                                        ? patient.phone
                                        : 'Sin información'
                                }}</v-list-item-title
                            >
                            <v-list-item-title
                                ><span class="title-patient-card">Email</span
                                ><span class="separator">:</span
                                >{{
                                    patient.email
                                        ? patient.email
                                        : 'Sin información'
                                }}</v-list-item-title
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    props: {
        render: Boolean,
    },
    computed: {
        ...mapGetters({
            patient: 'patient/foundedPatient',
        }),
    },
    methods: {},
};
</script>

<style lang="scss" scoped>
.title-patient-card {
    display: inline-block;
    width: 80px !important;
    font-weight: 700;
}

.title-patient-card-main {
    display: inline-block;
    width: 80px !important;
    font-weight: 700;
}
.separator {
    display: inline-block;
    width: 10px !important;
}
</style>
