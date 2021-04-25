<template>
    <v-data-table
        :headers="headers"
        :items="reports"
        item-key="id"
        sort-by="id"
        group-by="type_report.description"
        class="elevation-1"
        show-group-by
    >
        <template v-slot:group.header="{ group }">
            <v-chip class="ma-2" color="burdeo" label text-color="white">
                <v-icon left>
                    mdi-group
                </v-icon>
                {{ group }}
            </v-chip>
        </template>
        <template v-slot:item.date_report="{ item }">
            {{ item.date_report | formatedDate }}
        </template>
        <template v-slot:item.actions="{ item }">
            <v-tooltip color="verde darken-1" bottom>
                <template v-slot:activator="{ on }">
                    <v-btn
                        @click="handlePrintReport(item)"
                        color="verde"
                        v-on="on"
                        dark
                        outlined
                    >
                        <v-icon left>
                            mdi-file-pdf-box
                        </v-icon>
                        Ver
                    </v-btn>
                </template>
                <span>Ver PDF</span>
            </v-tooltip>
            <v-tooltip color="verde darken-1" bottom>
                <template v-slot:activator="{ on }">
                    <v-btn
                        @click="handleDownloadReport(item)"
                        color="verde"
                        v-on="on"
                        dark
                        outlined
                    >
                        <v-icon left>
                            mdi-download
                        </v-icon>
                        Descargar
                    </v-btn>
                </template>
                <span>Descargar PDF</span>
            </v-tooltip>
        </template>
    </v-data-table>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment';
export default {
    data: () => ({
        headers: [
            {
                text: 'Fecha reporte',
                value: 'date_report',
                groupable: false,
                sortable: true,
            },
            {
                text: 'Archivo',
                value: 'name_file',
                groupable: false,
                sortable: false,
            },
            {
                text: 'Tipo reporte',
                value: 'type_report.description',
            },
            {
                text: 'Establecimiento',
                value: 'establishment.shortname',
                groupable: true,
                sortable: true,
            },
            {
                text: 'Acciones',
                value: 'actions',
                sortable: false,
                groupable: false,
                width: '300',
            },
        ],
    }),
    computed: {
        ...mapGetters({
            reports: 'report/reportsPatient',
        }),
    },
    filters: {
        formatedDate(date) {
            const splitDate = date.split(' ')[0];
            const formatedDate = moment(splitDate);
            console.log(formatedDate);

            return formatedDate.format('DD-MM-YYYY');
        },
    },
    methods: {
        ...mapActions({
            downloadFileReport: 'report/downloadFileReport',
        }),
        async handlePrintReport(report) {
            console.log(report);
            const response = await this.downloadFileReport(report);

            const url = URL.createObjectURL(response.blob);

            const link = document.createElement('a');
            link.href = url;
            // link.setAttribute('download', `${response.filename}`);
            link.setAttribute('target', '_blank');
            link.setAttribute('title', `${response.filename}`);
            document.body.appendChild(link);
            link.click();
            link.remove();
        },
        async handleDownloadReport(report) {
            console.log(report);
            const response = await this.downloadFileReport(report);

            const url = URL.createObjectURL(response.blob);

            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `${response.filename}`);
            document.body.appendChild(link);
            link.click();
            link.remove();
        },
    },
};
</script>

<style lang="scss">
.theme--light.v-data-table .v-row-group__header,
.theme--light.v-data-table .v-row-group__summary {
    background: white !important;
}
</style>
