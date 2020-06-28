<template>
    <div>
        <div class="form-group d-block col">
            <label>ID</label>
            <input type="text" class="form-control d-block col-12" disabled v-model="city.id">
        </div>
        <div class="form-group d-block col">
            <label>Country</label>
            <input type="text" class="form-control d-block col-12" v-model="city.country">
        </div>
        <div class="form-group d-block col">
            <label>District</label>
            <input type="text" class="form-control d-block col-12" v-model="city.state">
        </div>
        <div class="form-group d-block col">
            <label>City</label>
            <input type="text" class="form-control d-block col-12" v-model="city.city">
        </div>
        <div class="form-group col  btn-group">
            <button class="btn btn-dark" v-on:click="save">
                {{editing ? "Save":"Create"}}
            </button>
            <button class="btn btn-secondary" v-on:click="cancel">
                Cancel
            </button>
            <!-- <router-link v-if="editing" v-bind:to="nextUrl" class="btn btn-dark">
                Next
            </router-link> -->

        </div>
    </div>
</template>

<script>
let unwatcher;
export default {
 data:function(){
     return {
         editing:false,
         city:{}
     }
 },
 computed:{
    //  nextUrl(){
    //      if(this.city.id!=null && this.$store.state.cities !=null){
    //          let index = this.$store.state.cities.findIndex(c=>c.id == this.city.id);
    //          let target = index<this.$store.state.cities.length - 1?index+1:0
    //          return `/edit/${this.$store.state.cities[target].id}`;
    //      }
    //      return "/edit";
    //  }
 },
 methods:{
     async save(){
         await this.$store.dispatch("saveCityAction",this.city);
         this.$store.commit("nav/selectComponent","table")
        this.city = {};

     },
     cancel(){
            this.$store.commit("selectCity");
            this.$store.commit("nav/selectComponent","table")
     },
     selectCity(selectedCity){
         if(selectedCity == null ){
             this.editing = false;
             this.city = {};
         }

         else{
             this.editing = true;
             this.city = {};
             Object.assign(this.city,selectedCity);
         }
     }
 },
 created(){
     unwatcher = this.$store.watch(state=>
     state.selectedCity,this.selectCity
     );
     this.selectCity(this.$store.state.selectedCity);
 },
 beforeDestroy(){
     unwatcher();
 }
}
</script>

