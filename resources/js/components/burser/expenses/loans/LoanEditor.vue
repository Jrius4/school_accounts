<template>
<div class="text-left">
   <h4>Credit Editor</h4>
   <div class="form-group d-block col">
       <label>Account Name</label>
        <input type="text" class="form-control d-block col-12"
           disabled v-model="loanItem.name"
        >
   </div>
   <div class="form-group d-block col">
       <label>Account Balance</label>
        <input type="text" class="form-control d-block col-12"
           disabled v-model="formatLoanBalanceAmount"
        >
   </div>
   <div class="form-group d-block col">
       <label>Credit / Borrow</label>
        <input type="text" class="form-control d-block col-12"
            v-model="formatLoanCreditAmount"
        >
   </div>
   <div class="form-group d-block col">
       <div class="col  btn-group">
        <button class="btn btn-dark col"
            v-on:click="save"
        >
            {{editing?"Save":"Create"}}
        </button>
        <button class="btn btn-secondary col"
            v-on:click="cancel"
        >
            Cancel
        </button>
      </div>
   </div>
</div>


</template>

<script>
let unwatcher;
export default {
    name:"LoanEditor",
    data:function(){
        return{
            editing:false,
            loanItem:{},
            credit:0
        }

    },
    methods:{
        async save(){
            if(this.editing){
                await this.$store.dispatch("makeBorrowLoanAction",{selectedAccount:this.loanItem,credit:this.credit});
            }
            else{

            }

            this.$store.commit("expNav/selectLoanComponent",'table');
        },
        formatAsCurrency(value,dec){
            dec = dec || 0;
            if (value === null){
                return 0;
            }
            return new Intl.NumberFormat("en-US",{
                style: "currency",currency: "UGX"
            }).format(value)
        },
        cancel(){
            this.$store.commit("selectLoanItem");
            this.$store.commit("expNav/selectLoanComponent",'table');
        },
        selectLoanItem(selectLoanItem){
            if(selectLoanItem == null){
                this.editing = false;
                this.loanItem ={}
            }
            else{
                this.editing = true;
                this.loanItem = {};
                Object.assign(this.loanItem,selectLoanItem)
            }
        }
    },
    computed:{
        formatLoanBalanceAmount:{
            get:function(){

                return this.formatAsCurrency(this.loanItem.balance,0);
            },
            set:function(newValue){
                this.loanItem.balance = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },
        formatLoanCreditAmount:{
            get:function(){

                        return this.formatAsCurrency(this.credit,0);




            },
            set:function(newValue){
                this.credit = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },
    },
    created(){
        unwatcher = this.$store.watch(state=>state.selectedLoanItem,this.selectLoanItem);
        this.selectLoanItem(this.$store.state.selectedLoanItem);
    },
    beforeDestroy(){
    unwatcher();
}
}
</script>

<style>

</style>
