<template>
    <v-row>
        <v-col cols="12">
            <v-text-field
                label="Fecha reporte"
                color="burdeo"
                v-model="dateReport"
                prepend-inner-icon="mdi-calendar"
                outlined
                dense
                disabled
            />
            <v-date-picker
                class="elevation-2"
                color="burdeo"
                @change="$emit('updateDate', date)"
                v-model="date"
                show-adjacent-months
            ></v-date-picker>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: 'DatePicketComponent',
    data: () => ({
        date: new Date().toISOString().substr(0, 10),
    }),
    computed: {
        dateReport() {
            if (this.date === '') return '';
            let split = this.date.split('-');
            return `${split[2]}-${split[1]}-${split[0]}`;
        },
    },
};
</script>

<style lang="scss" scoped></style>
