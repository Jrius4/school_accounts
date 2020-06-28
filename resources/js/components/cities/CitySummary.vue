<template>
  <div>
    <h3 class="bg-success text-center text-white p-2 font-italic">
          Summary
    </h3>
    <table class="table">
        <tr>
            <th>Number Of City:</th>
            <td>{{cities.length}}</td>
        </tr>
        <tr>
            <th>Country With Most Citys:</th>
            <td>{{ 230000| currency}}</td>
        </tr>
    </table>
  </div>
</template>

<script>
import { mapState, } from "vuex";
export default {
    data:function(){
        return{
            country:"Uganda",
            Origin:"Kampala",
        }
    },
    computed:{
        ...mapState(["cities"]),

    },
    filters:{
        currency(value){
            return new Intl.NumberFormat("en-US",
            {style:"currency",currency:'USD'}).format(value)
        }
    }
}
</script>

<style>

</style>
