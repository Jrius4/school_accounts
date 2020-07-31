import Axios from "axios";

export default {
    namespaced:true,
    state:{
        payments:[],
        paymentPagination:{
            page:1,
            rowsPerPage:15,
        },
        totalpayments:0,
        queryType:'daily',
    },
    getters:{

    },
    mutations:{
        GET_EXPENSES_INCOME(currentState,payload){
            currentState.payments = payload.payments.data;
            currentState.paymentPagination.page = parseInt(payload.payments.current_page);
            currentState.paymentPagination.rowsPerPage =parseInt(payload.payments.per_page);
            currentState.totalpayments = parseInt(payload.payments.total);
            currentState.queryType = payload.queryType;
        },

    },
    actions:{

        async GET_EXPENSES_INCOME_ACTION(context,payload){
            if(context.rootGetters.loggedIn){
                return new Promise((resolve,reject)=>{
                    let page = payload.page || "";
                    let rowsPerPage = payload.rowsPerPage || 5;
                    let sortDesc = payload.sortDesc || '';
                    let queryType = payload.queryType || '';
                    let start = payload.start || '';
                    let end = payload.end || '';


                    let url = `/api/overview-expenses`;
                    Axios.get(url,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                        params:{
                            rowsPerPage,
                            page,
                            sortDesc,
                            queryType,
                            start,
                            end,
                        }
                    }).then(
                        response =>{
                            const payments = response.data;

                            context.commit('GET_EXPENSES_INCOME',payments);
                            resolve(payments);
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

    }
}
