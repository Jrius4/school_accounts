<template>
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <base-material-card
                            icon="mdi-finance"
                            title="Overview Reports"
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
                                                    <v-list-item @click="typeSelected('weekly')">
                                                        <v-list-item-title>Weekly</v-list-item-title>
                                                    </v-list-item>
                                                    <v-list-item @click="typeSelected('monthly')">
                                                        <v-list-item-title>Monthly</v-list-item-title>
                                                    </v-list-item>
                                                    <v-list-item @click="typeSelected('yearly')">
                                                        <v-list-item-title>Yearly</v-list-item-title>
                                                    </v-list-item>
                                                    <v-list-item @click="typeSelected('interval')">
                                                        <v-list-item-title>By Interval</v-list-item-title>
                                                    </v-list-item>
                                                    </v-list>
                                                </v-menu>

                                                <v-spacer></v-spacer>


                                            </v-row>
                                        </template>
                                        <template v-slot:item.p_date="{item}">
                                            <span class="item">{{item.p_date|moment}}</span>
                                        </template>
                                         <template v-slot:item.inflow="{item}">
                                            <span class="item">{{item.inflow|currency}}</span>
                                        </template>
                                        <template v-slot:item.outflow="{item}">
                                            <span class="item">{{item.outflow|currency}}</span>
                                        </template>
                                        <template v-slot:item.diff="{item}">
                                            <span class="item">{{item.diff|currency}}</span>
                                        </template>
                                        <template v-if="type === 'interval'" v-slot:item.p_period="{item}">
                                            <span class="item">{{item.p_period | periodValue}}</span>
                                        </template>
                                        <template v-slot:item.action="{item}">
                                            <v-icon small fab class="mr-2 text-primary" color="blue" @click="viewItem(item)">
                                                fa fa-eye
                                            </v-icon>
                                        </template>

                                    </v-data-table>

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
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import SingleView from "./SingleView";
import moment from 'moment';
import {mapState} from 'vuex';
    export default {
        name:'Overview',
        components:{SingleView},
        data:()=>({
            payStep:1,
            searchPay:"",
            loadingPay:false,
            payStep:1,
            payStep:1,
            optionsPay:{},
            inputStartEnd:false,
            selectedPayment:null,
            type: 'daily',
            startDate:'',
            endDate:'',
            typeToLabel: {
                    daily: 'Daily',
                    weekly: 'Weekly',
                    monthly: 'Monthly',
                    yearly: 'Yearly',
                    interval: 'Interval',
                },

        }),
        computed:{
            ...mapState({
                payments:state=>state.incomeStatementsModule.payments,
                paymentPagination:state=>state.incomeStatementsModule.paymentPagination.page,
                totalpayments:state=>state.incomeStatementsModule.totalpayments,
                paymentSortRowsBy:state=>state.incomeStatementsModule.paymentSortRowsBy,
                period:state=>state.incomeStatementsModule.period,
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

                if(this.period === 'daily')
                {
                    return [
                        {text:'INFLOW',align:'left',sortable:true,value:'inflow'},
                        {text:'OUTFLOW',align:'left',sortable:true,value:'outflow'},
                        {text:'DIFFERENCE',align:'left',sortable:true,value:'diff'},
                        {text:'DATE',align:'left',sortable:true,value:'p_date'},
                    ]
                }

                if(this.period === 'weekly')
                {
                    return [
                        {text:'INFLOW',align:'left',sortable:true,value:'inflow'},
                        {text:'OUTFLOW',align:'left',sortable:true,value:'outflow'},
                        {text:'DIFFERENCE',align:'left',sortable:true,value:'diff'},
                        {text:'WEEK OF THE MONTH',align:'left',sortable:true,value:'p_week'},
                        {text:'MONTH OF THE YEAR',align:'left',sortable:true,value:'p_month'},
                        {text:'YEAR',align:'left',sortable:true,value:'p_year'},
                    ]
                }

                if(this.period === 'monthly')
                {
                    return [
                        {text:'INFLOW',align:'left',sortable:true,value:'inflow'},
                        {text:'OUTFLOW',align:'left',sortable:true,value:'outflow'},
                        {text:'DIFFERENCE',align:'left',sortable:true,value:'diff'},
                        {text:'MONTH OF THE YEAR',align:'left',sortable:true,value:'p_month'},
                        {text:'YEAR',align:'left',sortable:true,value:'p_year'},
                    ]
                }

                else if(this.period === 'yearly')
                {
                    return [
                        {text:'INFLOW',align:'left',sortable:true,value:'inflow'},
                        {text:'OUTFLOW',align:'left',sortable:true,value:'outflow'},
                        {text:'DIFFERENCE',align:'left',sortable:true,value:'diff'},
                        {text:'YEAR',align:'left',sortable:true,value:'p_year'},
                    ]

                }

                else if(this.period === 'interval')
                {
                    return [
                        {text:'INFLOW',align:'left',sortable:true,value:'inflow'},
                        {text:'OUTFLOW',align:'left',sortable:true,value:'outflow'},
                        {text:'DIFFERENCE',align:'left',sortable:true,value:'diff'},
                        {text:'Period',align:'left',sortable:true,value:'p_period'},
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
                                        period:this.type,
                                        start:this.startDate,
                                        end:this.endDate,
                                     }

                        this.$store.dispatch('incomeStatementsModule/GET_ITEMS_ACTION',pagination).finally(()=>{
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
                                            period:this.type,
                                            start:this.startDate,
                                            end:this.endDate,
                                        }

                                    this.$store.dispatch('incomeStatementsModule/GET_ITEMS_ACTION',pagination).finally(()=>{
                                        this.loadingAcc = false;
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
                                            period:this.type,
                                        }

                                    this.$store.dispatch('incomeStatementsModule/GET_ITEMS_ACTION',pagination).finally(()=>{
                                        this.loadingAcc = false;
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
                if(val === 'interval'){
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
            periodValue(val){
                return  val.split("_").map((item)=>{
                                return moment(item).format('Do MMM YYYY');
                            }).join(" to ");
            },
            moment: function (date) {
                return  moment(date).format('Do MMM YYYY');
            },
        }
    }
</script>

<style lang="css" scoped>
.item{
    font-size: 0.8rem;
}
</style>
