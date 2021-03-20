import SettingEmployee from '../pages/laboratory/settings/User.vue';
import SettingIndex from '../pages/laboratory/settings/User.vue';

export const settings = [
    {
        path: 'configuracion',
        name: 'Settingsindex',
        component: SettingIndex,
        meta: { requiresAuth: true },
    },
    {
        path: 'configuracion/funcionarios',
        name: 'SettingEmployee',
        component: SettingEmployee,
        meta: { requiresAuth: true },
    },
];
