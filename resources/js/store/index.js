import { createStore } from 'vuex'

const store = createStore({
    state: {
        token: null,
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
             localStorage.setItem('token', token);

        },
    },
    actions: {},
    getters: {
        isLoggedIn(state) {
            return !!state.token;
        },

        isUser(state){
            return !!state.user
        }
    },
})

export default store

