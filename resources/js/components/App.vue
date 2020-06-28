<template>
    <div id="app">
        <div class="row">
            <div class="col"><error-display/></div>
        </div>
        <div class="text-center m-2">
            <div class="btn-group btn-group-sm">
                <router-link :to="{name:'user'}"
                 exact-active-class="btn-warning"
                tag="button"   class="btn btn-secondary"
                >Profile</router-link>
                <router-link :to="{name:'cities'}"
                 exact-active-class="btn-info"
                tag="button"   class="btn btn-secondary"
                >Cities</router-link>
                <router-link  exact-active-class="btn-light"
                 :to="{name:'contact'}" tag="button" class="btn btn-secondary">Contact</router-link>
                <!-- <router-link :to="{name:'features'}" tag="button" class="btn btn-secondary"
                 exact-active-class="btn-info"
                >Features</router-link> -->
                <router-link
                tag="button" :to="{name:'make-expense'}" exact-active-class="btn-info"
                class="btn btn-secondary"
                >
                    Make Expense
                </router-link>
                <router-link
                tag="button" to="/portal/display" exact-active-class="btn-warning"
                class="btn btn-secondary"
                >
                    Simple Display
                </router-link>
                <router-link
                tag="button" to="/portal/list" exact-active-class="btn-info"
                class="btn btn-secondary"
                >
                    Todos
                </router-link>
                <router-link
                tag="button" :to="{name:'items-store'}" exact-active-class="btn-success"
                class="btn btn-secondary"
                >
                    Items Store
                </router-link>

                <!-- <router-link
                tag="button" to="/portal/numbers" exact-active-class="btn-success"
                class="btn btn-secondary"
                >
                    Numbers
                </router-link> -->
            </div>
        </div>


        <transition
        enter-active-class="animated fadeIn quick"
        leave-active-class="animated fadeOut quick" mode="out-in"
        appear  appear-active-class="animated zoomIn quick"
        >
            <router-view/>
        </transition>

    </div>
</template>

<script>
import ErrorDisplay from "./ErrorDisplay"
export default {
    components:{ErrorDisplay},
    data(){

        return{
            title:"Happy coding"
        }
    }
}
</script>
<style>
.quick{
    animation-duration: 250ms;
}
</style>

