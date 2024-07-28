import Router from '../../router';
import Swal from 'sweetalert2';
import Config from '../../config';

const state = {
    loginResponse: {},
    authUser: {},
};

const getters = {
    getLoginResponse: state => state.loginResponse,
    getAuthUser: state => state.authUser,
};

const actions = {

    login({commit, getters}, loginData) {
        axios.get('/sanctum/csrf-cookie').then(() => {
            axios
                .post('/api/admin/login', {
                    email: loginData.email,
                    password: loginData.password,
                })
                .then(response => {
                    commit('mutateLoginResponse', response.data);
                    localStorage.setItem(
                        'loginResponse',
                        JSON.stringify(response.data)
                    );
                    if (getters.getLoginResponse.response_type === 'success') {
                        axios.get('/api/admin/user').then(response => {
                            if (response.data.status === 200) {
                                commit('mutateAuthUser', response.data.data.user);
                                localStorage.setItem(
                                    'authUser',
                                    JSON.stringify(response.data.data.user)
                                );
                                setTimeout(() => {
                                    initLeftMenu();
                                }, 1);
                                Router.push('/admin');
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `Error ${getters.getLoginResponse.response_data[0]}`,
                            showConfirmButton: false,
                            timer: Config.notificationTimer ?? 1000
                        })
                    }
                });
        });
    },

    logout() {
        axios.get('/api/admin/logout').then(() => {
            localStorage.removeItem('loginResponse');
            localStorage.removeItem('authUser');
            document.location.href = '/';
        });
    },

    storeUpdateUser({commit, getters}) {
        axios.get('/sanctum/csrf-cookie').then(() => {
            axios.get('/api/admin/user').then(response => {
                if (response.data.status === 200) {
                    commit('mutateAuthUser', response.data.data.user);
                    localStorage.setItem(
                        'authUser',
                        JSON.stringify(response.data.data.user)
                    );
                }
            });
        });
    }
};

const mutations = {
    mutateLoginResponse: (state, payload) => (state.loginResponse = payload),
    mutateAuthUser: (state, payload) => (state.authUser = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
