<template>
    <v-row>
        <v-col cols="12">
            <p class="body-1 font-weight-bold">
                Seleccione fecha del resultado:
            </p>
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
    computed: {},
};
</script>

<style lang="scss" scoped></style>
