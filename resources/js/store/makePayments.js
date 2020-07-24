import Axios from "axios"
export default {
 namespaced: true,
 state:{
     paymentsActive:[],
 },
 getters:{

 },
 mutations:{
     MAKE_PAYMENTS(currentState,payload){

     }
 },
 actions:{
    async MAKE_PAYMENTS_ACTION(context,payload){
        return new Promise((resolve,reject)=>{

            if(context.rootGetters.loggedIn){
                const url = `/api/make-payment`;
                let formData = {
                    term_id:payload.term_id || '',
                    paymentType:payload.paymentType || '',
                    paidItems:payload.paidItems || [],
                    fullAmount:payload.fullAmount || '',
                    balance:payload.balance || '',
                    description:payload.description || '',
                    student_id:payload.student_id || '',
                    paid_by:payload.paid_by || '',
                }
                Axios.post(url,
                    formData
                    ,{
                    headers:{
                        Authorization: "Bearer "+context.rootState.token
                    }
                }).then(response=>{
                   let madePayment = response.data
                    resolve(madePayment);
                }).catch(err=>{
                    console.log(err);
                    reject(err)
                })
            }
            else{
                let error = 'not logged in'
                reject({error});
                console.error({error});
            }
        })
    }
 }
}
