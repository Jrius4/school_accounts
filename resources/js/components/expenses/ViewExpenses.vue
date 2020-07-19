<template>
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <base-material-card
                            icon="mdi-finance"
                            title="Payments"
                            color="indigo darken-3"
                            class="px-5 py-3 elevation-4"
                        >
                            <v-window v-model="payStep">
                                <v-window-item :value="1">
                                    <v-data-table
                                    dense
                                    :search="searchPay"
                                    item-key="sn" :headers="headersPay"
                                    :items="expenses"
                                    :sort-by="expenseSortRowsBy" class="mr-2"
                                    :loading="loadingPay"
                                    :options.sync="optionsPay"
                                    :items-per-page="expensePagination.rowsPerPage"
                                    :server-items-length="totalexpenses"
                                    >

                                        <template v-slot:top>
                                            <v-row flat>
                                                <v-col cols="12" sm=6>
                                                    <v-text-field
                                                    v-model="searchPay"
                                                    append-icon="mdi-database-search"
                                                    label="Quick Search"
                                                    clearable
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="4">
                                                    <v-btn small text color="blue" class="float-right" @click="refreshPayments">
                                                        <v-icon>mdi-refresh</v-icon>
                                                        Refresh
                                                    </v-btn>
                                                </v-col>

                                                <v-spacer></v-spacer>


                                            </v-row>
                                        </template>
                                        <template v-slot:item.paymentType="{item}">
                                            <span class="item">{{`${item.paymentType}`.toUpperCase()}}</span>
                                        </template>
                                        <template v-slot:item.term_id="{item}">
                                            <span class="item">{{item.term_id!==null?item.term.name:''}}</span>
                                        </template>
                                        <template v-slot:item.fullAmount="{item}">
                                            <span class="item">{{item.fullAmount|currency}}</span>
                                        </template>
                                         <template v-slot:item.balance="{item}">
                                            <span class="item">{{item.balance|currency}}</span>
                                        </template>
                                        <template v-slot:item.created_at="{item}">
                                            <span class="item">{{item.created_at|moment}}</span>
                                        </template>
                                        <template v-slot:item.created_id="{item}">
                                            <small>{{item.created_at}}</small>
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
                                        <v-col v-if="selectedPayment!==null">
                                            <SingleView :expense="selectedPayment"/>
                                        </v-col>
                                    </v-row>
                                </v-window-item>
                            </v-window>
                        </base-material-card>
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
        name:'ViewPayments',
        components:{SingleView},
        data:()=>({
            payStep:1,
            searchPay:"",
            loadingPay:false,
            payStep:1,
            payStep:1,
            optionsPay:{},
            headersPay:[
                {text:'SN',align:'left',sortable:true,value:'id'},
                {text:'TYPE',align:'left',sortable:true,value:'expensetype'},
                {text:'RECIEPT_NO',align:'left',sortable:true,value:'token'},
                {text:'REQUESTED BY',align:'left',sortable:true,value:'requested_by'},
                {text:'TERM',align:'left',sortable:true,value:'expenseTerm'},
                {text:'AMOUNT',align:'left',sortable:true,value:'expenseTotal'},
                {text:'DATE',align:'left',sortable:true,value:'created_at'},
                {text:'Action',align:'left',sortable:false,value:'action'},
            ],
            selectedPayment:null,

        }),
        computed:{
            ...mapState({
                expenses:state=>state.expenses,
                expensePagination:state=>state.expensePagination.page,
                totalexpenses:state=>state.totalexpenses,
                expenseSortRowsBy:state=>state.expenseSortRowsBy,
            }),
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
                                    }

                                    this.$store.dispatch('GET_EXPENSES_FULL_ACTION',pagination).finally(()=>{
                                        this.loadingPay = false;
                                    });
                    }
                    else if(search.length > 0){
                        if(pageNew > 1){
                                pageNew = this.expenses.length ===0?1:pageNew;
                                this.loadingPay = true;
                                pagination = {
                                            val:search,
                                            page:pageNew,
                                            sortRowsBy:sortBy[0],
                                            rowsPerPage:itemsPerPage,
                                            sortDesc:sortDesc[0],
                                        }

                                    this.$store.dispatch('GET_EXPENSES_FULL_ACTION',pagination).finally(()=>{
                                        this.loadingAcc = false;
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
                                        }

                                    this.$store.dispatch('GET_EXPENSES_FULL_ACTION',pagination).finally(()=>{
                                        this.loadingAcc = false;
                                    });

                        }
                    }

                });
            },
            refreshPayments(){
                this.searchPay = ""
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

                return  moment(date).format('Do MMM YYYY H:m:s')

            },
        }
    }
</script>

<style lang="css" scoped>
.item{
    font-size: 0.8rem;
}
</style>
