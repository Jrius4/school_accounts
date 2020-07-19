<template>
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row align="center" justify="center">
                    <v-sheet>
                        <h4 class="display-1">Payment form</h4>
                    </v-sheet>
                </v-row>
                <v-row align="center" justify="center">
                    <v-col cols="12">
                        <v-sheet>
                            <v-select
                            class="col-md-4"
                            v-model="paymentType"
                            :menu-props="{ bottom: true, offsetY: true }"
                            label="Type Of Payment"
                            :items="['Student','Asset','Loan']"
                            ></v-select>
                        </v-sheet>
                    </v-col>
                </v-row>
                <v-row flat v-show="paymentType==='Student'">
                    <v-col cols="12" md="6">
                        <v-autocomplete
                            id="studentAll"
                            v-model="student"
                            label="Search Student"
                            :loading="stLoading"
                            :items="students"
                            :search-input.sync="studentSearch"
                            :item-text="textStudent"
                            autocomplete
                            append-icon="mdi-database-search"
                            :menu-props="{ bottom: true, offsetY: true }"
                            hint="Please Search Student"
                            chips attach clearable
                            v-on:change="handleStudentSearch()"
                        >
                            <template v-slot:selection="data">
                                <v-chip
                                v-bind="data.attrs"
                                :input-value="data.selected"
                                close
                                @click="data.select"
                                @click:close="remove(data.item)"
                                >
                                <v-avatar left>
                                    <v-img :src="`/images/${data.item.image!== null?data.item.image:'user_all.png'}`"></v-img>
                                </v-avatar>
                                {{ `${data.item.name} ${data.item.schclass_id?'/ '+data.item.schclass.name:''}`}}
                                </v-chip>
                            </template>

                            <template v-slot:item='{item}'>
                                <v-row align="center" justify="center">
                                    <v-col cols="12" sm="3">
                                        <img width="35" height="35" class="img-circle" :src="`/images/${item.image!== null?item.image:'user_all.png'}`"/>
                                    </v-col>
                                    <!-- <v-spacer></v-spacer> -->
                                    <v-col cols="12" sm="6" class="mx-1">
                                        <h6 v-html='`${item.name} ${item.schclass_id?"/ "+item.schclass.name:""} ${item.roll_number}`'/>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" xl="7" lg="7" md="7" v-if="student !== ''">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2">Student's Fees Breakdown</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Class</th>
                                    <th>{{`${studentSelection.schclass_id?studentSelection.schclass.name:'no class'} / ${studentSelection.schstream_id?studentSelection.schstream.name:'no stream'}`}}</th>
                                </tr>
                                <tr>
                                    <th>
                                        School Fees
                                    </th>
                                    <th>
                                        {{`${studentSelection.fees_to_be_paid}`  | currency}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Balance
                                    </th>
                                    <th>
                                        {{`${studentSelection.fees_to_be_paid - studentSelection.amount_paid}`  | currency}}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </v-col>
                    <v-col cols="12" xl="7" lg="7" md="7" v-if="student === ''">

                        <v-text-field
                        v-model="studentName"
                        label="Student Name"
                        ></v-text-field>
                        <v-text-field
                        v-model="studentClass"
                        label="Student Class"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row flat justify="center" class="p-2 teal darken-3">
                    <v-col cols="12" md="6">
                        <v-sheet class="teal lighten-2 white--text">
                            <h4 class="text-center">Accounts</h4>
                        </v-sheet>
                        <v-sheet>
                            <base-material-card
                                icon="mdi-bank"
                                title="Accounts"
                                class="elevation-4"
                            >
                                <v-window v-model="accStep">
                                    <v-window-item :value="1">
                                        <v-data-table
                                            dense
                                            :search="searchAcc"
                                            :item-key="accountSortRowsBy" :headers="headersAcc"
                                            :items="accounts"
                                            :sort-by="accountSortRowsBy" class="mr-2"
                                            :loading="loadingAcc"
                                            :options.sync="optionsAcc"
                                            :items-per-page="accountPagination.rowsPerPage"
                                            :server-items-length="totalaccounts"

                                        >
                                                <template v-slot:top>
                                                    <v-row flat>
                                                        <v-col cols="8">
                                                            <v-text-field
                                                            v-model="searchAcc"
                                                            append-icon="mdi-magnify"
                                                            label="Quick Search"
                                                            clearable
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col cols="4">
                                                            <v-btn small text color="blue" @click="refreshAcc">
                                                                <v-icon>mdi-refresh</v-icon>
                                                                Refresh
                                                            </v-btn>
                                                        </v-col>

                                                        <v-spacer></v-spacer>


                                                    </v-row>
                                                </template>
                                                <template v-slot:item.account_name="{item}">
                                                    <span>{{ item.account_name}}</span>
                                                </template>
                                                <template v-slot:item.amount="{item}">
                                                    <span>{{ item.amount | currency}}</span>
                                                </template>
                                                <template v-slot:item.acc_category_id="{item}">
                                                    <span>{{ item.acc_category_id !== null ?item.acc_category.name:null}}</span>
                                                </template>

                                                <template v-slot:item.action="{item}">
                                                    <v-btn small class="mr-1" color="teal darken-3" dark @click="viewItem(item)">
                                                        Deposit
                                                    </v-btn>
                                                </template>
                                            </v-data-table>
                                    </v-window-item>
                                    <v-window-item :value="2">
                                        <v-row>
                                            <v-col cols="12">
                                                <v-btn small dark color="teal darken-3" class="btn-block" @click="tableAcc">
                                                    Back To Table
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Structures</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-if="accountSelected!==null">
                                                        <tr v-for="(fee,ind) in accountSelected.fee_structures" :key="`acc-${ind}`">
                                                            <th>{{fee.structure_name}}</th>
                                                            <th>{{fee.amount |currency}}</th>
                                                        </tr>
                                                        <tr v-if="accountSelected.fee_structures.length === 0">
                                                            <th colspan="2">No Structure</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </v-col>
                                        </v-row>
                                        <v-row flat>
                                            <v-col cols="12">
                                                <v-text-field
                                                v-model="amountDepositFormat"
                                                label="Amount Deposited"
                                                ></v-text-field>
                                                <v-text-field
                                                v-model="amountBalanceFormat"
                                                label="Amount Balance"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-btn small dark color="teal darken-3" class="btn-block" @click="savePayment">
                                                    Save
                                                </v-btn>
                                                <v-btn small dark color="grey darken-3" class="btn-block" @click="cancelPayment">
                                                    Cancel
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-window-item>
                                </v-window>
                            </base-material-card>
                        </v-sheet>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-sheet class="teal lighten-2 white--text">
                            <h4 class="text-center">Activate Payments</h4>
                        </v-sheet>
                        <v-sheet>
                            <v-row>
                                <v-col cols="12">
                                    <table class="table table-sm" style="font-size:0.8rem">
                                        <thead>
                                            <tr>
                                                <th colspan="4">Payments</th>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(fee,ind) in activePayments" :key="`fee-${ind}`">
                                                <th>{{fee.account_name}}</th>
                                                <td>{{fee.deposited |currency}}</td>
                                                <td>{{fee.balance |currency}}</td>
                                                <td>
                                                    <v-btn small icon dark color="red" fab @click="removePayment(fee)">
                                                        <v-icon small>fas fa-trash</v-icon>
                                                    </v-btn>
                                                </td>
                                            </tr>
                                            <tr v-if="activePayments.length === 0">
                                                <th colspan="2">No Payment</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </v-col>
                            </v-row>
                        </v-sheet>
                    </v-col>
                </v-row>
                <v-row flat>
                    <v-col cols="12">
                        <v-text-field
                        v-model="paidBy"
                        label="Paid By"
                        ></v-text-field>
                        <v-text-field
                        v-model="balance"
                        label="Amount Balance"
                        ></v-text-field>
                        <v-textarea
                         cols="6" rows="6"
                        v-model="description"
                        label="Description"
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12">
                        <v-btn small dark color="teal darken-3" class="btn-block" @click="savePayment">
                            Save
                        </v-btn>
                        <v-btn small dark color="grey darken-3" class="btn-block" @click="cancelPayment">
                            Cancel
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import {mapState} from 'vuex';
export default {
    name:'MakePayment',
    data:()=>({
        paymentType:'Student',
        student:'',
        stLoading:false,
        payingStudent:null,
        studentSearch:'',
        studentFound:false,
        studentSelected:null,
        studentSelection:null,
        studentName:"",
        studentClass:"",
        accStep:1,
        accountSelected:null,
        searchAcc:'',
        optionsAcc:{},
        loadingAcc:false,
        headersAcc:[
            {text:'Name',align:'left',sortable:true,value:'account_name'},
            {text:'Type',align:'left',sortable:false,value:'acc_category_id'},
            {text:'Balance',align:'left',sortable:true,value:'amount'},
            {text:'Action',align:'left',sortable:false,value:'action'},
        ],
        amountDeposit:'',
        amountBalance:'',
        activePayments:[],
        paidBy:"",
        balance:"",
        description:"",
    }),
    methods:{
        getAccounts(){
            this.loadingAcc = true;
            return new Promise((resolve,reject)=>{

                const { sortBy, sortDesc, page, itemsPerPage } = this.optionsAcc;

                let search = this.searchAcc;
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

                                this.$store.dispatch('GET_ACCOUNTS_ACTION',pagination).finally(()=>{
                                    this.loadingAcc = false;
                                });
                }
                else if(search.length > 0){
                    if(pageNew > 1){
                            pageNew = this.accounts.length ===0?1:pageNew;
                            this.loadingAcc = true;
                            pagination = {
                                        val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0],
                                    }

                                this.$store.dispatch('GET_ACCOUNTS_ACTION',pagination).finally(()=>{
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

                                this.$store.dispatch('GET_ACCOUNTS_ACTION',pagination).finally(()=>{
                                    this.loadingAcc = false;
                                });

                    }
                }

            });
        },
        loadPayment(){
            let index =  this.activePayments.findIndex(c=>c.account_name === this.accountSelected.account_name);
            if(index == -1){
                this.activePayments.push({
                    account_name:this.accountSelected.account_name,
                    deposited:this.amountDeposit,
                    balance:this.amountBalance,
                });
            }
            else{
                Vue.set( this.activePayments,index,{
                        account_name:this.accountSelected.account_name,
                        deposited:this.amountDeposit,
                        balance:this.amountBalance,
                    });
            }
        },
        getStudents(){
            let pagination={
                val:String(this.studentSearch).toLowerCase(),
                perPage:5
            }
            this.stLoading = true;
            this.$store.dispatch('GET_STUDENTS_ACTION',pagination).finally(() => {
                if(this.students.length == 0){
                   this.studentFound = false;
                }
                else{
                    this.studentFound = true;
                }
                this.stLoading = false;
            });

        },

        textStudent(item){
            this.studentSelected = item;

            return item.name;
        },
        handleStudentSearch(){
            this.studentSelection = this.studentSelected;
            if(!this.student){
                this.student = "";
                this.studentSelection=null;
                this.studentSelected = null;
            }
        },
        remove(){
            this.studentSelection = null;
            this.student = '';
        },
        refreshAcc(){
            this.searchAcc = "";
            this.getAccounts();
        },
        viewItem(item){
            this.accountSelected = item;
            this.accStep = 2;
        },
        tableAcc(){
            this.accStep = 1;
            this.accountSelected=null;
            this.amountDeposit = 0;
            this.amountBalance = 0;
        },
        formatAsCurrency(value,dec){
            dec = dec || 0;
            if (value === null){
                return 0;
            }
            return new Intl.NumberFormat("en-US",{
                style: "currency",currency: "UGX"
            }).format(value)
        },
        savePayment(){
            this.loadPayment();
            // this.activePayments.push({
            //     account_name:this.accountSelected.account_name,
            //     deposited:this.amountDeposit,
            //     balance:this.amountBalance,
            // });
            this.accStep = 1;
            this.accountSelected=null;
            this.amountDeposit = 0;
            this.amountBalance = 0;
        },
        removePayment(item){
            let index = this.activePayments.findIndex(
                c=>c.account_name === item.account_name);
            this.activePayments.splice(index,1);
            this.accStep = 1;
            this.accountSelected=null;
            this.amountDeposit = 0;
            this.amountBalance = 0;
        },
        cancelPayment(){
            this.accStep = 1;
            this.accountSelected=null;
            this.amountDeposit = 0;
            this.amountBalance = 0;
        }
    },
    computed:{
       ...mapState({
           students:state=>state.students,
           accounts:state=>state.accounts,
           accountPagination:state=>state.accountPagination,
           totalaccounts:state=>state.totalaccounts,
           accountSortRowsBy:state=>state.accountSortRowsBy,
       }),
       amountDepositFormat:{
           get:function(){
                if(this.amountDeposit !== null){
                    return this.formatAsCurrency(this.amountDeposit,0);
                }
            },
            set:function(newValue){
                this.amountDeposit = Number(newValue.replace(/[^0-9\.]/g,''));
            }
       },
       amountBalanceFormat:{
           get:function(){
                if(this.amountBalance !== null){
                    return this.formatAsCurrency(this.amountBalance,0);
                }
            },
            set:function(newValue){
                this.amountBalance = Number(newValue.replace(/[^0-9\.]/g,''));
            }
       },

    },
    mounted(){
        this.getAccounts()
    },
    watch:{
        studentSearch(val){
            if(!this.studentSearch){
                this.studentSearch = "";
            }
            if(this.studentSearch!==""){
                this.getStudents();
            }

        },
        searchAcc(val){
            if(!this.searchAcc){
                this.searchAcc = "";
            }
            if(this.searchAcc!==""){
                this.getAccounts();
            }

        },
        optionsAcc:{
            handler(){
                this.getAccounts();
            },
            deep:true,
        }
    },
    filters:{
        currency(value){
            return new Intl.NumberFormat("en-US",{
                style: "currency",currency: "UGX"
            }).format(value);
        }

    }
}
</script>
