<template>
  <div>
      <div class="col-12">
          <button class="btn btn-block btn-sm btn-primary col-md-12 mx-auto"
            v-on:click="createExpItem"
          >
              Add Item
          </button>
      </div>
      <div class="card my-2 table p-0 table-responsive col-12 mx-auto elevation-2"  style="max-height:450px">
          <table class="table table-hover table-sm table-bordered nowrap text-dark">
              <thead class="thead-fixed bg-dark text-white to-fixed">
                  <tr>
                      <th>S/N</th>
                      <th>Name</th>
                      <th>QTY</th>
                      <th>Units</th>
                      <th>Rate</th>
                      <th>Amount</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="item in expenseItems" v-bind:key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.name}}</td>
                      <td>{{item.quantity}}</td>
                      <td>{{item.units}}</td>
                      <td>{{item.rate  | currency}}</td>
                      <td>{{item.amount | currency}}</td>
                      <td class="text-center" style="max-width:75px;">
                        <button class="btn btn-xs btn-info"
                        v-on:click="editExpItem(item)"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-xs btn-danger"
                        v-on:click="deleteExpItem(item)"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                      </td>
                  </tr>
                  <tr v-if="expenseItems.length == 0">
                      <td colspan="7" class="text-center">
                          No Items
                      </td>
                  </tr>
              </tbody>
              <tfoot class="bg-dark text-white">
                  <tr>
                      <th colspan="7">Total : {{expenseTotal | currency}}</th>
                  </tr>
              </tfoot>
          </table>
      </div>
  </div>
</template>

<script>
import {mapState, mapActions, mapMutations,} from 'vuex'
export default {
 computed:{
     ...mapState({
         expenseItems:"expenseItems",
         expenseTotal:"expenseTotal"
     })
 },
 methods:{
     editExpItem(item){
         this.selectExpItem(item)
         this.selectExpItemComponent("item-editor-expense")
     },
     createExpItem(){
         this.selectExpItem()
         this.selectExpItemComponent("item-editor-expense")
     },
     ...mapActions({
         deleteExpItem:"deleteExpItemAction"
     }),
     ...mapMutations({
         selectExpItem:"selectExpItem",
         selectExpItemComponent:"expNav/selectExpItemComponent",
     })
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
