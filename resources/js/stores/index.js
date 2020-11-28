import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        view_state: 'INIT STATE', //use to force page render
    },
    mutations: {
        updateViewState(state) {
            var d = new Date();
            var time = d.getTime();
            state.view_state = time;
        }
    }
})

export default store