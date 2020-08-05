import Axios from "axios";

export default {
    namespaced:true,
    state:{
        account:null,
        accounts:[],

        accountPagination:{
            page:1,
            rowsPerPage:15,
        },
        totalaccounts:0,
        accountSortRowsBy:'account_name',
        feestructures:[],

        groups:[],
        groupPagination:{
            page:1,
            rowsPerPage:15,
        },
        totalgroups:0,
        groupSortRowsBy:'name',
    },
    getters:{

    },
    mutations:{
        GET_ACCOUNTS(currentState,payload){
            currentState.accountSortRowsBy = payload.sortRowsBy
            currentState.accounts = payload.accounts.data;
            currentState.accountPagination.page = parseInt(payload.accounts.current_page);
            currentState.accountPagination.rowsPerPage =parseInt(payload.accounts.per_page);
            currentState.totalaccounts = parseInt(payload.accounts.total);
            currentState.account = null
            currentState.feestructures = []
        },
        GET_ACCOUNT_GROUPS(currentState,payload){
            currentState.groups = payload.accountTypes.data;
            currentState.groupPagination.page = parseInt(payload.accountTypes.current_page);
            currentState.groupPagination.rowsPerPage =parseInt(payload.accountTypes.per_page);
        },


    },
    actions:{


        async GET_ACCOUNTS_ACTION(context,payload){

            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let page = payload.page || "";
                    let rowsPerPage = payload.rowsPerPage || 5;
                    let sortDesc = payload.sortDesc || null;
                    let sortRowsBy = payload.sortRowsBy || '';
                    let query = payload.val || '';



                    let url = `/api/accounts`;
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
                            const accounts = response.data;

                            context.commit('GET_ACCOUNTS',accounts);
                            resolve(accounts);
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




        async GET_ACCOUNT_GROUPS_ACTION(context,payload){
            console.log({sea:payload});
            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let page = 1;
                    let rowsPerPage = 4;
                    let query = payload.val || '';
                    let url = `/api/account-types`;
                    Axios.get(url,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                        params:{
                            rowsPerPage,
                            page,
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
        async SAVE_ACCOUNTS_ACTION(context,payload){

            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let name = payload.name || "";
                    let id = payload.id || null;
                    let formData = {
                        name
                    }
                    let url = `/api/accounts`;
                    if(id!==null){
                        url = `/api/accounts/${id}`
                    }


                    Axios.post(url,formData,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                    }).then(
                        response =>{
                            const accounts = response.data;
                            resolve(accounts)
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

        async GET_ACCOUNT_FEESTRUCTURES_ACTION(context,payload){

            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let id = payload.id || null;
                    let account_id = payload.school_account_id || null;

                    let url = `/api/accounts/${account_id}/structures`;
                    if(id!==null){
                        url = `/api/accounts/${account_id}/structures/${id}`
                    }


                    Axios.post(url,formData,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                    }).then(
                        response =>{
                            const structures = response.data.structures;

                            resolve(structures)
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

        async SAVE_ACCOUNT_FEESTRUCTURES_ACTION(context,payload){

            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let id = payload.id || null;
                    let account_id = payload.school_account_id || null;
                    let structure_name = payload.structure_name || null;
                    let amount = payload.amount || null;
                    let formData = {
                        structure_name,
                        amount,
                    }
                    let url = `/api/accounts/${account_id}/structures/${id}`
                    if(id === null){
                        url = `/api/accounts/${account_id}/structures`;
                    }


                    Axios.post(url,formData,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                    }).then(
                        response =>{
                            const structures = response.data.structures;
                            const data = {
                                account_id:account_id,
                            }


                            context.dispatch('SELECT_ACCOUNT_ACTION',data).then(res=>{
                               let data2 = res;

                                resolve(data2);
                            });



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

        async SELECT_ACCOUNT_ACTION(context,payload){
            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let account_id = payload.account_id || null;
                    if(account_id!== null){
                        let url = `api/accounts/${account_id}`;
                        Axios.get(url,{
                            headers:{
                                Authorization: "Bearer "+context.rootState.token
                            }
                        }).then(
                            response =>{
                                const accounts = response.data.accounts;

                                resolve(accounts)
                            }
                        ).catch((err)=>{
                            console.log(err);
                            reject(err);
                        });
                    }
                    else{
                        reject('wrong url')
                    }
                });
            }

            else{
                console.log('not loggedIn')
            }
        },
        async DELETE_ACCOUNT_FEESTRUCTURE_ACTION(context,payload)
        {


            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let id = payload.id || null;
                    let account_id = payload.school_account_id || null;

                    let url = `/api/accounts/${account_id}/structures/${id}`

                    Axios.delete(url,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                    }).then(
                        response =>{
                            const structures = response.data.structures;
                            const data = {
                                account_id:account_id,
                            }


                            context.dispatch('SELECT_ACCOUNT_ACTION',data).then(res=>{
                               let data2 = res;

                                resolve(data2);
                            });



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
