<template>
  <v-sheet class="col white p-2">
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr  v-if="loanAccounts.length === 0">no inform</tr>
                <tr v-for="acc in loanAccounts" :key="acc.id">
                    <td class="text-left">{{acc.name}}</td>
                    <td class="text-left">{{acc.balance | currency}}</td>
                    <td>
                        <button class="btn btn-xs btn-info" v-on:click="borrowLoanItem(acc)">Borrow</button>
                    </td>
                </tr>
            </tbody>

        </table>
  </v-sheet>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name:"LoanAccounts",
    computed:{
        ...mapState({
            loanAccounts:state=>state.expNav.loanAccounts,
        })
    },

    methods:{
        ...mapMutations({
                selectLoanItem:"selectLoanItem",
                selectLoanComponent:"expNav/selectLoanComponent",
            }),
        borrowLoanItem(item){

            this.selectLoanItem(item);
            this.selectLoanComponent('editor');
        }
    },

    filters:{
        currency(value){
            return new Intl.NumberFormat('en-US',{
                style:"currency",currency:"UGX"
            }).format(value)
        }
    },
    beforeCreate(){
        this.$store.dispatch('getLoanAccountsAction');
    },
    created(){
    },


}
</script>

<style>

</style>
