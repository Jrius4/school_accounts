export default {
    namespaced: true,
    state: {
        streams: [],
        stream: null,
        streams: [],

        streamPagination: {
            page: 1,
            rowsPerPage: 15
        },
        totalstreams: 0,
        streamSortRowsBy: "name",
        students: []
    },
    getters: {},
    mutations: {
        GET_STREAMS(currentState, payload) {
            currentState.streamSortRowsBy = payload.sortRowsBy || "name";
            currentState.streams = payload.data;
            currentState.streamPagination.page = parseInt(payload.current_page);
            currentState.streamPagination.rowsPerPage = parseInt(
                payload.per_page
            );
            currentState.totalstreams = parseInt(payload.total);
            currentState.stream = null;
            currentState.students = [];
        },
        GET_ACCOUNT_GROUPS(currentState, payload) {
            currentState.groups = payload.accountTypes.data;
            currentState.groupPagination.page = parseInt(
                payload.accountTypes.current_page
            );
            currentState.groupPagination.rowsPerPage = parseInt(
                payload.accountTypes.per_page
            );
        }
    },
    actions: {
        async GET_STREAMS_ACTION(context, payload) {
            if (context.rootGetters.loggedIn) {
                return new Promise((resolve, reject) => {
                    let page = payload.page || "";
                    let rowsPerPage = payload.rowsPerPage || 5;
                    let sortDesc = payload.sortDesc || null;
                    let sortRowsBy = payload.sortRowsBy || "";
                    let query = payload.val || "";

                    let url = `/api/streams`;
                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                rowsPerPage,
                                page,
                                sortDesc,
                                sortRowsBy,
                                query
                            }
                        })
                        .then(response => {
                            const streams = response.data.streams;

                            context.commit("GET_STREAMS", streams);
                            resolve(streams);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                });
            } else {
                console.log("not loggedIn");
            }
        },

        async SAVE_STREAM_ACTION(context, payload) {
            if (context.rootGetters.loggedIn) {
                return new Promise((resolve, reject) => {
                    let name = payload.name || "";
                    let id = payload.id || null;
                    let formData = {
                        name
                    };
                    let url = `/api/streams`;
                    if (id !== null) {
                        url = `/api/streams/${id}`;
                    }

                    axios
                        .post(url, formData, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(response => {
                            const stream = response.data;
                            resolve(stream);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                });
            } else {
                console.log("not loggedIn");
            }
        },

        async GET_ACCOUNT_FEESTRUCTURES_ACTION(context, payload) {
            if (context.rootGetters.loggedIn) {
                return new Promise((resolve, reject) => {
                    let id = payload.id || null;
                    let account_id = payload.school_account_id || null;

                    let url = `/api/accounts/${account_id}/structures`;
                    if (id !== null) {
                        url = `/api/accounts/${account_id}/structures/${id}`;
                    }

                    axios
                        .post(url, formData, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(response => {
                            const structures = response.data.structures;

                            resolve(structures);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                });
            } else {
                console.log("not loggedIn");
            }
        },

        async SAVE_ACCOUNT_FEESTRUCTURES_ACTION(context, payload) {
            if (context.rootGetters.loggedIn) {
                return new Promise((resolve, reject) => {
                    let id = payload.id || null;
                    let account_id = payload.school_account_id || null;
                    let structure_name = payload.structure_name || null;
                    let amount = payload.amount || null;
                    let formData = {
                        structure_name,
                        amount
                    };
                    let url = `/api/accounts/${account_id}/structures/${id}`;
                    if (id === null) {
                        url = `/api/accounts/${account_id}/structures`;
                    }

                    axios
                        .post(url, formData, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(response => {
                            const structures = response.data.structures;
                            const data = {
                                account_id: account_id
                            };

                            context
                                .dispatch("SELECT_ACCOUNT_ACTION", data)
                                .then(res => {
                                    let data2 = res;

                                    resolve(data2);
                                });
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                });
            } else {
                console.log("not loggedIn");
            }
        },

        async SELECT_ACCOUNT_ACTION(context, payload) {
            if (context.rootGetters.loggedIn) {
                return new Promise((resolve, reject) => {
                    let account_id = payload.account_id || null;
                    if (account_id !== null) {
                        let url = `api/accounts/${account_id}`;
                        axios
                            .get(url, {
                                headers: {
                                    Authorization:
                                        "Bearer " + context.rootState.token
                                }
                            })
                            .then(response => {
                                const accounts = response.data.accounts;

                                resolve(accounts);
                            })
                            .catch(err => {
                                console.log(err);
                                reject(err);
                            });
                    } else {
                        reject("wrong url");
                    }
                });
            } else {
                console.log("not loggedIn");
            }
        },
        async DELETE_ACCOUNT_FEESTRUCTURE_ACTION(context, payload) {
            if (context.rootGetters.loggedIn) {
                return new Promise((resolve, reject) => {
                    let id = payload.id || null;
                    let account_id = payload.school_account_id || null;

                    let url = `/api/accounts/${account_id}/structures/${id}`;

                    axios
                        .delete(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(response => {
                            const structures = response.data.structures;
                            const data = {
                                account_id: account_id
                            };

                            context
                                .dispatch("SELECT_ACCOUNT_ACTION", data)
                                .then(res => {
                                    let data2 = res;

                                    resolve(data2);
                                });
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                });
            } else {
                console.log("not loggedIn");
            }
        }
    }
};
