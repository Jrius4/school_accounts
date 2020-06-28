<template>
<div class="text-left">
   <h4>Credit Editor</h4>
   <div class="form-group d-block col">
       <label>Account Name</label>
        <input type="text" class="form-control d-block col-12"
           disabled v-model="borrowItem.name"
        >
   </div>
   <div class="form-group d-block col">
       <label>Account Balance</label>
        <input type="text" class="form-control d-block col-12"
           disabled v-model="formatBalanceAmount"
        >
   </div>
   <div class="form-group d-block col">
       <label>Credit / Borrow</label>

        <input type="text" class="form-control d-block col-12"
            v-model="formatCreditAmount"
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
    name:"BorrowEditor",
    data:function(){
        return{
            editing:false,
            borrowItem:{},
            credit:0
        }

    },
    methods:{
        async save(){
            if(this.editing){
                await this.$store.dispatch("makeBorrowAction",{selectedAccount:this.borrowItem,credit:this.credit});
            }
            else{

            }

            this.$store.commit("expNav/selectBorrowComponent",'table');
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
            this.$store.commit("selectBorrowItem");
            this.$store.commit("expNav/selectBorrowComponent",'table');
        },
        selectBorrowItem(selectBorrowItem){
            if(selectBorrowItem == null){
                this.editing = false;
                this.borrowItem ={}
            }
            else{
                this.editing = true;
                this.borrowItem = {};
                Object.assign(this.borrowItem,selectBorrowItem)
            }
        }
    },
    computed:{
        formatBalanceAmount:{
            get:function(){

                return this.formatAsCurrency(this.borrowItem.balance,0);
            },
            set:function(newValue){
                this.borrowItem.balance = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },
        formatCreditAmount:{
            get:function(){

                        return this.formatAsCurrency(this.credit,0);




            },
            set:function(newValue){
                this.credit = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },
    },
    created(){
        unwatcher = this.$store.watch(state=>state.selectedBorrowItem,this.selectBorrowItem);
        this.selectBorrowItem(this.$store.state.selectedBorrowItem);
    },
    beforeDestroy(){
    unwatcher();
}
}
</script>

<style>

</style>
