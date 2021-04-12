<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="5">
                    <date-picker-component @updateDate="date = $event" />
                </v-col>
                <v-col cols="7">
                    <v-row>
                        <v-col cols="12" class="mt-n1">
                            <p class="body-1 font-weight-bold">
                                Fecha seleccionada:
                                <span class="title">{{ dateReport }}</span>
                            </p>
                        </v-col>
                        <v-col cols="12" class="mt-n6">
                            <base-combobox
                                @updateValue="selected = $event"
                                label="Seleccione tipo de reporte:"
                                :items="typeReports"
                            />
                        </v-col>
                        <v-col cols="12" class="mt-n6">
                            <upload-file-component />
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import BaseCombobox from '@components/base/BaseCombobox.vue';
import DatePickerComponent from './DatePickerComponent.vue';
import UploadFileComponent from './UploadFileComponent.vue';
export default {
    components: { UploadFileComponent, DatePickerComponent, BaseCombobox },
    data: () => ({
        date: '',
        selected: null,
    }),
    created() {
        this.fetchTypeReports();
    },
    computed: {
        ...mapGetters({
            typeReports: 'typeReport/typeReports',
        }),
        dateReport() {
            if (this.date === '') return '';
            let split = this.date.split('-');
            return `${split[2]}-${split[1]}-${split[0]}`;
        },
    },
    methods: {
        ...mapActions({
            fetchTypeReports: 'typeReport/fetchTypeReports',
        }),
    },
};
</script>

<style lang="scss" scoped></style>
