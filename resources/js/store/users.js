export default {
    namespaced: true,
    state: {
        users: [],
        selectedUser: null,
        totalUsers: 0,
        usersPage: 1,
        users_per_page: 15
    },

    mutations: {
        GET_USERS(currentState, payload) {
            currentState.users = payload.users.data;
            currentState.totalUsers = payload.users.total;
            currentState.usersPage = payload.users.current_page;
            currentState.users_per_page = payload.users.per_page;
        },
        SELECT_USER(currentState, payload) {
            currentState.selectedUser = payload.user;
        }
    },
    getters: {},
    actions: {
        async GET_USERS_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const page = payload.page || 1;
                    const keywords = payload.keywords || "";
                    const userId = payload.id || 0;
                    let url = "/api/v1/get-users";
                    if (userId !== 0) url = `/api/v1/get-users/${userId}`;

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                keywords,
                                page
                            }
                        })
                        .then(res => {
                            const users = res.data;

                            if (userId === 0)
                                context.commit("GET_USERS", users);
                            if (userId !== 0)
                                context.commit("SELECT_USER", users);
                            resolve(users);
                        })
                        .catch(err => {
                            reject(err);
                        });
                } else {
                    const err = "Not logged In";
                    reject({ err });
                }
            });
        }
    }
};
