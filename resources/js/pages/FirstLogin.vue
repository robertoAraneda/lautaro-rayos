<template>
    <div class="d-flex">
        <v-card width="400" class="mx-auto mt-6">
            <v-toolbar color="burdeo" dark>Crear Administrador</v-toolbar>
            <v-card-text class="grey lighten-3">
                <v-container>
                    <v-row class="mt-3">
                        <v-col cols="12">
                            <v-text-field
                                label="Rut*"
                                required
                                placeholder="Usuario"
                                outlined
                                dense
                                color="burdeo"
                                v-model="editedItem.rut"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Nombre*"
                                required
                                placeholder="Nombre"
                                outlined
                                dense
                                color="burdeo"
                                v-model="editedItem.name"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Contraseña*"
                                required
                                placeholder="Contraseña"
                                outlined
                                dense
                                type="password"
                                color="burdeo"
                                v-model="editedItem.password"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn block color="burdeo" dark @click="handleItem"
                    >Crear</v-btn
                >
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import User from '@models/User';
import { mapActions } from 'vuex';

export default {
    data: () => ({
        editedItem: new User(),
        defaultItem: new User(),
    }),
    methods: {
        async handleItem() {
            const { success } = await this.createAdminUser(this.editedItem);
            console.log('this.editedItem', this.editedItem);

            if (success) {
                this.$router.push({ name: 'login' });
            }
        },
        ...mapActions({
            createAdminUser: 'auth/createAdminUser',
        }),
    },
};
</script>

<style lang="scss" scoped></style>
