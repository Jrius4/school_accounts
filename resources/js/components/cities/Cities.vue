<template>
  <div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb elevation-2">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cities</li>
        </ol>
    </nav>
      <section class="content">
          <div class="container">
              <div class="row">
                  <div class="col"><error-display/></div>
              </div>
              <h4 class="font-italic text-center">Cities</h4>

              <div class="row d-flex justify-content-center">
                  <div class="col text-center m-2">
                      <button class="btn btn-primary"
                       v-on:click="selectComponent('table')">
                        Standard Features
                      </button>
                      <button class="btn btn-success"
                       v-on:click="selectComponent('summary')">
                        Advanced Features
                      </button>
                  </div>
              </div>

              <div class="row d-flex justify-content-center">
                  <div class="col">
                         <component v-bind:is="selectedComponent"></component>

                  </div>
              </div>
          </div>

      </section>

  </div>
</template>

<script>
import CityEditor24 from "./CityEditor24";
import CityDisplay24 from "./CityDisplay24";
import ErrorDisplay from "../ErrorDisplay";
import LoadingMessage from "../LoadingMessage";

const CitySummary = () => ({
    component: import("./CitySummary"),
    loading:LoadingMessage,
    delay:100
});

import {mapState,mapMutations} from "vuex"


export default {
    name:"Cities",
    components:{CityEditor24,CityDisplay24,ErrorDisplay,CitySummary},
    created(){
        this.$store.dispatch("getCitiesAction")
    },
    methods:{
        ...mapMutations({
            selectComponent:"nav/selectComponent"
        })
    },
    computed:{
        ...mapState({
            selected:state => state.nav.selected
        }),
        selectedComponent(){
            switch (this.selected) {
                case "table":
                    return CityDisplay24;
                case "editor":
                    return CityEditor24;
                case "summary":
                    return CitySummary;


            }
        }
    }

}
</script>

<style>

</style>
