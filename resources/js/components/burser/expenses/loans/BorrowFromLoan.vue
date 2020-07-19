<template>
    <div class="row d-flex justify-content-center card card-body elevation-2 text-center col-12 bg-light h-200 text-dark mx-auto blue lighten-4">
        <h4 class="font-italic col-12">Loan Accounts</h4>
        <div class="col-10 mx-auto">
            <button v-on:click="toggle" :disabled="showBorrow?true:false" class="btn btn-block btn-dark btn-sm">
                {{show?"Borrowing For Loans":"Choose to borrow From Loans"}}
            </button>
        </div>
        <div v-if="showBorrow || show"
            class="col-12 row d-flex justify-content-center">
            <div class="col-12">
                <h5 class="text-center">
                   Borrowing From Loan
                </h5>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <loan-summary/>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h3>Loan Accounts</h3>
                <transition
                enter-active-class="flipInY quick" leave-active-class="flipOutY quick"
                mode="out-in" key="hello"
                >
                    <component :is="selectedLoanComponent"></component>
                </transition>
            </div>

        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import LoanAccounts from './LoanAccounts'
import LoanEditor from './LoanEditor'
import LoanSummary from './LoanSummary'
export default {
    name:"BorrowFromLoan",
    components:{LoanAccounts,LoanSummary,LoanEditor},
    data:function(){
        return{
          showBorrow:false,
          show:false,
        }
    },
    props:["term","account"],
    computed:{
        ...mapState({
            borrowDetails:state=>state.borrowDetails,
            expenseTotal:state=>state.expenseTotal,
            expSelection:state=>state.expNav.expSelection,
            loanSelected:state=>state.expNav.loanSelected
        }),

        termSelection(){
            let message = "";
            if(this.term == ""){
                message = "Please select term!"
            }
            else if(this.term !=="" && this.account !==""){
                let borrow={term:this.term,account:this.account}
                this.$store.dispatch('getBorrowDetailsAction',borrow);
                message=this.term
            }
            else{
                message=this.term
            }

            return message;
        },

        accountSelection(){
            let message ="";
            if(this.account == ""){
                message = "Please select account!"
            }
            else if(this.term !=="" && this.account !==""){
                let borrow={term:this.term,account:this.account}
                this.$store.dispatch('getBorrowDetailsAction',borrow);
                message=this.account
            }
            else{
                message=this.account
            }


            return message;
        },
        setRemainAmount(){
            let amount=0;
            if(this.borrowDetails !== null){
            amount = this.borrowDetails.account.balance - this.expenseTotal;
            if(amount < 0){
                this.showBorrow = true;
            }
            else if(amount>=0){
                this.showBorrow = false;
            }
            else if(this.show)
                this.showBorrow = true;
            }

            return amount;

        },

        selectedLoanComponent(){
            switch(this.loanSelected){
                case 'table':
                    return LoanAccounts;
                case 'editor':
                    return LoanEditor;
            }
        }

    },
    methods:{
     toggle(){
         this.show = !this.show;
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
