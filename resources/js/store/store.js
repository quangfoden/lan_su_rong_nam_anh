import { createStore } from 'vuex';
import myModule from './modules/my-store-module';
import Roles from './Modules/roles';
import Permissions from './Modules/permissions';
import Login from './Modules/login';
export const store = createStore({
    modules: {
        Roles,
        Permissions,
        Login,
        myModule,
    },
});
