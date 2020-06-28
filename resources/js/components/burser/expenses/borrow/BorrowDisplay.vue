<template>
    <div>
        <div class="row d-flex justify-content-center card card-body elevation-2 text-center col-12 bg-light h-200 text-dark mx-auto">
            <h4 class="font-italic col-12">Outflow Summary</h4>
            <div class="col-10 mx-auto">
                <table class="table table-sm text-left">
                    <tbody>
                        <tr>
                            <th>
                                Term :
                            </th>
                            <th>
                                {{termSelection}}
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Account :
                            </th>
                            <th>
                                <span v-if="borrowDetails!==null">
                                    {{borrowDetails.account.name}}
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Account Balance :
                            </th>
                            <th>
                                <span v-if="borrowDetails!==null">
                                    {{borrowDetails.account.balance | currency}}
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Amount Expense :
                            </th>
                            <th>
                                {{-expenseTotal | currency}}
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Amount to Remain On Account :
                            </th>
                            <th>
                                {{setRemainAmount | currency}}
                            </th>
                        </tr>
                    </tbody>
                </table>
                <button v-on:click="toggle" :disabled="showBorrow?true:false" class="btn btn-block btn-dark btn-sm">
                    {{show?"Borrowing":"Choose to borrow"}}
                </button>
            </div>
            <div v-if="showBorrow || show"
                class="col-12 row d-flex justify-content-center">
                <div class="col-12">
                    <h5 class="text-center">
                    Borrowing
                    </h5>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <borrow-summary/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h3>Accounts</h3>
                    <transition
                    enter-active-class="fadeIn quick" leave-active-class="fadeOut quick"
                    mode="out-in" key="hello"
                    >
                        <component :is="selectedExpComponent"></component>
                    </transition>
                </div>

            </div>

        </div>
        <borrow-from-loan :term="term" :account="account" />

    </div>

</template>

<script>
import { mapState } from 'vuex'
import OtherAccounts from './OtherAccounts'
import BorrowEditor from './BorrowEditor.vue'
import BorrowSummary from './BorrowSummary.vue'
import BorrowFromLoan from '../loans/BorrowFromLoan';
export default {
    name:"BorrowDisplay",
    components:{OtherAccounts,BorrowEditor,BorrowSummary,BorrowFromLoan},
    data:function(){
        return{
          showBorrow:false,
          show:false,
        }
    },
    props:["term","account",'accounts'],
    computed:{
        ...mapState({
            borrowDetails:state=>state.borrowDetails,
            expenseTotal:state=>state.expenseTotal,
            expSelection:state=>state.expNav.expSelection,
            borrowSelected:state=>state.expNav.borrowSelected,
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
                else if(this.show){
                    this.showBorrow = true;
                }

                return amount;
            }

        },

        selectedExpComponent(){
            switch(this.borrowSelected){
                case 'table':
                    return OtherAccounts;
                case 'editor':
                    return BorrowEditor;
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
