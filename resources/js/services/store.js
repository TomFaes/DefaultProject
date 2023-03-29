import { createStore } from 'vuex'

var localPath = "";
if(import.meta.env.DEV == true){
    localPath = import.meta.env.VITE_APP_URL;
}

export default new createStore({
  state: {
    loggedInUser: '',
    authenticated: false,
    role: '',
    errorMessage: '',
    message: '',
  },


  mutations: {
    setAuthentication(state, status){
        state.authenticated = status;
    },
    setLoggedInUser(state, user){
      state.loggedInUser = user;
    },
    setRole(state, role){
        state.role = role;
    },


    setMessage(state, message){
      state.message = message;
    },
  },

  actions: {
    getLoggedInUser({commit}){
        axios.get( localPath +  '/api/profile')
        .then((response) => {
            commit('setLoggedInUser', response.data.data);
        })
        .catch((error) => console.error(error));
    },

    resetLoggedInUser({commit}){
        commit('setLoggedInUser', '');
        commit('setAuthentication', false);
        commit('setRole', '');
    },

    getMessage({commit}, {message, color = 'green', time = 5000}){
      var response = {};
      response['message'] = message;
      response['color'] = color;
      response['time'] = time;
      commit('setMessage', response);
    },
  },
  getters: {

  }
})
