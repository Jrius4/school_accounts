<template>
<div>
    <div class="text-center m-2">
        <div class="btn-group btn-group-sm">
            <router-link
                tag="button" :to="{name:'make-expense'}" exact-active-class="btn-info"
                class="btn btn-secondary"
                >
                    Make Expense
            </router-link>
            <router-link :to="{name:'user'}"
                 exact-active-class="btn-warning"
                tag="button"   class="btn btn-secondary"
                >
                Profile
            </router-link>
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
export default{
    name:'Burser',
    data:function(){

        return{

        }
    }
}
</script>
