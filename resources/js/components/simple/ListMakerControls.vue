<template>
  <tfoot>
      <!-- <transition
      v-on:beforeEnter="beforeEnter"
      v-on:after="afterEnter" mode="out-in"
      > -->
      <transition
      v-on:enter="enter" mode="out-in"
      >
      <tr v-if="showAdd" key="addcancel">
          <td></td>
          <td>
              <input class="form-control" v-model="currentItem"/>
          </td>
          <td>
            <button id="add" class="btn btn-sm btn-info" v-on:click="handleAdd">
                Add
            </button>
            <button id="cancel" class="btn btn-sm btn-secondary" v-on:click="showAdd = false">
                Cancel
            </button>
          </td>
      </tr>
      <tr v-else key="show">
          <td colspan="4" class="text-center">
              <button class="btn btn-sm btn-info" v-on:click="showAdd = true">
                  Show Add
              </button>
          </td>
      </tr>
      </transition>
  </tfoot>
</template>

<script>
import {styler,tween} from 'popmotion'
export default {
    data:function(){
        return{
            showAdd:false,
            currentItem:""
        }
    },
    methods:{
        handleAdd(){
            this.$emit('add',this.currentItem);
            this.showAdd = false
            this.currentItem=""
        },
        enter(el,done){
            if(this.showAdd){
                let t = tween({
                    from:{opacity:0},
                    to:{opacity:1},
                    duration:250
                });
                t.start({
                    update:styler(el).set,
                    complete:done
                })
            }
        }
        // beforeEnter(el){
        //     if(this.showAdd){
        //         el.classList.add("animated","fadeIn");
        //     }
        // },
        // afterEnter(el){
        //         el.classList.remove("animated","fadeIn");
        // },
    },

}
</script>
