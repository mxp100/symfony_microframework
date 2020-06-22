const state = {
    cart: []
};
const getters = {
    CART: state => {
        return state.cart;
    },
    CART_IDS: state => {
        return _.map(state.cart, 'id');
    },
    CART_COUNT: state => {
        return state.cart.length;
    }
};
const mutations = {
    ADD_CART: (state, good) => {
        state.cart.push(good);
    },
    REMOVE_CART: (state, good) => {
        state.cart.splice(state.cart.indexOf(good), 1);
    },
    CLEAR_CART: (state) => {
        state.cart = [];
    }
};
const actions = {
    CART_ADD: (context, good) => {
        context.commit('ADD_CART', good);
    },
    CART_REMOVE: (context, good) => {
        context.commit('REMOVE_CART', good);
    },
    CART_CLEAR: (context) => {
        context.commit('CLEAR_CART');
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};