<template>
<v-app>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 bg-dark text-center font-italic">
            <a href="" class="mavbar-brand">Make Expense</a>
        </div>
        <div class="col-lg-6 col-md-6 blue-grey p-2  mx-auto">
            <v-sheet class="m-2 p-2 blue-grey lighten-3">
                <h3 class="text-center">Tasks' Schedules</h3>
            </v-sheet>
            <v-sheet>
                <task-calendar/>
            </v-sheet>
        </div>



        <div class="col-lg-6 col-md-6 text-dark p-2 blue-grey mx-auto">
            <v-sheet class="m-2 p-2 blue-grey lighten-3 black--text">
                <h3 class="text-center">Expense Form</h3>
            </v-sheet>

            <v-sheet>
                    <div class="form-group col-12 d-block">

                    <v-sheet class="bg-transparent">
                        <v-form>
                            <v-select
                                id="expenseType"
                                ref="expenseType"
                                :rules="rules"
                                v-model="expenseType" :items="typesExpense"
                                attach clearable
                                label="Expense Type"
                                hint="Please select expense type"
                                v-on:change="handleExpenseType()"
                            ></v-select>
                            <small v-if="errExpenseType.includes('Please Select Expense Type!')" class="text-danger col-12">
                                {{errExpenseType}}
                            </small>
                            <small v-else class="text-success col-12">
                                {{errExpenseType}}
                            </small>
                        </v-form>
                    </v-sheet>

                </div>

                <transition

                >
                    <div class="col-12" v-if="expenseType === 'Welfare' || expenseType === '...others'">
                        <h3 class="text-dark display-6 m-2">Items</h3>
                        <div class="row d-flex justify-content-center mx-auto">
                            <div class="col">
                                <component v-bind:is="selectedComponent"></component>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" v-else>

                            <h3 class="text-dark m-2">Salary Form</h3>
                            <div class="form-group col-12 d-block">

                                <v-select
                                        id="expenseTypeTerm"
                                        ref="expenseTypeTerm"
                                        v-model="expenseTypeTerm" :items="[{'id':1,'name':'Term 1'},{'id':2,'name':'Term 2'},{'id':3,'name':'Term 3'}]"
                                        attach clearable
                                        label="Select Term" item-text="name"
                                        color="ml-3 mr-12 white--text"
                                        hint="Please select expense type"
                                        v-on:change="handleExpenseTypeTerm()"
                                    ></v-select>
                                    <small v-if="errExpenseTypeTerm.includes('Please Select Term!')" class="text-danger col-12">
                                        {{errExpenseTypeTerm}}
                                    </small>
                                    <small v-else class="text-success col-12">
                                        {{errExpenseTypeTerm}}
                                    </small>
                            </div>
                            <div class="form-group col-12 d-block">
                                    <v-autocomplete
                                        id="worker"
                                        v-model="worker"
                                        label="Find Employee"
                                        :items="employees"
                                        :search-input.sync="employeeSearch"
                                        :item-text="textEmployee"
                                        autocomplete
                                        append-icon="mdi-database-search"
                                        :menu-props="{ bottom: true, offsetY: true }"
                                        hint="Please Search Employee"
                                        chips attach clearable
                                        v-on:change="handleEmployeeSearch()"
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
                                                <v-img :src="`/files/${data.item.image!== null?data.item.image:'user_all.png'}`"></v-img>
                                            </v-avatar>
                                            {{ data.item.name }}
                                            </v-chip>
                                        </template>

                                        <template v-slot:item='{item}'>
                                            <v-row align="center" justify="center">
                                                <v-col cols="12" sm="3">
                                                    <img width="35" height="35" class="img-circle" :src="`/files/${item.image!== null?item.image:'user_all.png'}`"/>
                                                </v-col>
                                                <!-- <v-spacer></v-spacer> -->
                                                <v-col cols="12" sm="6" class="mx-1">
                                                    <h4 v-html='`${item.name} ${item.wage_salary}`'/>
                                                </v-col>
                                            </v-row>

                                        </template>
                                    </v-autocomplete>

                            </div>
                            <div v-if="this.employee.roles.length > 0" class="col-12 d-block">
                                <h4 class="text-left">Roles</h4>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Titles</th>
                                            <td>
                                                <h6 v-for="role in this.employee.roles" :key="role.id">
                                                    {{`${role.display_name}`.toLowerCase()}}
                                                </h6>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div v-if="this.workerSalary !== null" class="col-12 d-block">
                                <h4 class="text-left">Salary Summary</h4>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <th>Salary</th>
                                            <td>
                                                <h6>
                                                    {{workerSalary.wage_salary | currency}}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Balance</th>
                                            <td>
                                                <h6>
                                                    {{workerSalary.wage_balance | currency}}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Advance Pay</th>
                                            <td>
                                                <h6>
                                                    {{workerSalary.wage_upfront | currency}}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Advance Loan</th>
                                            <td>
                                                <h6>
                                                    {{workerSalary.wage_loan | currency}}
                                                </h6>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-12 d-block">
                                <label>Employee Wage</label>
                                <input class="form-control col-12" v-model="formatWageAmount" disabled/>
                            </div>
                            <div>
                                <v-select
                                label="Salary Payment Type"
                                v-model="payType"
                                class="ml-3 mr-12 ligth-blue-text text--darken-3"
                                :items="['Normal','Advance','Loan']"
                                attach clearable
                                hint="Please select Salary Payment type"
                                ></v-select>
                            </div>

                            <div class="form-group col-12 d-block">
                                <v-text-field label="Pay" :rules="payRules" id="wagePaid"  v-model="formatPaymentAmount"></v-text-field>
                                <small v-if="errEmployee.includes('Please Select Employee!')" class="text-danger col-12">
                                        {{errEmployee}}
                                    </small>
                                    <small v-else class="text-success col-12">
                                        {{errEmployee}}
                                    </small>
                            </div>
                            <div class="form-group col-12 d-block" v-if="payType==='Normal'">
                                <label>Salary Balance</label>
                                <input class="form-control col-12" v-model="formatBalanceAmount" disabled/>
                            </div>
                            <div class="col-12 d-block" v-if="payType === 'Advance'">
                                <v-text-field :disabled="true" label="Salary Advance" v-model="formatPaymentAdvanceAmount"></v-text-field>

                            </div>
                            <div class="col-12 d-block" v-if="payType === 'Loan'">
                                <v-text-field :disabled="true" label="Salary Loan" v-model="formatPaymentLoanAmount"></v-text-field>
                            </div>

                    </div>
                </transition>
            </v-sheet>
        </div>
        <div class="col-12 my-2">
                <div class="row col-12 mx-auto blue-grey lighten-3">
                    <div class="form-group col-sm-6 d-block">
                        <label for="">Term Spending</label>
                        <select id="term" class="form-control col" v-model="term" :class="termSelection">
                            <option value="">Select Term</option>
                            <option v-for="i in terms" v-bind:key="i.id" :value="i.id">{{i.name}}</option>
                        </select>
                        <small v-if="errTerm.includes('term') && bothSelected" class="text-danger col-12">
                            {{errTerm}}
                        </small>
                    </div>
                    <div class="form-group col-sm-6 d-block float-right">
                        <label for="">Account Spending</label>
                        <select id="account" class="form-control col" :class="accountSelection"  v-model="account">
                            <option value="">Select Account</option>
                            <option v-for="acc in accounts" v-bind:key="acc.id">{{acc.name}}</option>
                        </select>
                        <small v-if="errAccount.includes('account') && bothSelected" class="text-danger col-12">
                            {{errAccount}}
                        </small>
                    </div>
                </div>
                <borrow-display :term="term" :account="account" :accounts="accounts"/>
                <div class="row my-2">
                    <div class="form-group col-sm-12 d-block">
                        <label>Requested By:</label>
                        <input type="text" class="form-control col-12" v-model="expenseInfo.requestedBy" placeholder="requested by"/>
                    </div>
                    <div class="form-group col-sm-12 d-block">
                        <label>Description:</label>
                        <textarea cols="30" rows="10"  class="form-control col-12" placeholder="description" v-model="expenseInfo.overview"></textarea>
                    </div>
                    <div class="form-group col-sm-12 d-block">
                        <button class="btn btn-block btn-dark" v-on:click="makeExpense">
                            Make Expense
                        </button>
                        <button class="btn btn-block btn-dark" v-on:click="makeExpenseReset">
                            Cancel
                        </button>
                    </div>
                </div>
        </div>
    </div>

</div>
</v-app>
</template>

<script>
import { mapMutations, mapState } from 'vuex';
import ItemDisplayExpense from './ItemDisplayExpense';
import ItemEditorExpense from "./ItemEditorExpense";
import BorrowDisplay from "./borrow/BorrowDisplay";
import AutoComplete from "../../common/Autocomplete2"
export default {
    name:"MakeExpense",
    data:function(){
        return{

            term:"",
            rules:[],
            payRules:[
                value=>!!value || 'Required.',
                value=>(value||'').length > 4 || 'Min 4 chacters',

                // value=>{

                    // value = this.employee.wagePaid
                    // const regex = /UGX/gi
                    // const regex3 = / /gi

                    // let value2 = value.replace(regex,"");
                    // value = value2.replace(regex3,"");
                    // console.log({value});
                    // const pattern = /^[0-9]+$/;
                    // return pattern.test(value) || 'Invalid amount';

                // },
                // value=>value>10000 || "Amount must be great than 10000",
            ],
            expenseTypeTerm:{'id':1,'name':'Term 1'},
            typesExpense:['Salary','Welfare','...others'],
            expenseType:"Salary",
            errExpenseType:"",
            errExpenseTypeTerm:"",
            worker:"",
            isWorkerLoading: false,
            searchWorker:null,
            employeeSearch:null,
            workerSelection:null,
            workerSalary:null,
            payType:'Normal',
            employeeItemsEntries:[],
            employee:{id:'',name:"",wage:0,wagePaid:0,wageBalance:0,wageAdvance:0,wageLoan:0,roles:[]},

            account:"",
            errAccount:"",
            errTerm:"",
            errEmployee:"Please Select Employee!",
            expenseInfo:{
                requestedBy:"",
                overview:""
            }
        }
    },
    components:{ItemDisplayExpense,ItemEditorExpense,BorrowDisplay,AutoComplete},
    created(){
        this.$store.dispatch('getExpenseItemAction');
        this.$store.dispatch('getAccountsAction');
    },
    methods:{

        ...mapMutations({
            selectExpItemComponent:"expNav/selectExpItemComponent"
        }),
        makeExpense:function(){
            let newFormData = {};
            if(this.expenseType === 'Salary'){
                Object.assign(newFormData,
                {
                    'ExpenseType':this.expenseType,
                    'salaryTerm':this.expenseTypeTerm,
                    'worker':this.workerSalary,
                    'salaryPaymentType':this.payType,
                    'accountSendFrom':this.account,
                    'expenseTerm':this.term,
                    'expenseTotal':this.$store.state.expenseTotal,
                    'requested_by':this.expenseInfo.requestedBy,
                    'overview':this.expenseInfo.overview,
                    'makeBorrowItems':(this.$store.state.makeBorrowItems.length>0?this.$store.state.makeBorrowItems:[]),
                    'totalBorrow':(this.$store.state.makeBorrowItems.length>0?this.$store.state.expNav.totalBorrowed:0),
                    'makeLoanBorrowItems':(this.$store.state.makeLoanBorrowItems.length>0?this.$store.state.makeLoanBorrowItems:[]),
                    'totalBorrowLoan':(this.$store.state.makeLoanBorrowItems.length>0?this.$store.state.expNav.totalCreditLoan:0),
                }
                );

            }
            else if(this.expenseType !== 'Salary'){

                    Object.assign(newFormData,
                {
                    'ExpenseType':this.expenseType,
                    'expenseItems':this.$store.state.expenseItems,
                    'accountSendFrom':this.account,
                    'expenseTerm':this.term,
                    'expenseTotal':this.$store.state.expenseTotal,
                    'requested_by':this.expenseInfo.requested_by,
                    'overview':this.expenseInfo.overview,
                    'makeBorrowItems':(this.$store.state.makeBorrowItems.length>0?this.$store.state.makeBorrowItems:[]),
                    'totalBorrow':(this.$store.state.makeBorrowItems.length>0?this.$store.state.expNav.totalBorrowed:0),
                    'makeLoanBorrowItems':(this.$store.state.makeLoanBorrowItems.length>0?this.$store.state.makeLoanBorrowItems:[]),
                    'totalBorrowLoan':(this.$store.state.makeLoanBorrowItems.length>0?this.$store.state.expNav.totalCreditLoan:0),
                }
                );
            }
            this.$store.dispatch('storeMadeExpenseAction',newFormData);
            /**
            let newFormData = {
                borrowDetails:this.$store.state.borrowDetails,
                expenseItems:this.$store.state.expenseItems,
                makeBorrowItems:this.$store.state.makeBorrowItems,
                expenseInfo:this.expenseInfo,
                expenseTotal:this.$store.state.expenseTotal
            };
            this.$store.dispatch('storeMadeExpenseAction',newFormData);

            this.expenseInfo = {requestedBy:"",description:""};
            this.term = ""
            this.account = ""

            this.$router.push({name:'user'});*/
        },
        makeExpenseReset(){

        },
        handleExpenseTypeTerm(){
            let expTypeTerm = this.expenseTypeTerm;
            if(expTypeTerm){
                this.expenseTypeTerm = expTypeTerm;
                this.errExpenseTypeTerm = "Selected Term!";
            }
            else if(!expTypeTerm){
                    this.expenseTypeTerm = null;
                    this.errExpenseTypeTerm = "Please Select Term!";
            }

        },
        handleExpenseType(){
            let expType = this.expenseType;
            this.employee = {
                id:"",
                name:"",
                wage:0,
                wagePaid:0,
                wageBalance:0,
                wageAdvance:0,wageLoan:0,
                roles:[],
            };
            this.$store.state.employees = [];
            this.$store.state.expenseTotal = 0;
            this.$store.dispatch('RESET_EXPENSE_ACTION');
            this.worker = "";
            this.workerSelection = null;
            this.workerSalary = null;
            this.payType = 'Normal';
            if(expType){
                this.expenseType = expType;
                this.errExpenseType = "Selected Expense Type!";
            }
            else if(!expType){
                    this.expenseType = null;
                    this.errExpenseType = "Please Select Expense Type!";
            }

        },
        textEmployee(item){
            this.workerSelection = item;

            return item.name;
        },
        handleEmployeeSearch(){
            this.errEmployee = "Employee Selected"
            this.workerSalary = this.workerSelection;
            this.employee = {
                id:this.workerSelection.id,
                name:this.workerSelection.name,
                wage:this.workerSelection.wage_salary,
                wagePaid:this.workerSelection.wage_paid,
                wageBalance:this.workerSelection.wage_balance,
                wageLoan:this.workerSelection.wage_loan,
                wageAdvance:this.workerSelection.wage_upfront,
                roles:this.workerSelection.roles
            }
        },
        remove (item) {
            this.worker = "";
            this.workerSelection = null;
            this.workerSalary = null;
            this.employee = {
                id:"",
                name:"",
                wage:0,
                wagePaid:0,
                wageBalance:0,
                wageAdvance:0,wageLoan:0,
                roles:[],
            };
        },

        formatAsCurrency(value,dec){
            dec = dec || 0;
            if (value === null){
                return 0;
            }
            /**
             *  const pattern = /^[0-9]+$/;
                let pat = pattern.test(value);
                console.log({pat})
             *
            */



            return new Intl.NumberFormat("en-US",{
                style: "currency",currency: "UGx"
            }).format(value)
        },



    },
    computed:{
        ...mapState({
            terms:state=>state.expNav.terms,
            accounts:state=>state.expNav.accounts,
            selected:state =>state.expNav.selected,
            expSelection:state=>state.expNav.expSelection,
            employees:state=>state.employees,
        }),

        formatPaymentAmount:{
            get:function(){
                return this.formatAsCurrency(this.employee.wagePaid,0)
            },
            set:function(newValue){
                this.employee.wagePaid = Number(newValue.replace(/[^0-9\.]/g,''))
                this.$store.state.expenseTotal = this.employee.wagePaid

            }
        },

        formatBalanceAmount:{
            get:function(){
                this.employee.wageBalance = this.employee.wage - this.employee.wagePaid;
                return this.formatAsCurrency(this.employee.wageBalance,0);

            },
            set:function(newValue){
                this.employee.wageBalance = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },

        formatPaymentAdvanceAmount:{
            get:function(){
                let pt = this.payType;
                if(pt === 'Advance'){
                    this.employee.wageAdvance = this.employee.wagePaid;
                    return this.formatAsCurrency(this.employee.wageAdvance,0);
                }else{
                    this.employee.wageAdvance = 0;
                    return this.formatAsCurrency(this.employee.wageAdvance,0);
                }


            },
            set:function(newValue){
                this.employee.wageAdvance = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },
        formatPaymentLoanAmount:{
            get:function(){
                let pt = this.payType;
                if(pt === 'Loan'){
                    this.employee.wageLoan = this.employee.wagePaid;
                    return this.formatAsCurrency(this.employee.wageLoan,0);
                }else{
                    this.employee.wageLoan = 0;
                    return this.formatAsCurrency(this.employee.wageLoan,0);
                }

            },
            set:function(newValue){
                this.employee.wageLoan = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },

        formatWageAmount:{
            get:function(){
                return this.formatAsCurrency(this.employee.wage,0);

            },
            set:function(newValue){
                this.employee.wage = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },

        selectedComponent(){
            switch(this.selected){
                case "table":
                    return ItemDisplayExpense;
                case "item-editor-expense":
                    return ItemEditorExpense;
                default:
                    return ItemDisplayExpense;
            }
        },
        accountSelection(){
            if(this.term!=='' && this.account==='')
            {
                this.$store.state.borrowDetails= null;
                this.errAccount = "Please select account!";
                this.errTerm = "";

                return "is-invalid";
            }
            if(this.term==='' && this.account!== ''){
                this.$store.state.borrowDetails= null;
                this.$store.dispatch('getAccountsAction');
                return 'is-valid';
            }
            if(this.term!=='' && this.account!== ''){
                this.$store.dispatch('getAccountsAction');
                let accountSelected = {
                    term:this.term,
                    account:this.account,
                }

                this.$store.dispatch('SET_SELECTED_ACCOUNT_ACTION',accountSelected);
                return 'is-valid';

            }
        },
        termSelection(){
            if(this.term==='' && this.account!== '')
            {
                this.errTerm= "Please select term!"
                this.errAccount= ""
                this.$store.state.borrowDetails= null;
                return "is-invalid";
            }
            if(this.term!=='' && this.account===''){

                this.$store.state.borrowDetails= null;
                this.$store.dispatch('getAccountsAction');

                return 'is-valid';
            }
            if(this.term!=='' && this.account!== ''){
                this.$store.dispatch('getAccountsAction');

                let accountSelected = {
                    term:this.term,
                    account:this.account,
                }

                this.$store.dispatch('SET_SELECTED_ACCOUNT_ACTION',accountSelected);
                return 'is-valid';
            }
        },

        expenseTypeSelection(){
            if(this.$store.state.expenseItems.length>0 && this.expenseType === ''){
                this.errExpenseType = "Please Select Expense Type!";

                return 'is-invalid';
            }
            if(this.expenseType !== ''){
                this.errExpenseType = "Expense Type Selected";

                return 'is-valid';
            }

        },
        bothSelected(){
            if(this.term !== "" && this.account !== ""){

                this.errTerm ="";
                this.errAccount = "";
                return false;
            }
            else if(this.term === "" && this.account === ""){
                this.$store.state.borrowDetails= null;
                this.errTerm ="";
                this.errAccount = "";
                return false;
            }
            return true;

        },

        employeesItems(){
            return this.employeeItemsEntries.map(entry=>{
                const Name = entry.name.length > 8
            ? entry.name.slice(0, 8) + '...'
            : entry.name

          return Object.assign({}, entry, { Name })
            })
        },



    },
    watch:{
        selection(){
            this.term = this.$el.querySelector('#term');
            this.account = this.$el.querySelector('#account');
        },
        employeeSearch(val){
                // Items have already been loaded
            if (this.employeesItems.length > 0) return

            // Items have already been requested
            if (this.isWorkerLoading) return

            this.isWorkerLoading = true

            // Lazily load input items

            this.$store.dispatch('getEmployeesAction',val,5).finally(() => {
                this.isWorkerLoading = false;
                });
        },


    },
    created(){
        this.handleExpenseType();
        this.handleExpenseTypeTerm();
        this.employee = {id:'',name:"",wage:0,wagePaid:0,wageBalance:0,wageAdvance:0,wageLoan:0,roles:[]};
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
<style>
.autcompl{
    height:150px;
}
</style>
