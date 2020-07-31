<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row>
                    <v-col >
                       <base-material-card

                        icon="mdi-finance"
                        title="Financial Accounts"
                        titleColor="indigo--text text--darken-4"
                        color="indigo darken-4"
                        class="px-5 py-3 elevation-4 indigo--text text--darken-4"
                       >
                       <v-col cols="12">
                           <v-window v-model="accTypeStep">
                               <v-window-item :value="1"  transition="scroll-x-transition">
                                   <v-sheet>

                                        <v-data-table
                                            dense
                                            :search="searchAcc" :headers="headers"
                                            :items="accounts"
                                            :sort-by="accountSortRowsBy" class="mr-2"
                                            :loading="loading"
                                            :options.sync="options"
                                            :items-per-page="accountPagination.rowsPerPage"
                                            :server-items-length="totalaccounts"
                                        >
                                            <template v-slot:top>
                                                <v-row flat>
                                                    <v-col cols="12" sm="4">
                                                        <v-text-field
                                                        v-model="searchAcc"
                                                        append-icon="mdi-database-search"
                                                        label="Quick Search"
                                                        clearable
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-spacer></v-spacer>
                                                    <v-col cols="12" sm="2">
                                                        <v-btn id="refreshBtn" small text color="blue" class="float-left mt-4" @click="refreshaccounts">
                                                            <v-icon>mdi-refresh</v-icon> Refresh
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col cols="12" sm="2">
                                                        <v-btn id="refreshBtn" small text color="blue" class="float-left mt-4" @click="editItem(null)">
                                                            <v-icon>mdi-plus</v-icon> Add account
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>

                                            </template>
                                            <template v-slot:item.action="{item}">
                                                <v-icon small fab class="mr-2" color="blue" @click="viewItem(item)">
                                                    fa fa-eye
                                                </v-icon>
                                                <v-icon small fab class="mr-2" color="green" @click="editItem(item)">
                                                    fa fa-edit
                                                </v-icon>
                                                <v-icon small fab class="mr-2" color="red" @click="deleteItem(item)">
                                                    fa fa-trash
                                                </v-icon>
                                            </template>
                                            <template v-slot:item.acc_category="{item}">
                                                {{`(${item.acc_category?item.acc_category.name:'No'}) Group`}}
                                            </template>
                                            <template v-slot:item.amount="{item}">
                                                {{item.amount | currency}}
                                            </template>
                                            <template v-slot:item.fee_structures="{item}">
                                                {{`${item.fee_structures.length} Structure(s)`}}
                                            </template>

                                        </v-data-table>

                                   </v-sheet>

                               </v-window-item>
                               <v-window-item :value="2"  transition="scroll-y-transition">
                                   <v-row align="center" justify="center">
                                       <v-col cols="12">
                                           <v-btn @click="tableView" class="indigo darken-3" dark>Table View</v-btn>
                                       </v-col>
                                       <v-col v-if="selectedItem!==null" cols="12" md="6">
                                           <table class="table table-sm table-striped">
                                               <tbody>
                                                   <tr>
                                                       <th>
                                                           Name:
                                                       </th>
                                                       <th>
                                                           {{selectedItem.account_name}}
                                                       </th>
                                                   </tr>
                                                   <tr>
                                                       <th>
                                                           Group:
                                                       </th>
                                                       <th>
                                                           {{selectedItem.acc_category?selectedItem.acc_category.name:'No Group'}}
                                                       </th>
                                                   </tr>
                                                   <tr>
                                                       <th>
                                                           Balance:
                                                       </th>
                                                       <th>
                                                           {{selectedItem.amount|currency}}
                                                       </th>
                                                   </tr>
                                               </tbody>
                                           </table>
                                       </v-col>
                                       <v-col v-if="selectedItem!==null" cols="12" md="6">

                                           <table v-show="structureComponent === 'table'" class="table table-sm table-striped">
                                               <thead>
                                                   <tr>
                                                       <th colspan="2">
                                                           {{selectedItem.account_name}}||Structures
                                                       </th>
                                                       <th>
                                                           <v-btn id="refreshBtn" small text color="blue"  class="float-left mt-4" @click="editfee(null)">
                                                                <v-icon>mdi-plus</v-icon> Add Structue
                                                            </v-btn>
                                                       </th>
                                                   </tr>
                                               </thead>
                                               <tbody v-if="selectedItem.fee_structures.length >0">
                                                   <tr v-for="(fee,ind) in selectedItem.fee_structures" :key="'fee-'+ind">
                                                       <td>{{ind+1}}</td>
                                                       <td>{{fee.structure_name}}</td>
                                                       <td>{{fee.amount | currency}}</td>
                                                       <td>
                                                            <v-icon small fab class="mr-2" color="green" @click="editfee(fee)">
                                                                fa fa-edit
                                                            </v-icon>
                                                            <v-icon small fab class="mr-2" color="red" @click="deletefee(fee)">
                                                                fa fa-trash
                                                            </v-icon>
                                                       </td>
                                                   </tr>
                                               </tbody>
                                               <tbody v-if="selectedItem.fee_structures.length ===0">
                                                   <tr>
                                                       <td colspan="3">
                                                           <p>No Structure Here</p>
                                                       </td>
                                                   </tr>
                                               </tbody>
                                           </table>
                                           <v-form @submit.prevent="savefee" v-show="structureComponent === 'editor'">
                                               <h4>Structure Form</h4>
                                               <v-col cols="12" sm="8">
                                                   <v-text-field
                                                        label="Structure Name"
                                                        v-model="StructureName"
                                                    />
                                               </v-col>
                                               <v-col cols="12" sm="8">
                                                   <v-text-field
                                                        label="Structure Amount"
                                                        v-model="StructureAmountFormat"
                                                    />
                                               </v-col>
                                               <v-col cols="8">
                                                        <v-btn type="submit" color="indigo darken-1" class="btn-block" dark>
                                                            Save
                                                        </v-btn>
                                                        <v-btn type="reset" @click="tablefee" color="blue-gray" class="btn-block">
                                                            Cancel
                                                        </v-btn>
                                                    </v-col>


                                           </v-form>
                                       </v-col>
                                   </v-row>

                               </v-window-item>
                               <v-window-item :value="3"  transition="scroll-y-transition">
                                   <v-container>
                                       <v-row flat>
                                            <v-col cols="12" sm="5">
                                                <v-btn @click="tableView" class="indigo darken-3" dark>Table View</v-btn>
                                            </v-col>
                                        </v-row>
                                        <v-row flat>
                                            <v-col cols="12" sm="8">
                                                <h3 class="text-center"> Accounts' Editor</h3>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col align-self="center">
                                                <v-form @submit.prevent="submitData">

                                                    <v-col cols="8">
                                                        <v-text-field

                                                            label="Account Name"
                                                            v-model="accountName"
                                                        />
                                                    </v-col>
                                                    <v-col cols="8">
                                                        <v-text-field

                                                            label="Account Balance"
                                                            v-model="accountBalanceFormat"
                                                        />
                                                    </v-col>
                                                    <v-col cols="8">
                                                        <v-text-field

                                                            label="Set Approved Minium Account Balance"
                                                            v-model="accountMinBalanceFormat"
                                                        />
                                                    </v-col>

                                                        <v-col cols="8">
                                                            <v-autocomplete

                                                                append-icon="mdi-database-search"
                                                                label="Account Group"
                                                                v-model="accountGroup"
                                                                :loading="gpLoading"
                                                                :items="groups"
                                                                :search-input.sync="searchAccType"
                                                                :item-text="textGroup"
                                                                autocomplete
                                                                :menu-props="{ bottom: true, offsetY: true }"
                                                                hint="Please Search Account Group"
                                                                chips attach clearable
                                                                v-on:change="handleGroupSearch()"
                                                            >


                                                                <template v-slot:selection="data">
                                                                    <v-chip
                                                                    v-bind="data.attrs"
                                                                    :input-value="data.selected"
                                                                    close
                                                                    @click="data.select"
                                                                    @click:close="remove(data.item)"
                                                                    >
                                                                    {{ `${data.item.name}`}}
                                                                    </v-chip>
                                                                </template>

                                                                <template v-slot:item='{item}'>
                                                                    <v-row align="center" justify="center">

                                                                        <!-- <v-spacer></v-spacer> -->
                                                                        <v-col cols="12" sm="6" class="mx-1">
                                                                            <h6 v-html='`${item.name}`'/>
                                                                        </v-col>
                                                                    </v-row>
                                                                </template>
                                                            </v-autocomplete>
                                                        </v-col>

                                                    <v-col cols="8">
                                                        <v-btn type="submit" color="indigo darken-1" class="btn-block" dark>
                                                            Submit
                                                        </v-btn>
                                                        <v-btn type="reset" @click="tableView" color="blue-gray" class="btn-block">
                                                            Cancel
                                                        </v-btn>
                                                    </v-col>
                                                </v-form>
                                            </v-col>
                                        </v-row>
                                   </v-container>

                               </v-window-item>
                           </v-window>
                        </v-col>
                       </base-material-card>

                    </v-col>
                </v-row>

            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import { mapState } from 'vuex';
    export default {

        data:()=>({
            accTypeStep:1,
            searchAcc:'',
            loading:false,

            options:{},
            selectedItem:null,
            accountName:null,
            structureComponent:'table',
            headers:[
                        {text:'account',align:'left',sortable:true,value:'account_name'},
                        {text:'Balance',align:'left',sortable:true,value:'amount'},
                        {text:'Group',align:'left',sortable:false,value:'acc_category'},
                        {text:'NUMBER OF STRUCTURES',align:'left',sortable:false,value:'fee_structures'},
                        {text:'ACTION',align:'left',sortable:false,value:'action'}
                    ],
            StructureName:null,
            StructureAmount:null,
            fee:null,
            accountName:null,
            accountBalance:null,
            accountMinBalance:null,
            accountGroup:null,
            accountGroupSelection:null,
            accountGroupSelected:null,
            searchAccType:"",
            gpLoading:false,
        }),
        computed:{
            ...mapState({
                accounts:state=>state.accountsModule.accounts,
                accountPagination:state=>state.accountsModule.accountPagination.page,
                totalaccounts:state=>state.accountsModule.totalaccounts,
                accountSortRowsBy:state=>state.accountsModule.accountSortRowsBy,

                 groups:state=>state.accountsModule.groups,


            }),
            StructureAmountFormat:{
                get:function(){
                    if(this.StructureAmount !== null)
                    {
                        return this.formatAsCurrency(this.StructureAmount,0);
                    }
                },
                set:function(newValue){
                    this.StructureAmount = Number(newValue.replace(/[^0-9\.]/g,''));
                }
            },
            accountBalanceFormat:{
                get:function(){
                    if(this.accountBalance !== null)
                    {
                        return this.formatAsCurrency(this.accountBalance,0);
                    }
                },
                set:function(newValue){
                    this.accountBalance = Number(newValue.replace(/[^0-9\.]/g,''));
                }
            },
            accountMinBalanceFormat:{
                get:function(){
                    if(this.accountMinBalance !== null)
                    {
                        return this.formatAsCurrency(this.accountMinBalance,0);
                    }
                },
                set:function(newValue){
                    this.accountMinBalance = Number(newValue.replace(/[^0-9\.]/g,''));
                }
            }

        },
        methods:{

            formatAsCurrency(value,dec){
            dec = dec || 0;
            if (value === null){
                return 0;
            }
            return new Intl.NumberFormat("en-US",{
                style: "currency",currency: "UGX"
            }).format(value)
        },


            getGroupData(){
                this.gpLoading = true;
                return new Promise((resolve,reject)=>{
                    // let { sortBy, sortDesc, page, itemsPerPage } = this.optionsType;
                    let search = this.searchAccType;
                    let pagination = {};
                   let itemsPerPage = 4;
                   let pageNew =1;

                        if(!search){
                        pagination = {
                                        val:search,
                                        page:pageNew,
                                        rowsPerPage:itemsPerPage,
                                     }

                        this.$store.dispatch('accountsModule/GET_ACCOUNT_GROUPS_ACTION',pagination).finally(()=>{
                            this.gpLoading = false;
                        });
                        }

                    else if(search.length > 0){
                        if(pageNew > 1){
                                pageNew = this.groups.length ===0?1:pageNew;
                                this.gpLoading = true;
                                pagination = {
                                            val:search,
                                        page:pageNew,
                                        rowsPerPage:itemsPerPage,
                                        }

                                    this.$store.dispatch('accountsModule/GET_ACCOUNT_GROUPS_ACTION',pagination).finally(()=>{
                                        this.gpLoading = false;
                                    });

                        }
                        else{
                                pageNew = 1;
                                this.gpLoading = true;
                                pagination = {
                                           val:search,
                                        page:pageNew,
                                        rowsPerPage:itemsPerPage,
                                        }

                                    this.$store.dispatch('accountsModule/GET_ACCOUNT_GROUPS_ACTION',pagination).finally(()=>{
                                        this.gpLoading = false;
                                    });

                        }
                    }

                });
            },

            getData(){
                this.loading = true;
                return new Promise((resolve,reject)=>{
                    const { sortBy, sortDesc, page, itemsPerPage } = this.options;
                    let search = this.searchAcc;
                    let pageNew = page;
                    let pagination = {};
                        if(!search){
                        pagination = {
                                        val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0],
                                     }

                        this.$store.dispatch('accountsModule/GET_ACCOUNTS_ACTION',pagination).finally(()=>{
                            this.loading = false;
                        });
                    }

                    else if(search.length > 0){
                        if(pageNew > 1){
                                pageNew = this.accounts.length ===0?1:pageNew;
                                this.loading = true;
                                pagination = {
                                            val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0] === undefined?'account_name':sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0] === undefined?false:sortDesc[0],
                                        }

                                    this.$store.dispatch('accountsModule/GET_ACCOUNTS_ACTION',pagination).finally(()=>{
                                        this.loading = false;
                                    });

                        }
                        else{
                                pageNew = 1;
                                this.loading = true;
                                pagination =    {
                                                    val:search,
                                                    page:pageNew,
                                                    sortRowsBy:sortBy[0] === undefined?'account_name':sortBy[0],
                                                    rowsPerPage:itemsPerPage,
                                                    sortDesc:sortDesc[0] === undefined?false:sortDesc[0],
                                                }

                                    this.$store.dispatch('accountsModule/GET_ACCOUNTS_ACTION',pagination).finally(()=>{
                                        this.loading = false;
                                    });

                        }
                    }

                });
            },
            submitData(){
                let formData = {
                    id:this.selectedItem !== null?this.selectedItem.id:null,
                    name:this.accountName || null,
                }
                if(formData.name === null){
                        let alert = {
                        status:'failed',
                        open:true,
                        message:'name is required',
                        title:'Action Failed!'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                }
                else{

                    this.$store.dispatch('accountsModule/SAVE_ACCOUNT_accountS_ACTION',formData).then((res)=>{

                    let alert = {
                        status:'successful',
                        open:true,
                        message:res.message || 'successfully Stored',
                        title:'Action Successful'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                }).catch(()=>{
                    let alert = {
                        status:'failed',
                        open:true,
                        message:'action failed',
                        title:'Action Failed!'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                }).finally(()=>{
                    this.getData();
                    this.accountName = null;
                    this.selectedItem = null;
                    this.tableView();
                });

                }


            },
            refreshaccounts(){

                this.searchAcc = "";
                this.options.page = 1;
                this.getData();
            },
            tableView(){
                this.getData();
                this.accTypeStep = 1;
                this.selectedItem = null;
            },
            viewItem(item){
                this.accTypeStep = 2;
                this.selectedItem = item;
            },
            editItem(item){
                if(item === null)
                {
                    this.accountName = null;
                    this.selectedItem = null;
                    this.accountBalance = 0;
                    this.accountMinBalance = 0;
                    this.accountGroup = null;
                }
                else if (item !== null || item !== ""){
                    this.accountName = item.name;
                    this.selectedItem = item;
                }
                this.accTypeStep = 3;

            },
            deleteItem(item){
                let formData = {
                    id:item.id
                };


                this.$store.dispatch('accountsModule/DELETE_ACCOUNT_account_ACTION',formData).then((res)=>{
                    console.log(res)
                    let alert = {
                        status:(res.message).includes('not')?'failed':'successful',
                        open:true,
                        message:res.message || 'successfully Deletion',
                        title:(res.message).includes('not')?'Action Failed':'Action Successful'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                }).catch(()=>{
                    let alert = {
                        status:'failed',
                        open:true,
                        message:'action failed',
                        title:'Action Failed!'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                }).finally(()=>{
                    this.getData();
                    this.accountName = null;
                    this.selectedItem = null;
                    this.tableView();
                });

            },
            tablefee(){
                this.StructureName = null;
                this.StructureAmount = null;
                this.structureComponent = 'table';
            },
            savefee(){

                if(this.StructureName === null){
                    let alert = {
                        status:'failed',
                        open:true,
                        message:'name is required failed',
                        title:'Action Failed!'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                }

                else{
                    let formData = {
                        id:this.fee !== null?this.fee.id:null,
                        school_account_id:this.selectedItem.id,
                        structure_name:this.StructureName,
                        amount:this.StructureAmount || 0,
                    };



                    this.$store.dispatch('accountsModule/SAVE_ACCOUNT_FEESTRUCTURES_ACTION',formData)
                    .then(result=>{
                               let alert = {
                        status:'successful',
                        open:true,
                        message:'Saved Successfully',
                        title:'Action successful!'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                        this.selectedItem = result;
                    })
                    .finally(()=>{
                        this.getData();
                        this.StructureAmount = null;
                        this.StructureName =  null;
                        this.fee = null;
                        this.structureComponent = 'table';
                    });
                }
            },
            editfee(item){
                this.structureComponent = 'editor';
                this.fee = item;
                if(item !== null){
                    this.StructureName = item.structure_name
                    this.StructureAmount = item.amount
                }
                else{
                    this.StructureName = null;
                    this.StructureAmount = null;
                }

            },
            deletefee(item){
                let data = {
                    id:item.id,
                    school_account_id:item.school_account_id,
                }
                this.$store.dispatch('accountsModule/DELETE_ACCOUNT_FEESTRUCTURE_ACTION',data)
                .then(result=>{
                    let alert = {
                        status:'successful',
                        open:true,
                        message:'Deleted Successfully',
                        title:'Action successful!'
                    }
                    this.$store.dispatch('alertActionModule/ALERT_ACTION',alert);
                    this.selectedItem = result;
                    this.getData();
                });

            },
            viewfee(item){
                this.selectedItem = item;
            },

            remove(){
                          this.accountGroupSelection = null;
                          this.accountGroup = null
                   },
                   handleGroupSearch(){
                       this.accountGroupSelection = this.accountGroupSelected;
                       if(!this.accountGroup){
                           this.accountGroup = null;
                           this.accountGroupSelection = null;
                           this.accountGroupSelected = null;

                       }
                   },
                  textGroup(item){
                      this.accountGroupSelected = item;
                      return item.name;

                   },
        },
        mounted(){
            this.getData();
            this.getGroupData();
        },
        watch:{
            searchAcc(val){
                console.log(val);
                if(!val){
                    this.searchAcc = "";
                }
                else if(val!== "") {

                    this.getData();
                }

                this.getData();
            },
            options:{
                handler(){
                this.getData();
            },
            deep:true,
            },
            searchAccType(val){
                if(!this.studentSearch){
                  this.studentSearch = "";
               }
              if(this.studentSearch!==""){
                this.getGroupData();
              }
            },

        },
        filters:{
            currency(value){
                return new Intl.NumberFormat("en-US",{
                    style: "currency",currency: "UGX"
                }).format(value);
            },
        }

    }
</script>

<style lang="scss" scoped>

</style>
