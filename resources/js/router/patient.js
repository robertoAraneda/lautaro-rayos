import Index from '../pages/laboratory/patient/Index.vue';
import FindPatient from '../pages/laboratory/patient/FindPatient.vue';
import CreatePatient from '../pages/laboratory/patient/CreatePatient.vue';

export const patient = [
    {
        path: 'paciente',
        name: 'Index',
        component: Index,
        meta: { requiresAuth: true },
    },
    {
        path: 'paciente/buscar',
        name: 'FindPatient',
        component: FindPatient,
        meta: { requiresAuth: true },
    },
    {
        path: 'paciente/crear',
        name: 'CreatePatient',
        component: CreatePatient,
        meta: { requiresAuth: true },
    },
];
