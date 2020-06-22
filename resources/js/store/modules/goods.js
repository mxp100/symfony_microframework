const state = {
    goods: [],
};
const getters = {
    GOODS: state => {
        return state.goods;
    }
};
const mutations = {
    SET_GOODS: (state, payload) => {
        state.goods = payload;
    }
};
const actions = {
    GET_GOODS: async (context) => {
        let {data} = await axios.get('/api/goods');
        context.commit('SET_GOODS', data);
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};