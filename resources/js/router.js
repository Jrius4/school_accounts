import Vue from 'vue';
import Router from 'vue-router';


// components
import ItemsStore from './components/items/Store.vue'
import Cities from './components/cities/Cities';
import CityEditor24 from './components/cities/CityEditor24';
import SimpleDisplay from './components/simple/SimpleDisplay'
import ListMaker from './components/simple/ListMaker'
import FigureSimple from './components/simple/FigureSimple'
import Profile from  './components/user/Profile'
import MakeExpense from './components/burser/expenses/MakeExpense'

Vue.use(Router);

function PageComponent(name){
    return {
        render:h=>h('h3',`Hello from ${name} page`)
    };
}

export default new Router({
    mode:'history',
    routes:[
        {
            path:"/portal/profile",component:Profile,name:'user'
        },
        {
            path:'/portal/cities',component:Cities,name:'cities'
        },
        {
            path:"/portal/:op(create|edit)/:id(\\d+)?",component:CityEditor24
        },
        {
            path:'/portal/contact',component:PageComponent('Contact'),name:'contact'
        },
        {
            path:'/portal/features',component:PageComponent('Features'),name:'features'
        },
        {
            path:"/portal/display",component:SimpleDisplay
        },
        {
            path:"/portal/list",component:ListMaker
        },
        {
            path:"/portal/numbers",component:FigureSimple
        },
        {
            path:"/portal/items",component:ItemsStore,name:'items-store'
        },
        // {
        //     path:"/portal/*",redirect:"/portal/d"
        //     // path:"/portal/*",redirect:"/portal/display"
        // },

        //burser
        {
            path:"/portal/make-expense",component:MakeExpense,name:"make-expense"
        },
    ]
})
