<template>
  <div class="container">
      <div class="input-group mb-3">
          <input type="text" v-model="query"
            class="form-control" aria-label="employee name or username"
            aria-describedby="basic-addon2"
          />
          <div class="input-group-append">
              <button type="button" class="btn btn-dark"
              @click="searchEmployees" @keyup.enter="searchEmployees">
                  Search
              </button>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name:'SearchBar',
    data(){
        return {
            query:''
        };
    },
    watch:{
        query:{
            handler:_.debounce(function(){
                this.searchEmployees();
            },100)
        }
    },
    methods:{
        searchEmployees(){
            if(this.query !== ''){
                this.$store.dispatch('searchEmployeesAction',this.query);
            }
            else{
                this.$store.state.employees = []
            }

        }
    }
}
</script>

<style>

</style>
