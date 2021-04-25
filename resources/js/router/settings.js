import SettingEmployee from '../pages/laboratory/settings/User.vue';
import SettingIndex from '../pages/laboratory/settings/Index.vue';
import SettingTypeReport from '../pages/laboratory/settings/TypeReport.vue';
import SettingEstablishment from '../pages/laboratory/settings/Establishment.vue';

export const settings = [
    {
        path: 'configuracion',
        name: 'SettingsIndex',
        component: SettingIndex,
        meta: { requiresAuth: true },
    },
    {
        path: 'configuracion/funcionarios',
        name: 'SettingEmployee',
        component: SettingEmployee,
        meta: { requiresAuth: true },
    },
    {
        path: 'configuracion/tipo-reporte',
        name: 'SettingTypeReport',
        component: SettingTypeReport,
        meta: { requiresAuth: true },
    },
    {
        path: 'configuracion/establecimiento',
        name: 'SettingEstablishment',
        component: SettingEstablishment,
        meta: { requiresAuth: true },
    },
];
