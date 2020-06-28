<template>
    <section class="container row d-flex justify-content-center col-lg-12">
        <div>
            <button class="btn btn-block btn-primary col-md-12 mx-auto" v-on:click="createNew">
                Create New
            </button>
        </div>
    <div class="card table p-0 table-responsive col-md-10 mx-auto"  style="max-height:450px">

      <table class="table table-hover table-sm table-bordered nowrap" v-bind:class="'table-striped' == useStripedTable">
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
                      <button class="btn btn-sm"
                      v-bind:class="editClass"
                        v-on:click="editCity(c)">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm"
                      v-bind:class="deleteClass"
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

  </div>
    </section>

</template>

<script>
import {mapState,mapMutations,mapActions,mapGetters} from "vuex"
export default {

    computed:{
        ...mapState(["cities"]),
        ...mapState({
            useStripedTable:state =>state.prefs.stripedTable
        }),
        ...mapGetters({
            tableClass:"prefs/tableClass",
            editClass:"prefs/editClass",
            deleteClass:"prefs/deleteClass",
        })

    },
    methods:{
        editCity(city){
            this.selectCity(city);
            this.selectComponent("editor");
        },
        createNew(){
            this.selectCity();
            this.selectComponent("editor");
        },
        ...mapMutations({
            selectCity:"selectCity",
            selectComponent:"nav/selectComponent",
            setEditButtonColor:"prefs/setEditButtonColor",
            setDeleteButtonColor:"prefs/setDeleteButtonColor"
        }),
        ...mapActions({
            deleteCity:"deleteCityAction"
        }),
    },
    created(){
        this.setEditButtonColor(false);
        this.setDeleteButtonColor(false);
    }
}
</script>
