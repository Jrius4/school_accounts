<template>
  <div class="container-fluid">
    <div class="row my-2"
    v-for="cat in categories" v-bind:key="cat"
    >
        <button
        v-on:click="setCurrentCategory(cat)"
        v-bind:class="cat == currentCategory?'btn-primary':'btn-secondary'"

        >
        {{cat}}
        </button>
    </div>
  </div>
</template>

<script>
import {mapState,mapGetters,mapMutations} from 'vuex'
export default {
    computed:{
        ...mapState(["currentCategory"]),
        ...mapGetters(["categories"])
    },
    methods:{
        ...mapMutations(["setCurrentCategory"])
    }

}
</script>

<style>

</style>
