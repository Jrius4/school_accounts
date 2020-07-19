<template>
  <v-sheet class="row col white">
      <h4>Borrow Loan Summary</h4>
      <table class="table table-sm col-12" style="font-size:12px;">
          <thead>
              <tr>
                  <th>Loan Account</th>
                  <th>Pre Acc. Bal.</th>
                  <th>Borrowing</th>
                  <th>Post Acc. Bal.</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              <tr v-if="makeLoanBorrowItems.length === 0">
                  <td colspan="5">
                      <p>No Loan Account Borrowed From yet</p>
                  </td>
              </tr>
              <tr v-for="item in makeLoanBorrowItems" :key="item.selectedAccount.id" :class="(item.selectedAccount.balance - item.credit)<0?'bg-danger text-white':''">
                  <td>
                      {{item.selectedAccount.name}}
                  </td>
                  <td>
                      {{item.selectedAccount.balance | currency}}
                  </td>
                  <td>
                      {{item.credit | currency}}
                  </td>
                  <td>
                      {{item.selectedAccount.balance - item.credit  | currency}}
                  </td>
                  <td>
                      <button class="btn btn-xs btn-secondary"
                      v-on:click="deleteBorrowLoanItem(item)"
                      >
                          Remove
                      </button>
                  </td>
              </tr>
          </tbody>
          <tfoot>
              <tr>
                  <td>Total Credit Collected</td>
                  <td>{{ (gettingSum) | currency }}</td>
                  <td>Remaining</td>
                  <td :class="totalSubstraction<0?'bg-warning text-white':((totalSubstraction)===0?'bg-success text-white':'')">{{ (totalSubstraction) | currency }}</td>
              </tr>
              <tr>
                  <td class="text-center" colspan="5">
                      <span class="badge badge-success p-2">Credit All Collected</span>

                      <span class="badge badge-warning p-2">Collection Is Above</span>

                      <span class="badge badge-danger p-2">Less Account Balance</span>
                  </td>
              </tr>
          </tfoot>

      </table>

  </v-sheet>
</template>

<script>
let watcher,totalBorrow=0;
import { mapState,mapActions } from 'vuex'
export default {
    name:'LoanSummary',
    data:function(){
        return{
            creditTotal:0
        }
    },
    computed:{
        ...mapState({
            expenseTotal: state=>state.expenseTotal,
            totalBorrow:state=>state.expNav.totalBorrowed,
            totalCreditLoan:state=>state.expNav.totalCreditLoan,
            makeLoanBorrowItems:state=>state.makeLoanBorrowItems,
            totalSubstraction : state=>state.amntTtlExpBorSub,
        }),
        gettingSum(){
           let totalCreditLoan = 0;
            this.makeLoanBorrowItems.forEach(element=>{
                totalCreditLoan += parseInt(element.credit);
            })
            this.$store.dispatch("getCreditTotalLoanAction",totalCreditLoan);

           return this.totalCreditLoan;
        },
        gettingRemaining(){
            let totalSub = 0;
            let toXp = this.expenseTotal||0;
            let toBw = this.totalBorrow||0;
            let toBwLo = this.totalCreditLoan||0;
            totalSub = parseInt(toXp) - (parseInt(toBw) + parseInt(toBwLo));
            this.$store.dispatch("gettotalSubstractionAction",totalSub);
            totalSub = this.$store.state.amntTtlExpBorSub
            return totalSub;
        }


    },
    methods:{
        ...mapActions({
         deleteBorrowLoanItem:"deleteBorrowLoanItemAction"
     }),
     classState(){
         let className = "";
        let diffCal =  this.expenseTotal - this.gettingSum
         if(diffCal > 0){
             className = "bg-warning text-dark";
         }
         else if(diffCal === 0){
             className = "bg-success text-white";
         }
         else if(diffCal < 0){
             className = "bg-danger text-white";
         }
         return className;
     }
    },
    filters:{
        currency(value){
            return new Intl.NumberFormat('en-US',{
                style:"currency",currency:"UGX"
            }).format(value)
        }
    }

}
</script>

<style>

</style>
