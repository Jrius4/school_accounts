<template>
  <div class="col">
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="accountsBorrow !== null">
                <tr  v-if="accountsBorrow.length === 0">no inform</tr>
                <tr v-for="acc in accountsBorrow" :key="acc.id">
                    <td class="text-left">{{acc.name}}</td>
                    <td class="text-left">{{acc.balance | currency}}</td>
                    <td>
                        <button class="btn btn-xs btn-info" v-on:click="borrowItem(acc)">Borrow</button>
                    </td>
                </tr>
            </tbody>

        </table>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
export default {
    name:"OtherAccounts",
    computed:{
        ...mapState({
            accountsBorrow:state=>state.expNav.accountsBorrow,
            accountSelected:state=>state.accountSelected,
        })
    },

    methods:{
        ...mapMutations({
                selectBorrowItem:"selectBorrowItem",
                selectBorrowComponent:"expNav/selectBorrowComponent",
            }),
        borrowItem(item){
            this.selectBorrowItem(item);
            this.selectBorrowComponent('editor');
        }
    },

    filters:{
        currency(value){
            return new Intl.NumberFormat('en-US',{
                style:"currency",currency:"UGX"
            }).format(value)
        }
    },
    created(){
        this.$store.dispatch('getBorrowAccountsAction',this.accountSelected);
    },
    watch:{
        accountSelected(value){
            this.$store.dispatch('getBorrowAccountsAction',value);
        }
    }

}
</script>

<style>

</style>
