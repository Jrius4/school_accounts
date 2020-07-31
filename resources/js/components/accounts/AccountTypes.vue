<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row>
                    <v-col >
                       <base-material-card

                        icon="mdi-finance"
                        title="Account Groups"
                        titleColor="pink--text text--darken-4"
                        color="pink darken-4"
                        class="px-5 py-3 elevation-4 pink--text text--darken-4"
                       >
                       <v-col cols="12">
                           <v-window v-model="accTypeStep">
                               <v-window-item :value="1"  transition="scroll-x-transition">
                                   <v-sheet>

                                        <v-data-table
                                            dense
                                            :search="searchAccType" :headers="headers"
                                            :items="groups"
                                            :sort-by="groupSortRowsBy" class="mr-2"
                                            :loading="loading"
                                            :options.sync="options"
                                            :items-per-page="groupPagination.rowsPerPage"
                                            :server-items-length="totalgroups"
                                        >
                                            <template v-slot:top>
                                                <v-row flat>
                                                    <v-col cols="12" sm="4">
                                                        <v-text-field
                                                        v-model="searchAccType"
                                                        append-icon="mdi-database-search"
                                                        label="Quick Search"
                                                        clearable
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-spacer></v-spacer>
                                                    <v-col cols="12" sm="2">
                                                        <v-btn id="refreshBtn" small text color="blue" class="float-left mt-4" @click="refreshGroups">
                                                            <v-icon>mdi-refresh</v-icon> Refresh
                                                        </v-btn>
                                                    </v-col>
                                                    <v-col cols="12" sm="2">
                                                        <v-btn id="refreshBtn" small text color="blue" class="float-left mt-4" @click="editItem(null)">
                                                            <v-icon>mdi-plus</v-icon> Add Group
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
                                            <template v-slot:item.school_accounts="{item}">
                                                {{`${item.school_accounts.length} Account(s)`}}
                                            </template>

                                        </v-data-table>

                                   </v-sheet>

                               </v-window-item>
                               <v-window-item :value="2"  transition="scroll-y-transition">
                                   <v-row align="center" justify="center">
                                       <v-col cols="12">
                                           <v-btn @click="tableView" class="pink darken-3" dark>Table View</v-btn>
                                       </v-col>
                                       <v-col v-if="selectedItem!==null" cols="12">

                                           <table class="table table-sm table-striped">
                                               <thead>
                                                   <tr>
                                                       <th colspan="2">
                                                           Accounts In ({{selectedItem.name}}) group
                                                       </th>
                                                   </tr>
                                               </thead>
                                               <tbody v-if="selectedItem.school_accounts.length >0">
                                                   <tr v-for="(acc,ind) in selectedItem.school_accounts" :key="'acc-'+ind">
                                                       <td>{{ind+1}}</td>
                                                       <td>{{acc.account_name}}</td>
                                                   </tr>
                                               </tbody>
                                               <tbody v-if="selectedItem.school_accounts.length ===0">
                                                   <tr>
                                                       <td colspan="2">
                                                           <p>No Account Here</p>
                                                       </td>
                                                   </tr>
                                               </tbody>
                                           </table>
                                       </v-col>
                                   </v-row>

                               </v-window-item>
                               <v-window-item :value="3"  transition="scroll-y-transition">
                                   <v-container>
                                       <v-row flat>
                                            <v-col cols="12" sm="5">
                                                <v-btn @click="tableView" class="pink darken-3" dark>Table View</v-btn>
                                            </v-col>
                                        </v-row>
                                        <v-row flat>
                                            <v-col cols="12" sm="8">
                                                <h3 class="text-center"> Accounts' Group Editor</h3>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col align-self="center">
                                                <v-form @submit.prevent="submitData">

                                                    <v-col cols="8">
                                                        <v-text-field
                                                            aria-required="required"
                                                            label="Group Name"
                                                            v-model="GroupName"
                                                        />
                                                    </v-col>
                                                    <v-col cols="8">
                                                        <v-btn type="submit" color="pink darken-1" class="btn-block" dark>
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
            searchAccType:'',
            loading:false,
            options:{},
            selectedItem:null,
            GroupName:null,
            headers:[
                        {text:'GROUP',align:'left',sortable:true,value:'name'},
                        {text:'NUMBER OF ACCOUNTS',align:'left',sortable:false,value:'school_accounts'},
                        {text:'ACTION',align:'left',sortable:false,value:'action'}
                    ]
        }),
        computed:{
            ...mapState({
                groups:state=>state.accountTypesModule.groups,
                groupPagination:state=>state.accountTypesModule.groupPagination.page,
                totalgroups:state=>state.accountTypesModule.totalgroups,
                groupSortRowsBy:state=>state.accountTypesModule.groupSortRowsBy,

            }),
        },
        methods:{
            getData(){
                this.loading = true;
                return new Promise((resolve,reject)=>{
                    const { sortBy, sortDesc, page, itemsPerPage } = this.options;
                    let search = this.searchAccType;
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

                        this.$store.dispatch('accountTypesModule/GET_ACCOUNT_GROUPS_ACTION',pagination).finally(()=>{
                            this.loading = false;
                        });
                        }

                    else if(search.length > 0){
                        if(pageNew > 1){
                                pageNew = this.groups.length ===0?1:pageNew;
                                this.loading = true;
                                pagination = {
                                            val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0],
                                        }

                                    this.$store.dispatch('accountTypesModule/GET_ACCOUNT_GROUPS_ACTION',pagination).finally(()=>{
                                        this.loading = false;
                                    });

                        }
                        else{
                                pageNew = 1;
                                this.loading = true;
                                pagination = {
                                            val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0],
                                        }

                                    this.$store.dispatch('accountTypesModule/GET_ACCOUNT_GROUPS_ACTION',pagination).finally(()=>{
                                        this.loading = false;
                                    });

                        }
                    }

                });
            },
            submitData(){
                let formData = {
                    id:this.selectedItem !== null?this.selectedItem.id:null,
                    name:this.GroupName || null,
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

                    this.$store.dispatch('accountTypesModule/SAVE_ACCOUNT_GROUPS_ACTION',formData).then((res)=>{
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
                    this.GroupName = null;
                    this.selectedItem = null;
                    this.tableView();
                });

                }


            },
            refreshGroups(){

                this.searchAccType = "";
                this.options.page = 1;
                this.getData();
            },
            tableView(){
                this.accTypeStep = 1;
            },
            viewItem(item){
                console.log(item)
                this.accTypeStep = 2;
                this.selectedItem = item;
            },
            editItem(item){

                if(item === null)
                {
                    this.GroupName = null;
                    this.selectedItem = null;
                }
                else{
                    this.GroupName = item.name;
                    this.selectedItem = item;
                }
                this.accTypeStep = 3;

            },
            deleteItem(item){
                let formData = {
                    id:item.id
                };


                this.$store.dispatch('accountTypesModule/DELETE_ACCOUNT_GROUP_ACTION',formData).then((res)=>{
                    let alert = {
                        status:'successful',
                        open:true,
                        message:res.message || 'successfully Deletion',
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
                    this.GroupName = null;
                    this.selectedItem = null;
                    this.tableView();
                });

            }
        },
        mounted(){
            this.getData();
        },
        watch:{
            searchAccType(val){
                console.log(val);
                if(!val){
                    this.searchAccType = "";
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
            }
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
