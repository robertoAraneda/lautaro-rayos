<template>
    <v-card>
        <v-card-text>
            <span class="overline burdeo--text font-weight-bold"
                >Subir reportes</span
            >
            <v-row>
                <v-col cols="5">
                    <date-picker-component @updateDate="date = $event" />
                </v-col>
                <v-col cols="7">
                    <v-row>
                        <v-col cols="12">
                            <base-combobox
                                @updateValue="selected = $event"
                                label="Seleccione tipo de reporte:"
                                :items="typeReports"
                                prepend-inner-icon="mdi-filter"
                            />
                        </v-col>
                        <v-col cols="12">
                            <base-combobox
                                class="mt-n6"
                                @updateValue="selectedEstablishment = $event"
                                label="Seleccione establecimiento:"
                                :items="establishments"
                                prepend-inner-icon="mdi-filter"
                            />
                        </v-col>
                        <v-col cols="12" class="mt-n6">
                            <upload-file-component
                                @files="$emit('files', $event)"
                            />
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
        selectedEstablishment: null,
    }),
    created() {
        this.fetchTypeReports();
        this.fetchEstablishments();
    },
    watch: {
        selected() {
            this.$emit('typeReport', this.selected);
        },
        selectedEstablishment() {
            this.$emit('establishment', this.selectedEstablishment);
        },
        date() {
            this.$emit('date', this.date);
        },
    },
    computed: {
        ...mapGetters({
            typeReports: 'typeReport/typeReports',
            establishments: 'establishment/establishments',
        }),
    },
    methods: {
        ...mapActions({
            fetchTypeReports: 'typeReport/fetchTypeReports',
            fetchEstablishments: 'establishment/fetchEstablishments',
        }),
    },
};
</script>

<style lang="scss" scoped></style>
