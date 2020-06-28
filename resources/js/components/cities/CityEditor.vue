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
            <label>State</label>
            <input type="text" class="form-control d-block col-12" v-model="city.state">
        </div>
        <div class="form-group d-block col">
            <label>City</label>
            <input type="text" class="form-control d-block col-12" v-model="city.city">
        </div>
        <div class="form-group d-block col">
            <button class="btn btn-block btn-dark col-12" v-on:click="save">
                {{editing ? "Save":"Create"}}
            </button>
            <button class="btn btn-block btn-secondary col-12" v-on:click="cancel">
                Cancel
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data:function() {
        return {
            editing:false,
            city:{}
        }
    },
    methods:{
        startEdit(city){
            this.editing = true;
            this.city = {
                id:city.id,
                country:city.country,
                state:city.state,
                city:city.city,
            }
        },
        startCreate(){
            this.editing = false;
            this.city = {}
        },
        save(){
            this.eventBus.$emit("complete",this.city);
            this.startCreate();
        },
        cancel(){
            this.city = {};
            this.editing = false;
        }
    },
    inject:['eventBus'],
    created(){
        this.eventBus.$on("create",this.startCreate);
        this.eventBus.$on("edit",this.startEdit);
    }
}
</script>

<style>

</style>
