<template>
  <div class="mx-5 border border-warning p-2">
    <h3 class="bg-warning text-white text-center p-2">Display</h3>
    <transition
    enter-active-class="animated fadeIn" leave-active-class="animated fadeOut"
    mode="out-in" key="hello"
    >
        <div v-if="show" class="font-italic bg-info text-center p-4">
            Hello, Kazibwe Julius Junior
        </div>
        <div v-else class="font-italic bg-success text-center p-4"
        key="goodbye"
        >
            Goodbye, Julius Junior
        </div>
    </transition>

      <div class="text-center">
          <button class="btn btn-primary" v-on:click="toggle">
              Toggle Visibility
          </button>
      </div>
      <div class="col-12 text-center">
          <button v-on:click="clickButton">
              Checkout Connection
          </button>
      </div>

  </div>
</template>

<script>

export default {

 data:function(){
     return{
         show:true
     }
 },
 methods:{
     toggle(){
         this.show=!this.show
     },
     clickButton:function(val){
         this.$store.dispatch('sendMessageAction','Hello')
         this.$socket.send('some data');
         this.$socket.sendObj({awesome:'data'});

     }
 }
}
</script>
<style>
.quick{animation-duration: 250ms;}
/* .v-leave-active{
    opacity: 0;
    font-size: 0em;
    transition: all 250ms;
}
.v-enter{
    opacity: 0;
    font-size: 0em;
}
.v-enter-to{
    opacity: 1;
    font-size: x-large;
    transition: all 250ms;
} */
</style>
