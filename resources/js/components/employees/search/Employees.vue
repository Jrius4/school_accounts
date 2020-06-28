<template>
  <div class="container">
      <h5>Employess</h5>
      <div class="row" v-for="(employees, index) in groupEmployees" :key="index">
          <div class="col-12" v-for="(employee,i) in employees" :key="i">
              <employee class="animated  fadeIn" :employee="employee"/>
          </div>

      </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import Employee from './Employee';
export default {
    name:'Employees',
    components:{
        Employee
    },
    mounted(){
        // this.$store.dispatch('getEmployeesAction');
    },
    computed:{
        ...mapGetters([
            'employees'
        ]),

        groupEmployees(){
            console.log({emp:this.employees});
            return _.chunk(this.employees,4)
        },

    }

}
</script>

<style>

</style>
