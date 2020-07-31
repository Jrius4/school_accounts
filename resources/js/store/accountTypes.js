import Axios from "axios";

export default {
    namespaced:true,
    state:{
        groups:[],
        groupPagination:{
            page:1,
            rowsPerPage:15,
        },
        totalgroups:0,
        groupSortRowsBy:'name'
    },
    getters:{

    },
    mutations:{
        GET_ACCOUNT_GROUPS(currentState,payload){
            currentState.groupSortRowsBy = payload.sortRowsBy
            currentState.groups = payload.accountTypes.data;
            currentState.groupPagination.page = parseInt(payload.accountTypes.current_page);
            currentState.groupPagination.rowsPerPage =parseInt(payload.accountTypes.per_page);
            currentState.totalgroups = parseInt(payload.accountTypes.total);
        },

    },
    actions:{

        async GET_ACCOUNT_GROUPS_ACTION(context,payload){

            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let page = payload.page || "";
                    let rowsPerPage = payload.rowsPerPage || 5;
                    let sortDesc = payload.sortDesc || '';
                    let sortRowsBy = payload.sortRowsBy || '';
                    let query = payload.val || '';


                    let url = `/api/account-types`;
                    Axios.get(url,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                        params:{
                            rowsPerPage,
                            page,
                            sortDesc,
                            sortRowsBy,
                            query
                        }
                    }).then(
                        response =>{
                            const accountTypes = response.data;

                            context.commit('GET_ACCOUNT_GROUPS',accountTypes);
                            resolve(accountTypes);
                        }
                    ).catch((err)=>{
                        console.log(err);
                        reject(err);
                    })

                });
            }
            else{
                console.log('not loggedIn')
            }
        },

        async SAVE_ACCOUNT_GROUPS_ACTION(context,payload){

            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let name = payload.name || "";
                    let id = payload.id || null;
                    let formData = {
                        name
                    }
                    let url = `/api/account-types`;
                    if(id!==null){
                        url = `/api/account-types/${id}`
                    }


                    Axios.post(url,formData,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                    }).then(
                        response =>{
                            const accountTypes = response.data;
                            resolve(accountTypes)
                        }
                    ).catch((err)=>{
                        console.log(err);
                        reject(err);
                    })

                });
            }
            else{
                console.log('not loggedIn')
            }
        },

        async DELETE_ACCOUNT_GROUP_ACTION(context,payload){
            console.log({payload});
            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let id = payload.id || null;


                        url = `/api/account-types/${id}`



                    Axios.delete(url,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                    }).then(
                        response =>{
                            const accountTypes = response.data;
                            resolve(accountTypes)
                        }
                    ).catch((err)=>{
                        console.log(err);
                        reject(err);
                    })

                });
            }
            else{
                console.log('not loggedIn')
            }
        }

    }
}
