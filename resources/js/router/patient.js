import Index from '../pages/laboratory/patient/Index.vue';
import FindPatient from '../pages/laboratory/patient/FindPatient.vue';
import CreatePatient from '../pages/laboratory/patient/CreatePatient.vue';
import UploadTest from '../pages/laboratory/patient/UploadTest.vue';

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
    {
        path: 'paciente/adjuntar-examen',
        name: 'UploadTest',
        component: UploadTest,
        meta: { requiresAuth: true },
    },
];
