import Vue from 'vue';
import VueRouter from 'vue-router';

import Burser from '../components/burser/Burser'
import MakeExpense from '../components/burser/expenses/MakeExpense'

Vue.use(VueRouter);

export default new VueRouter({
    routes :[
        {path:"/portal/burser",component:Burser},
        {path:"/portal/burser/make-expense",component:MakeExpense}
    ]
})
