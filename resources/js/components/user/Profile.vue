<template>
  <h4 v-if="user!==null" class="font-itelic">{{user.username}}</h4>
</template>

<script>
import { mapState } from 'vuex'
export default {
    name:"Profile",
    computed:{
            ...mapState({
                    user:state=>state.user
                })

    }


}
</script>

<style>

</style>
