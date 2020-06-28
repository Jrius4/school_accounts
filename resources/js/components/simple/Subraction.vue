<template>
  <div class="mx-auto p-2 border border-success col-md-10">
      <h3 class="text-white bg-success text-center p-2">
          Substraction
      </h3>
      <div class="container-fluid">
          <div class="row">
              <div class="col">
                <input class="form-control" v-colorize:bg-info.bg="first>45" v-model.number="first"/>
              </div>
              <div class="col-1 h3 text-center">-</div>
              <div class="col">
                  <input class="form-control" v-colorize:bg-info.bg="second>45"  v-model.number="second"/>
              </div>
              <div id="total" v-colorize.bg.text="displayTotal>50"  class="col h3"> = {{displayTotal}}</div>
          </div>
      </div>
  </div>
</template>

<script>
import {tween} from "popmotion";
// import Colorize from "./directives/colorize";
export default {
    data:()=>{
        return{
            displayTotal:30
        }
    },
    computed:{
        total(){
            return this.first-this.second;
        }
    },
    watch:{
        total(newVal,oldVal){
            let classes = ["animated","fadeIn"];
            let totalElem = this.$el.querySelector('#total');
            totalElem.classList.add(...classes);
            let t = tween({
                from:Number(oldVal),
                to:Number(newVal),
                duration:250
            });
            t.start({
                update:(val)=>this.displayTotal = val.toFixed(0),
                complete:()=>totalElem.classList.remove(...classes)
                })
        }
    },

}
</script>
