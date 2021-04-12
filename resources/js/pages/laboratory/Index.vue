<template>
    <div>
        <v-navigation-drawer
            app
            color="burdeo"
            v-model="drawer"
            width="260"
            mobile-breakpoint="960"
            v-bind="$attrs"
        >
            <div class="grey lighten-5 pa-2">
                <v-img :src="imageLab" contain max-height="100"></v-img>
            </div>

            <v-list-item class="burdeo" dark>
                <v-list-item-content>
                    <v-list-item-title v-if="user" class="title text-center">
                        {{ user.name }} {{ user.lastname }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider class="white pt-1"></v-divider>

            <v-list dense nav shaped dark>
                <v-list-group
                    v-for="(link, index) in items"
                    :key="index"
                    no-action
                    :prepend-icon="link.icon"
                    color="white"
                >
                    <template v-slot:activator>
                        <v-list-item>
                            <v-list-item-title class="body-2">{{
                                link.name
                            }}</v-list-item-title>
                        </v-list-item>
                    </template>
                    <v-divider />
                    <v-list-item
                        v-for="internalLink in link.links"
                        :key="internalLink.name"
                        :to="internalLink.to"
                        link
                    >
                        <v-list-item-content>
                            <v-list-item-title class="body-2">{{
                                internalLink.name
                            }}</v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-icon
                            v-if="internalLink.icon !== undefined"
                        >
                            <v-icon small>{{ internalLink.icon }}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <v-container fluid>
            <v-system-bar color="white" class="mb-12">
                <v-breadcrumbs large :items="breadcrumbs"></v-breadcrumbs>
            </v-system-bar>
            <!--        <v-divider class="mb-3 pt-1 verde" /> -->
            <router-view></router-view>
        </v-container>
    </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import imageLab from '../../assets/fondo_blanco.png';
import imageHosp from '../../assets/LOGO_HOSP_LAUTARO_512.png';
export default {
    data: () => ({
        items: [
            {
                name: 'Paciente',
                icon: 'mdi-account',
                links: [
                    {
                        name: 'Buscar paciente',
                        to: { name: 'FindPatient' },
                        icon: 'mdi-account-search',
                    },
                    {
                        name: 'Crear paciente',
                        to: { name: 'CreatePatient' },
                        icon: 'mdi-account-plus',
                    },
                    {
                        name: 'Adjuntar exámenes',
                        to: { name: 'UploadTest' },
                        icon: 'mdi-account-plus',
                    },
                ],
            },
            {
                name: 'Configuración',
                icon: 'mdi-cog',
                links: [
                    {
                        name: 'Funcionarios',
                        to: { name: 'SettingEmployee' },
                        icon: 'mdi-account-group',
                    },
                    {
                        name: 'Tipo reporte',
                        to: { name: 'SettingTypeReport' },
                        icon: 'mdi-file-document-multiple',
                    },
                ],
            },
        ],
        imageLab: imageLab,
        imageHosp: imageHosp,
    }),
    computed: {
        ...mapState(['drawer']),
        ...mapGetters({
            user: 'auth/user',
        }),
        breadcrumbs() {
            const routes = this.$route.path;

            const [empty, ...rest] = routes.split('/');

            const bread = [...rest];

            return bread.map((route, index) => {
                return {
                    text: this.capitalizeFirstLetter(route),
                    disabled: index === bread.length - 1,
                };
            });
        },
        drawer: {
            get() {
                return this.$store.state.drawer;
            },
            set(val) {
                this.$store.commit('SET_DRAWER', val);
            },
        },
    },
    methods: {
        capitalizeFirstLetter(string) {
            if (string.includes('-')) {
                string = string.replace('-', ' ');
            }
            if (string.search('gia')) {
                string = string.replace('gia', 'gía');
            }

            if (string.search('dist')) {
                string = string.replace('dist', 'díst');
            }

            if (string.search('cion')) {
                string = string.replace('cion', 'ción');
            }
            if (string.search('cióna')) {
                string = string.replace('cióna', 'ciona');
            }
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
    },
};
</script>

<style lang="scss" scoped></style>
