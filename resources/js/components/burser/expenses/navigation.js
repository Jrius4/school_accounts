import Axios from "axios";
const termsData = [];
// let accountsData = null;

// accountsData =[];
// for(let i=1;i<=5;i++){
//     accountsData.push({
//         id:i,name:`Account #${i}`,balance:i*9500000
//     })
// }

// Axios.get('/api/make-expenses',{
//     headers:{
//         Authorization: "Bearer "+this.$store.state.token
//     }
// }).get(response=>{
//     accountsData = response.data.data
// }).catch(err=>{console.log(err);accountsData=[];})

for(let i=1;i<=3;i++){
    termsData.push({
        id:i,name:`Term #${i}`
    })
}
export default {
    namespaced:true,
    state:{
        selected:"table",
        borrowSelected:'table',
        loanSelected:'table',
        selectedItem:null,
        terms:termsData,
        accounts:null,
        accountsBorrow:null,
        loanAccounts:[],
        totalBorrowed:0,
        totalCreditLoan:0,

        expSelection:{
            term:"",
            account:"",
        }
    },
    mutations:{
        selectExpItemComponent(currentState,selection){
            currentState.selected = selection;
        },
        selectBorrowComponent(currentState,selection){
            currentState.borrowSelected = selection;
        },
        selectLoanComponent(currentState,selection){
            currentState.loanSelected = selection;
        }

    },
    actions:{

    }
}
