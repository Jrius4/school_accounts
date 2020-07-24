import Axios from "axios";

export default {
    namespaced:true,
    state: {
        payments:[],
        paymentPagination:{
            page:1,
            rowsPerPage:15,
        },
        totalpayments:0,
        period:'daily'
    },
    getters:{

    },
    mutations:{

        GET_ITEMS(currentState,payload){
            currentState.payments = payload.income.data;
            currentState.paymentPagination.page = parseInt(payload.income.current_page);
            currentState.paymentPagination.rowsPerPage =parseInt(payload.income.per_page);
            currentState.totalpayments = parseInt(payload.income.total);
            currentState.paymentSortRowsBy = payload.income.sortRowsBy;
            currentState.period = payload.period;
        },

    },
    actions:{
        async GET_ITEMS_ACTION(context,payload){
            return new Promise((resolve,reject)=>{
                if(context.rootGetters.loggedIn){
                    let query = payload.val || "";
                    let page = payload.page || "";
                    let sortRowsBy = payload.sortRowsBy || "id";
                    let rowsPerPage = payload.rowsPerPage || 5;
                    let sortDesc = payload.sortDesc || '';
                    let period = payload.period || '';
                    let start = payload.start || '';
                    let end = payload.end || '';
                    const url = `/api/details`;
                    Axios.get(url,{
                        headers:{
                            Authorization: "Bearer "+context.rootState.token
                        },
                        params:{
                            query,
                            rowsPerPage,
                            page,
                            sortRowsBy,
                            sortDesc,
                            period,
                            start,
                            end
                        }
                    }).then(response=>{
                        const data = response.data;

                        context.commit('GET_ITEMS',data)
                        resolve(data);
                    })
                    .catch(err=>{
                        reject(err);
                        console.log(err);
                    })
                }
                else{
                    const message = {message:'Not logged In'};
                    console.log(message);
                    reject(message);
                }

            });

        }
    }
}
