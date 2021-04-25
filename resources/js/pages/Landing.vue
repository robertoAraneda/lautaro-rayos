<template>
    <v-container fluid>
        <v-row justify="center">
            <v-col cols="12">
                <v-card max-width="800px" class="mx-auto mt-8">
                    <v-col class="text-center" cols="12">
                        <!--       <h1 class="display-1 font-weight-thin mb-4">
                            Imagenología
                        </h1> -->
                        <v-img
                            :src="imageLab"
                            aspect-ratio="1.7"
                            contain
                        ></v-img>
                        <!--        <h4 class="subheading">
                            Hospital Dr. Abraham Godoy Peña
                        </h4> -->
                    </v-col>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import imageLab from '../assets/fondo_blanco.png';
export default {
    data: () => ({
        imageLab: imageLab,
    }),
    computed: {},
    methods: {},
};
</script>

<style scoped></style>
