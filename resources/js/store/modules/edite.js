export default {

    state: {
        result: null,
    },

    mutations: {
        setResult(state, result) {
            state.result = result;
        },
    },

    actions: {
        update({commit}, data) {
            axios.patch(data.url + data.id, data.value)
                .then(response => {
                    commit('setResult', 'ok');
                }).catch(error => {
                console.log(error.response.data.message)
                    commit('setResult', error.response.data.message);
            });
        },
    },
    getters: {
        result: state => state.result,
    }
};

