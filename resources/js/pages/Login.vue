<template>
    <v-container fluid>
        <v-row justify="center">
            <v-col cols="12">
                <v-card max-width="400px" class="mx-auto mt-8">
                    <v-form ref="form">
                        <v-card-text
                            class="headline d-flex justify-center burdeo"
                        >
                            <span class="white--text"> Iniciar sesión</span>
                        </v-card-text>
                        <v-card-text>
                            <v-text-field
                                v-model="userEdited.rut"
                                label="Usuario"
                                type="text"
                                prepend-icon="mdi-account"
                                @input="$v.rut.$touch()"
                                @blur="$v.rut.$touch()"
                                :error-messages="rutErrors"
                                color="burdeo"
                            ></v-text-field>
                            <v-text-field
                                v-model.trim="userEdited.password"
                                label="Contraseña"
                                type="password"
                                prepend-icon="mdi-lock"
                                @input="$v.password.$touch()"
                                @blur="$v.password.$touch()"
                                @keypress.enter="submit"
                                :error-messages="passwordErrors"
                                color="burdeo"
                            ></v-text-field>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                class="ma-2"
                                :loading="isLogin"
                                color="burdeo"
                                dark
                                @click="submit"
                            >
                                Entrar
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar
            :timeout="snackbar.timeout"
            v-model="snackbar.model"
            :color="snackbar.color"
            absolute
            rounded="pill"
            bottom
        >
            {{ snackbar.message }}
        </v-snackbar>
    </v-container>
</template>
<script>
import User from '../models/User';

import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';
import { mapActions, mapGetters } from 'vuex';

export default {
    mixins: [validationMixin],

    validations: {
        password: { required },
        rut: { required },
    },
    data: () => ({
        userEdited: new User(),
        userDefault: new User(),
        snackbar: false,
        timeout: 3000,
        message: '',
        userCurrent: null,
        isLogin: false,
        dialogFirstLogin: false,
        newPassword: '',
        confirmPassword: '',
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmPassword: false,
        dialog: true,
        bearerToken: '',
        loadingButton: false,
        snackbar: {
            model: false,
            color: 'burdeo',
            timeout: 3000,
            message: '',
        },
    }),
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            token: 'auth/token',
        }),

        // ...mapGetters(['user', 'authenticated']),
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) return errors;
            !this.$v.password.required &&
                errors.push('La contraseña es requerida.');
            return errors;
        },
        rutErrors() {
            const errors = [];
            if (!this.$v.rut.$dirty) return errors;
            !this.$v.rut.required && errors.push('El RUT es requerido.');
            return errors;
        },
        rut() {
            return this.userEdited.rut;
        },
        password() {
            return this.userEdited.password;
        },
    },
    methods: {
        ...mapActions({
            login: 'auth/login',
            attempt: 'auth/attempt',
            putUser: 'user/putUser',
        }),
        async submit() {
            this.$v.$touch();
            if (!this.$v.$error) {
                this.isLogin = true;
                const { success, token } = await this.login(this.userEdited);

                setTimeout(async () => {
                    if (success) {
                        const { success } = await this.attempt(token);
                        if (success) {
                            this.isLogin = false;
                            this.$router.push({ name: 'Laboratory' });
                        } else {
                            this.snackbarResponse(success);
                            this.isLogin = false;
                        }
                    } else {
                        this.snackbarResponse(success);
                        this.isLogin = false;
                    }
                }, 2000);
            }
        },

        snackbarResponse(status) {
            if (status) {
                this.snackbar = {
                    color: 'success',
                    message: 'Operación realizada con éxito.',
                    model: true,
                };
            } else {
                this.snackbar = {
                    color: 'error',
                    message:
                        'Ha ocurrido un error. No se ha podido iniciar sesión',
                    model: true,
                };
            }
        },
        clear() {
            this.$v.$reset();
            this.userEdited = Object.assign({}, this.userDefault);
        },
    },
};
</script>

<style scoped></style>
