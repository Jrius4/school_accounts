export default {
    namespaced: true,
    state: {
        roles: [],
        totalRoles: 0,
        roles_per_page: 10,
        rolesPage: 1,
        selectedRoles: [],
        attachedRoles: [],
        detachedRoles: [],
        selectedRole: null,
        permissions: {}
    },
    mutations: {
        GET_ROLES(currentState, payload) {
            currentState.roles = payload.data;
            currentState.totalRoles = payload.total;
            currentState.rolesPage = payload.current_page;
            currentState.roles_per_page = payload.per_page;
        },
        SELECT_ROLE(currentState, payload) {
            currentState.selectedRole = payload;
        },
        GET_PERMISSIONS(currentState, payload) {
            currentState.permissions = payload;
        }
    },
    getters: {},
    actions: {
        async CHECK_USERNAME_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const email = payload.email || "";
                    const username = payload.username || "";
                    const url = `/api/roles/users/check-uniqueness`;
                    const data = {
                        username,
                        email
                    };
                    axios
                        .post(url, data, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(result => {
                            const data = result.data;
                            resolve(data);
                        })
                        .catch(err => reject(err));
                } else {
                }
            });
        },
        async SAVE_USER_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const username = payload.username || "";
                    const first_name = payload.first_name || "";
                    const last_name = payload.last_name || "";
                    const given_name = payload.given_name || "";
                    const contact = payload.contact || "";
                    const email = payload.email || "";
                    const password = payload.password || "";
                    const files = payload.files || "";
                    const roles = payload.roles || "";
                    const permissions = payload.permissions || "";

                    let formData = new FormData();

                    if (files !== "") {
                        for (let index = 0; index < files.length; index++) {
                            formData.append("files[]", files[index]);
                            formData.append(`file${index}`, files[index]);
                        }
                    } else {
                        formData.append("files", files);
                    }

                    if (roles !== "") {
                        for (let index = 0; index < roles.length; index++) {
                            formData.append("roles[]", roles[index]);
                        }
                    } else {
                        formData.append("roles", roles);
                    }

                    if (permissions !== "") {
                        for (
                            let index = 0;
                            index < permissions.length;
                            index++
                        ) {
                            formData.append(
                                "permissions[]",
                                permissions[index]
                            );
                        }
                    } else {
                        formData.append("permissions", permissions);
                    }

                    formData.append("username", username);
                    formData.append("first_name", first_name);
                    formData.append("last_name", last_name);
                    formData.append("given_name", given_name);
                    formData.append("email", email);
                    formData.append("contact", contact);

                    formData.append("password", password);

                    const url = `/api/roles/create-user`;

                    axios
                        .post(url, formData, {
                            headers: {
                                "Content-Type":
                                    "multipart/form-data; charset=utf-8; boundary=" +
                                    Math.random()
                                        .toString()
                                        .substr(2),
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(result => {
                            resolve(result.data);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                }
            });
        },
        async GET_ROLES_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const page = payload.page || 1;
                    const query = payload.query || null;

                    const url = `/api/roles`;

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                query,
                                page
                            }
                        })
                        .then(response => {
                            const roles = response.data.roles;
                            resolve(roles);
                            context.commit("GET_ROLES", roles);
                        });
                } else {
                    console.log("not logged In!");
                    const err = "not logged In!";
                    reject({ err });
                }
            });
        },

        async STORE_ROLE_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    console.log({ payload });
                    const role_id = payload.role_id || "";
                    const name = payload.name || "";
                    const description = payload.description || "";
                    const permissions = payload.permissions || "";

                    const url = `/api/roles`;

                    let formData = new FormData();

                    if (permissions !== "") {
                        for (
                            let index = 0;
                            index < permissions.length;
                            index++
                        ) {
                            formData.append(
                                "permissions[]",
                                permissions[index]
                            );
                        }
                    } else {
                        formData.append("permissions", permissions);
                    }

                    formData.append("name", name);
                    formData.append("description", description);

                    if (role_id !== null) {
                        axios
                            .post(url, formData, {
                                headers: {
                                    Authorization:
                                        "Bearer " + context.rootState.token
                                }
                            })
                            .then(response => {
                                const role = response.data;
                                context.dispatch("GET_ROLES_ACTION", {
                                    page: 1,
                                    query: ""
                                });
                                resolve(role);
                            })
                            .catch(err => {
                                console.log(err);
                                reject(err);
                            });
                    } else {
                        reject({ err: "no role selected" });
                    }
                } else {
                    console.log("not logged In!");
                    const err = "not logged In!";
                    reject({ err });
                }
            });
        },

        async SELECT_ROLE_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const role_id = payload.id || null;

                    const url = `/api/roles/${role_id}`;

                    if (role_id !== null) {
                        axios
                            .get(url, {
                                headers: {
                                    Authorization:
                                        "Bearer " + context.rootState.token
                                }
                            })
                            .then(response => {
                                const roles = response.data.roles;
                                resolve(roles);
                                context.commit("SELECT_ROLE", roles);
                            })
                            .catch(err => {
                                console.log(err);
                                reject(err);
                            });
                    } else {
                        reject({ err: "no role selected" });
                    }
                } else {
                    console.log("not logged In!");
                    const err = "not logged In!";
                    reject({ err });
                }
            });
        },
        async SAVE_PERMISSION_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const url = `/api/permissions`;

                    axios
                        .post(url, formData, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(result => {
                            var permission = result.data;
                            console.log(permission);
                            context.dispatch("GET_PERMISSIONS_ACTION", {
                                page: 1,
                                query: ""
                            });
                            resolve(permission);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    console.log("not logged In!");
                    const err = "not logged In!";
                    reject({ err });
                }
            });
        },
        async GET_PERMISSIONS_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const page = payload.page || 1;
                    const query = payload.query || "";

                    const url = `/api/permissions`;

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                query,
                                page
                            }
                        })
                        .then(response => {
                            const roles = response.data.permissions;
                            resolve(roles);
                            context.commit("GET_PERMISSIONS", roles);
                        });
                } else {
                    console.log("not logged In!");
                    const err = "not logged In!";
                    reject({ err });
                }
            });
        }
    }
};
