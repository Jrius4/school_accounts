export default {
    namespaced: true,
    state: {
        classes: [],
        subjects: [],
        results: [],
        resultPagination: {
            page: 1,
            rowsPerPage: 15
        },
        totalresults: 0
    },
    mutations: {
        GET_CLASSES(currentState, payload) {
            currentState.classes = payload.schclasses || [];
            currentState.subjects = payload.subjects || [];
        },
        FETCH_RESULTS(currentState, payload) {
            currentState.results = payload.data;
            currentState.resultPagination.page = payload.current_page;
            currentState.resultPagination.rowsPerPage = payload.per_page;
            currentState.totalresults = payload.total;
        }
    },
    actions: {
        async GET_CLASSES_ACTIONS(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const user_id = payload.user_id || 0;
                    const url = `/api/teachers-work/${user_id}`;

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(res => {
                            let user = res.data.user;
                            user = user || {};

                            context.commit("GET_CLASSES", user);
                            resolve(user);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    const err = "No loggedIn";
                    console.log(err);
                    reject({ err });
                }
            });
        },
        async FETCH_RESULTS_ACTIONS(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const item_id = payload.item_id || 0;
                    const event = payload.event || "";
                    const url = `/api/class-results`;

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                item_id,
                                event
                            }
                        })
                        .then(res => {
                            let results = res.data.results;
                            results = results || {};
                            context.commit("FETCH_RESULTS", results);
                            resolve(results);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    const err = "No loggedIn";
                    console.log(err);
                    reject({ err });
                }
            });
        }
    }
};
