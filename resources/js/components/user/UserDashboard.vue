<template>
    <div>
        <h3>Student Dashboard</h3>
        <p>
            Welcome <span v-if="user !== null" class="font-italic">{{`${user.first_name}${user.given_name?" "+user.given_name:""} ${user.last_name}`}} </span><span v-if="user == null" class="font-italic">username</span>.
        </p>
    </div>
</template>

<script>
import Axios from 'axios'
export default {
    data:function(){
        return{
            user:null
        }
    },
    methods:{

    },
   async created(){
       this.$store.dispatch("getUserTokenAcion").then((response) => {
        }).catch((err) => {
            console.error(err)
        });
        this.$store.dispatch("getUserAction").then((response)=>{
            this.user = this.$store.state.user
        }).catch(err=>{
            console.log(err)
        });
   }

}
</script>

<style>

</style>
