import { createStore } from 'vuex';
import editModule from './modules/edite'
import getModule from './modules/get'

export default createStore({
    modules: {
        edite: editModule,
        get: getModule,
    }
});
