import Dashboard from './components/Dashboard.vue';
import CreateEmails from './components/Create-Emails.vue';
import EmailsHistory from './components/Emails-History.vue';
import CreateReciptients from './components/Create-reciptients.vue';
import ReciptientsAccs from './components/Reciptients-Accs.vue';
import Parametres from './components/Parametres.vue';
import Departments from './components/Departments.vue';
import Roles from './components/Roles.vue';
import EmailDetail from './components/EmailDetail.vue';
import Expediteurs from './components/Expediteurs.vue';

export default [


    {
        path: '/admin',
        name: 'admin.Dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/create-emails',
        name: 'admin.CreateEmails',
        component: CreateEmails,
    },
    {
        path: '/admin/emails-History',
        name: 'admin.EmailsHistory',
        component: EmailsHistory,
    },
    {
        path: '/admin/emails-History/:id',
        name: 'admin.Email',
        component: EmailDetail,
    },
    {
        path: '/admin/create-reciptients',
        name: 'admin.reciptients',
        component: CreateReciptients,
    },
    {
        path: '/admin/reciptients',
        name: 'admin.Reciptients',
        component: ReciptientsAccs,
    },
    {
        path: '/admin/parametres',
        name: 'admin.Parametres',
        component: Parametres,
    },
    {
        path: '/admin/departments',
        name: 'admin.Departments',
        component: Departments,
    },
    {
        path: '/admin/roles',
        name: 'admin.Roles',
        component: Roles,
    },
    {
        path: '/admin/expediteurs',
        name: 'admin.Expediteurs',
        component: Expediteurs,
    },

]
