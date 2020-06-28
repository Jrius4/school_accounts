<template>
    <div>
        <div class="row p-2">
            <h4 class="text-white m-2 col-3">Items</h4>
            <input type="text" class="form-control col-sm-6 ml-auto" placeholder="search item by name"
            v-model="keywords" v-model.lazy="keywords"
            >
        </div>
        <div v-for="item in items" v-bind:key="item.id" class="card m-1 p-1 bg-light">
            <h4>
                {{item.name}}
                <span class="badge badge-pill badge-primary float-right">
                    {{item.price | currency}}
                </span>
            </h4>

            <div class="card-text bg-white p-1">
                {{item.description}}
            </div>
        </div>
        <page-controls/>
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex'
import PageControls from "./PageControls"
export default {
    components:{PageControls},
    data:()=>{
        return {
            keywords:null,
        }
    },
    computed:{
        ...mapGetters({
            items:"processedItems"
        })
    },
    // watch:{
    //     keywords(after,before){
    //         this.fetch();
    //     }
    // },
    // methods:{
    //    async fetch(){
    //        await this.$store.dispatch("getSeachedItemsAction",this.keywords)
    //     }
    // },
    filters:{
        currency(value){
            return new Intl.NumberFormat('en-US',{
                style:"currency",currency:"UGX"
            }).format(value)
        }
    }
}
</script>

<style>

</style>
