<template>
  <div>
      <div class="form-group d-block col">
          <label>Item Name</label>
          <input type="text" class="form-control d-block col-12" v-model="expItem.name"/>
      </div>
      <div class="form-group d-block col">
          <label>Quantity</label>
          <input type="text" class="form-control d-block col-12"
            v-model="expItem.quantity"/>
      </div>
      <div class="form-group d-block col">
          <label>Unit</label>
          <input type="text" class="form-control d-block col-12"
          v-model="expItem.units"
          />
      </div>
      <div class="form-group d-block col">
          <label>Rate <small>(each unit)</small></label>
          <input type="text" class="form-control d-block col-12"
          v-model="formatCreditAmount"
          />
      </div>
      <div class="form-group d-block col">
          <label>Description</label>
          <textarea cols="3" rows="10" class="form-control d-block col-12"v-model="expItem.description"></textarea>
      </div>
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
</template>

<script>
let unwatcher;
export default {
data:function(){
    return{
        editing:false,
        expItem:{
            name:'',
            description:'',
            quantity:'',
            units:'',
            rate:0,
        }
    }
},
methods:{
    async save(){
        if(this.editing){
            await this.$store.dispatch("updateExpenseItemAction",this.expItem);
        }
        else{
            await this.$store.dispatch("createExpenseItemAction",this.expItem);
        }

        this.$store.commit("expNav/selectExpItemComponent",'table');
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
        this.$store.commit("selectExpItem");
        this.$store.commit("expNav/selectExpItemComponent",'table');
    },
    selectExpItem(selectedItem){
        if(selectedItem == null){
            this.editing = false;
            this.expItem={
                            name:'',
                            quantity:'',
                            description:'',
                            units:'',
                            rate:0,
                        };
        }
        else{
            this.editing = true;
            this.expItem={
                            name:'',
                            quantity:'',
                            units:'',
                            description:'',
                            rate:0,
                        };

            Object.assign(this.expItem,selectedItem)
        }
    }

},
computed:{
    formatCreditAmount:{
            get:function(){
                        return this.formatAsCurrency(this.expItem.rate,0);
            },
            set:function(newValue){
                this.expItem.rate = Number(newValue.replace(/[^0-9\.]/g,''));
            }
        },
},
created(){
    unwatcher = this.$store.watch(state=>state.selectedExpItem,this.selectExpItem);
    this.selectExpItem(this.$store.state.selectedExpItem)
},
beforeDestroy(){
    unwatcher();
}

}
</script>

<style>

</style>
