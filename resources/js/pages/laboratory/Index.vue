<template>
    <div>
        <v-navigation-drawer permanent app color="burdeo">
            <div class="white pa-2">
                <v-img :src="imageLab" contain max-height="100"></v-img>
            </div>

            <v-list-item class="white">
                <v-list-item-content>
                    <v-list-item-title v-if="user" class="title text-center">
                        {{ user.name }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider class="grey"></v-divider>

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
                            <v-list-item-title class="body-1">{{
                                link.name
                            }}</v-list-item-title>
                        </v-list-item>
                    </template>
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
                            <v-icon>{{ internalLink.icon }}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <v-container fluid>
            <v-breadcrumbs
                class="white"
                :items="breadcrumbs"
                large
            ></v-breadcrumbs>
            <v-divider class="mb-3 pt-1 verde" />
            <router-view></router-view>
        </v-container>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import imageLab from '../../assets/logo_definitivo.png';
import imageHosp from '../../assets/LOGO_HOSP_LAUTARO_512.png';
export default {
    data: () => ({
        items: [
            {
                name: 'Configuración',
                icon: 'mdi-cog',
                links: [
                    {
                        name: 'Funcionarios',
                        to: { name: 'SettingEmployee' },
                    },
                ],
            },
        ],
        imageLab: imageLab,
        imageHosp: imageHosp,
    }),
    computed: {
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
    },
    methods: {
        capitalizeFirstLetter(string) {
            if (string.includes('-')) {
                string = string.replace('-', ' ');
                console.log(string);
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
