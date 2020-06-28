<template>
  <div class="card table p-0 table-responsive"  style="max-height:450px">
      <table class="table table-hover table-sm table-striped table-bordered nowrap">
          <thead class="thead-fixed">
              <tr>
                  <th>ID</th>
                  <th>COUNTRY</th>
                  <th>STATE</th>
                  <th>CITY</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              <tr v-for="c in cities" v-bind:key="c.id">
                  <td>{{c.id}}</td>
                  <td>{{c.country}}</td>
                  <td>{{c.state}}</td>
                  <td>{{c.city}}</td>
                  <td>
                      <button class="btn btn-sm btn-info"
                        v-on:click="editCity(c)">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger"
                        v-on:click="deleteCity(c)">
                        <i class="fas fa-times"></i>
                      </button>
                  </td>
              </tr>
              <tr v-if="cities.length == 0">
                  <td colspan="5" class="text-center">
                      No Data
                  </td>
              </tr>
          </tbody>

      </table>
      <div>
          <button class="btn btn-block btn-primary" v-on:click="createNew">
              Create New
          </button>
      </div>
  </div>
</template>

<script>
import Vue from "vue"
export default {
    data:function(){
        return {
            cities:[]
        }
    },
    methods:{
        createNew(){
            this.eventBus.$emit("create")
        },
        editCity(city){
            this.eventBus.$emit("edit",city);
        },
        async deleteCity(city){
            await this.restDataSource.deleteCity(city);
            let index = this.cities.findIndex(c=>c.id == city.id);
            this.cities.splice(index,1);
        },
        processCities(newCities){
            this.cities.splice(0);
            this.cities.push(...newCities)
        },

        async processComplete(city){
            let index = this.cities.findIndex(c=>c.id == city.id);
            if (index == -1) {
               let newCity = (await this.restDataSource.saveCity(city));
                this.cities.unshift(newCity)
            }
            else{
               let updateCity = (await this.restDataSource.updateCity(city));
                Vue.set(this.cities,index,updateCity);
            }
        }

    },
    inject:["eventBus","restDataSource"],
    async created(){
        this.processCities(await this.restDataSource.getCities());

        this.eventBus.$on("complete",this.processComplete);

    }
}
</script>

