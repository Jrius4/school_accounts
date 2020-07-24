<template>
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <base-material-card
                            icon="mdi-finance"
                            title="Payments Overview"
                            color="indigo darken-3"
                            class="px-5 py-3 elevation-4"
                        >
                            <v-window v-model="payStep">
                                <v-window-item :value="1">
                                    <v-data-table
                                    dense
                                    :search="searchPay"
                                    item-key="paid_day" :headers="headersPay"
                                    :items="payments"
                                    sort-by="paid_day" class="mr-2"
                                    :loading="loadingPay"
                                    :options.sync="optionsPay"
                                    :items-per-page="paymentPagination.rowsPerPage"
                                    :server-items-length="totalpayments"
                                    >

                                        <template v-slot:top>
                                            <v-row flat>
                                                <v-col cols="12" sm="4">
                                                    <v-text-field
                                                    v-model="searchPay"
                                                    append-icon="mdi-database-search"
                                                    label="Quick Search"
                                                    clearable
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="2">
                                                    <v-btn small text="" color="blue" class="float-left mt-4" @click="refreshPayments">
                                                        <v-icon>mdi-refresh</v-icon> Refresh
                                                    </v-btn>
                                                </v-col>
                                                <div class="flex-grow-1"></div>

                                                <v-menu bottom right>
                                                    <template v-slot:activator="{ on }">
                                                    <v-btn outlined v-on="on" small>
                                                        <span>{{ typeToLabel[type] }}</span>
                                                        <v-icon right>mdi-menu-down</v-icon>
                                                    </v-btn>
                                                    </template>
                                                    <v-list>
                                                        <v-list-item @click="typeSelected('daily')">
                                                            <v-list-item-title>Daily</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('daily_by_group')">
                                                            <v-list-item-title>Daily By Groups</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('weekly')">
                                                            <v-list-item-title>Weekly</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('weekly_by_group')">
                                                            <v-list-item-title>Weekly By Groups</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('monthly')">
                                                            <v-list-item-title>Monthly</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('monthly_by_group')">
                                                            <v-list-item-title>Monthly By Groups</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('yearly')">
                                                            <v-list-item-title>Yearly</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('yearly_by_group')">
                                                            <v-list-item-title>Yearly By Groups</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('interval')">
                                                            <v-list-item-title>By Interval</v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item @click="typeSelected('interval_by_group')">
                                                            <v-list-item-title>By Interval Groups</v-list-item-title>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>

                                                <v-spacer></v-spacer>


                                            </v-row>
                                        </template>
                                        <template v-slot:item.paid_day="{item}">
                                            <span class="item">{{item.paid_day|moment}}</span>
                                        </template>
                                         <template v-slot:item.total_amount="{item}">
                                            <span class="item">{{item.total_amount|currency}}</span>
                                        </template>
                                        <template v-slot:item.action="{item}">
                                            <v-icon small fab class="mr-2 text-primary" color="blue" @click="viewItem(item)">
                                                fa fa-eye
                                            </v-icon>
                                        </template>

                                    </v-data-table>
                                </v-window-item>
                                <v-window-item :value="2">
                                    <v-row align="center" justify="center">
                                        <v-col cols="12" sm="6">
                                            <v-btn
                                                small
                                                color="indigo darken-3"
                                                class="btn-block elevation-3"
                                                @click="tablePayments"
                                                dark
                                            >
                                                View All Payments
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                    <v-row flat>
                                        <!-- <v-col v-if="selectedPayment!==null">
                                            <SingleView :payment="selectedPayment"/>
                                        </v-col> -->
                                    </v-row>
                                </v-window-item>
                            </v-window>
                        </base-material-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="12">
                        <echart-bar-graph categorial="true"
                        heading="Payments Line Graph"
                        :sourceInput="sourceInput"/>
                    </v-col>
                </v-row>


                <v-dialog v-model="inputStartEnd" max-width="500">
                    <v-card>
                        <v-container>
                            <v-form @submit.prevent="sendStartEnd">
                                <v-text-field v-model="startDate" required type="date" label="start (required)"></v-text-field>
                                <v-text-field v-model="endDate" required type="date" label="end (required)"></v-text-field>
                                <v-btn type="submit" dark color="teal" class="mr-4" @click.stop="inputStartEnd = false">
                                    Submit Interval
                                </v-btn>
                            </v-form>
                        </v-container>
                    </v-card>
                </v-dialog>

            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import SingleView from "./SingleView";
import moment from 'moment';
import {mapState} from 'vuex';
    export default {
        name:'ViewPayments',
        components:{SingleView},
        data:()=>({
            payStep:1,
            searchPay:"",
            loadingPay:false,
            payStep:1,
            payStep:1,
            optionsPay:{},
            selectedPayment:null,
            type: 'daily',
            typeToLabel: {
            daily: 'Daily',
            daily_by_group: 'Daily By Group',
            weekly: 'Weekly',
            weekly_by_group: 'Weekly By Group',
            monthly: 'Monthly',
            monthly_by_group: 'Monthly By Group',
            yearly: 'Yearly',
            yearly_by_group: 'Yearly By Group',
            day: 'Day',
            interval: 'Interval',
            interval_by_group: 'By Interval Group',
            },
            startDate:'',
            endDate:'',
            inputStartEnd:false,

        }),
        computed:{
            ...mapState({
                payments:state=>state.payments,
                paymentPagination:state=>state.paymentPagination.page,
                totalpayments:state=>state.totalpayments,
                queryType:state=>state.queryType,
            }),
            sourceInput(){
                let data = [];
                data.push(['amount','date']);

                setTimeout(()=>{
                    data.push(this.payments);
                },5000)
                return data;
            },
            headersPay(){

                if(this.queryType === 'daily')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'DATE',align:'left',sortable:false,value:'paid_day'},
                    {text:'WEEK OF THE MONTH',align:'left',sortable:false,value:'week_of_the_month'},
                    {text:'MONTH OF THE YEAR',align:'left',sortable:false,value:'month_of_the_year'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]
                }

                else if(this.queryType === 'daily_by_group')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'DATE',align:'left',sortable:false,value:'paid_day'},
                    {text:'WEEK OF THE MONTH',align:'left',sortable:false,value:'week_of_the_month'},
                    {text:'MONTH OF THE YEAR',align:'left',sortable:false,value:'month_of_the_year'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]

                }

                if(this.queryType === 'weekly')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'DATE',align:'left',sortable:false,value:'paid_day'},
                    {text:'WEEK OF THE MONTH',align:'left',sortable:false,value:'week_of_the_month'},
                    {text:'MONTH OF THE YEAR',align:'left',sortable:false,value:'month_of_the_year'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]
                }

                else if(this.queryType === 'weekly_by_group')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'Group',align:'left',sortable:false,value:'paymentType'},
                    {text:'WEEK OF THE MONTH',align:'left',sortable:false,value:'week_of_the_month'},
                    {text:'MONTH OF THE YEAR',align:'left',sortable:false,value:'month_of_the_year'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]

                }

                if(this.queryType === 'monthly')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'DATE',align:'left',sortable:false,value:'paid_day'},
                    {text:'WEEK OF THE MONTH',align:'left',sortable:false,value:'week_of_the_month'},
                    {text:'MONTH OF THE YEAR',align:'left',sortable:false,value:'month_of_the_year'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]
                }

                else if(this.queryType === 'monthly_by_group')
                {
                    return [
                            {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                            {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                            {text:'Group',align:'left',sortable:false,value:'paymentType'},
                            {text:'MONTH OF THE YEAR',align:'left',sortable:false,value:'month_of_the_year'},
                            {text:'YEAR',align:'left',sortable:false,value:'year'},
                        ]

                }

                else if(this.queryType === 'yearly')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]
                }

                else if(this.queryType === 'yearly_by_group')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'Group',align:'left',sortable:false,value:'paymentType'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'YEAR',align:'left',sortable:false,value:'year'},
                ]

                }
                else if(this.queryType === 'interval')
                {
                    return [
                    {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                    {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                    {text:'Interval',align:'left',sortable:false,value:'p_period'},
                ]

                }
                else if(this.queryType === 'interval_by_group')
                {
                    return [
                        {text:'COUNT',align:'left',sortable:false,value:'no_payments'},
                        {text:'Group',align:'left',sortable:false,value:'paymentType'},
                        {text:'TOTAL AMOUNT',align:'left',sortable:false,value:'total_amount'},
                        {text:'Interval',align:'left',sortable:false,value:'p_period'},
                    ]

                }




            },
        },
        methods:{
            getPayments(){
                this.loadingPay = true;
                return new Promise((resolve,reject)=>{
                    const { sortBy, sortDesc, page, itemsPerPage } = this.optionsPay;
                    let search = this.searchPay;
                    let pageNew = page;
                    let pagination = {};
                    if(!search){
                        search = "";
                        pagination = {
                                        val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0],
                                        queryType:this.type,
                                        start:this.startDate,
                                        end:this.endDate,
                                     }

                        this.$store.dispatch('GET_PAYMENTS_INCOME_ACTION',pagination).finally(()=>{
                            this.loadingPay = false;
                            this.startDate = '';
                                        this.endDate = '';
                        });
                    }
                    else if(search.length > 0){
                        if(pageNew > 1){
                                pageNew = this.payments.length ===0?1:pageNew;
                                this.loadingPay = true;
                                pagination = {
                                            val:search,
                                            page:pageNew,
                                            sortRowsBy:sortBy[0],
                                            rowsPerPage:itemsPerPage,
                                            sortDesc:sortDesc[0],
                                            queryType:this.type,
                                            start:this.startDate,
                                            end:this.endDate,
                                        }

                                    this.$store.dispatch('GET_PAYMENTS_INCOME_ACTION',pagination).finally(()=>{
                                        this.loadingPay = false;
                                        this.startDate = '';
                                        this.endDate = '';
                                    });

                        }
                        else{
                                pageNew = 1;
                                this.loadingAcc = true;
                                pagination = {
                                            val:search,
                                            page:pageNew,
                                            sortRowsBy:sortBy[0],
                                            rowsPerPage:itemsPerPage,
                                            sortDesc:sortDesc[0],
                                            queryType:this.type,
                                            start:this.startDate,
                                            end:this.endDate,
                                        }

                                    this.$store.dispatch('GET_PAYMENTS_INCOME_ACTION',pagination).finally(()=>{
                                        this.loadingPay = false;
                                        this.startDate = '';
                                        this.endDate = '';
                                    });

                        }
                    }

                });
            },
            sendStartEnd(){
                this.getPayments();
            },
            typeSelected(val){
                this.type = val;
                if(val === 'interval' || val === 'interval_by_group'){
                    this.inputStartEnd = true;
                }
                else{
                    this.getPayments();
                }
            },
            refreshPayments(){
                this.searchPay = "";
                this.getPayments();
            },
            viewItem(item){
                this.selectedPayment = item;
                this.payStep = 2;
            },
            tablePayments(item){
                this.selectedPayment = null;
                this.payStep = 1;
            }
        },
        mounted(){
            this.getPayments();
        },
        watch:{
            searchPay(val){
                if(!this.searchPay){
                    this.searchPay = "";
                }
                else if(!this.searchPay!== "") return this.getPayments();

            },
            optionsPay:{
                handler(){
                this.getPayments();
            },
            deep:true,
            }
        },
        filters:{
            currency(value){
                return new Intl.NumberFormat("en-US",{
                    style: "currency",currency: "UGX"
                }).format(value);
            },
            moment: function (date) {
                return  moment(date).format('Do MMM YYYY')
            },
        }
    }
</script>

<style lang="css" scoped>
.item{
    font-size: 0.8rem;
}
</style>
