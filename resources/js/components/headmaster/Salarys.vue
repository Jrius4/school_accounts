<template>
    <v-container fluid>
        <base-v-component
            heading="Employee Salaries" class="text-primary"
        />

        <base-material-card
            icon="mdi-bank"
            title="Salaries"
            class="px-5 py-3 elevation-4"
        >
           <v-row align="center" justify="center">
               <v-col cols="12">
                   <v-window v-model="step">
                       <v-window-item :value="1">
                            <v-data-table
                                :search="search"
                                item-key="name" :headers="headers"
                                :items="employees"
                                :sort-by="employeeSortRowsBy" class="mr-2"
                                :loading="loading"
                                :options.sync="options"
                                :items-per-page="itemsPerPage"
                                :server-items-length="totalEmployees"

                                >
                                    <template v-slot:top>
                                        <v-row flat>
                                            <v-col cols="12" md="3" sm="8">
                                                <v-text-field
                                                v-model="search"
                                                append-icon="mdi-magnify"
                                                label="Quick Search"
                                                clearable
                                                ></v-text-field>
                                            </v-col>

                                            <v-spacer></v-spacer>


                                        </v-row>
                                    </template>
                                    <template v-slot:item.image="{item}">
                                        <v-avatar size="30px">
                                            <img :src="`/files/${item.image!==null?item.image:'user_all.png'}`"/>
                                        </v-avatar>
                                    </template>
                                    <template v-slot:item.wage_salary="{item}">
                                        <span>{{ item.wage_salary | currency}}</span>
                                    </template>
                                    <template v-slot:item.roles="{item}">
                                        <h6 v-for="role in item.roles" :key="role.id">{{`${role.display_name}`.toLowerCase()}}<br/></h6>
                                    </template>
                                     <template v-slot:item.wage_paid="{item}">
                                        <span>{{ item.wage_paid | currency}}</span>
                                    </template>
                                    <template v-slot:item.wage_balance="{item}">
                                        <span>{{ item.wage_balance | currency}}</span>
                                    </template>
                                    <template v-slot:item.wage_loan="{item}">
                                        <span>{{ item.wage_loan | currency}}</span>
                                    </template>
                                    <template v-slot:item.wage_upfront="{item}">
                                        <span>{{ item.wage_upfront | currency}}</span>
                                    </template>

                                    <template v-slot:item.action="{item}">
                                    <v-icon small fab class="mr-2 text-primary" color="blue" @click="viewItem(item)">
                                        fa fa-eye
                                    </v-icon>
                                    <v-icon small fab class="mr-2 text-success" color="green" @click="editItem(item)">
                                        fa fa-edit
                                    </v-icon>
                                    <v-icon small fab class="mr-2  text-danger" color="red" @click="deleteItem(item)">
                                        fa fa-trash
                                    </v-icon>
                                </template>



                                </v-data-table>
                       </v-window-item>
                       <v-window-item :value="2">
                           <v-form v-if="selectedEditItem !== null" class="light-blue--text text--darken-3">
                               <v-text-field
                               class="light-blue--text text--darken-3"
                               label="Employee Name"
                               v-model="selectedEditItem.name"
                               prepend-icon="mdi-account"
                               ></v-text-field>
                               <br/>

                                <v-text-field
                                class="light-blue--text text--darken-3"
                                label="Employee Salary"
                                v-model="formatPaymentAmount"
                                prepend-icon="mdi-bank"
                               ></v-text-field>
                                <br/>
                                <br/>

                                <v-row align="center" justify="center">
                                    <v-btn color="primary" class="mx-2 btn-block" dark @click="saveItem()">
                                        Save
                                    </v-btn>
                                    <v-btn color="light-black" class="mx-2 btn-block" dark @click="cancelItem()">
                                        Cancel
                                    </v-btn>
                                </v-row>
                           </v-form>
                       </v-window-item>
                       <v-window-item :value="3">
                           <v-row align="center" justify="center">
                                <v-btn color="light-blue darken-3" class="mx-2 btn-block my-2" dark @click="step=1">
                                    View All Workers
                                </v-btn>
                            </v-row>

                            <v-row>
                                <v-col>
                                   <h3 class="light-blue--text text-darken-3">Worker</h3>
                                </v-col>

                            </v-row>
                            <v-row align="center" justify="center">
                                <v-col cols="12" align="center" md="4" v-if="selectedViewItem!==null">
                                    <base-material-card
                                        class="v-card-profile"
                                        :avatar="`/files/${selectedViewItem.image !==null? selectedViewItem.image:'user_all.png' }`"
                                        align="center"
                                        justify="center"
                                    >
                                    <v-card-text>
                                        <h4 class="font-weight-light mb-3 light-blue--text text--darken-3">
                                            {{selectedViewItem.name}}
                                        </h4>
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr v-if="selectedViewItem.roles">
                                                    <th>Position</th>
                                                    <th>
                                                        <span v-for="role in selectedViewItem.roles" :key="role.id">
                                                            {{role.display_name}}
                                                        </span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Salary</th>
                                                    <th>
                                                        {{selectedViewItem.wage_salary}}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </v-card-text>
                                    </base-material-card>
                                </v-col>
                            </v-row>

                       </v-window-item>
                   </v-window>
                </v-col>

            </v-row>

        </base-material-card>


    </v-container>
</template>
<script>
import { mapState , mapActions} from 'vuex';
export default {
    name:"EmployeeSalary",

    data:()=>({
        singleSelect:false,
        selected:[],
        step:1,
        search:'',
        selectedViewItem:null,
        selectedEditItem:null,
        selectedCreatedItem:null,
        itemsPerPage:10,
        options:{},
        loading:false,
        headers:[
            {text:'Employee',align:'left',sortable:false,value:'image'},
            {text:'NAME',align:'left',value:'name'},
            {text:'Roles',align:'left',value:'roles'},
            {text:'Salary',align:'left',value:'wage_salary'},
            {text:'Paid',align:'left',value:'wage_paid'},
            {text:'Balance',align:'left',value:'wage_balance'},
            {text:'Loan',align:'left',value:'wage_loan'},
            {text:'Upfront',align:'left',value:'wage_upfront'},
            {text:' ACTION',align:'right',value:'action',sortable:false},
        ],
    }),

    methods:{

        viewItem(item){
            this.step = 3;
            this.selectedViewItem = item;
        },
        editItem(item){
            this.step = 2;
            this.selectedEditItem = item;
        },
        deleteItem(item){

        },
        saveItem(){
            this.step = 1;
            let payload = {
                setSalary:true,
                worker_id:this.selectedEditItem.id,
                worker_salary:this.selectedEditItem.wage_salary,
            }
            this.$store.dispatch('saveEmployeeInfoAction',payload);

            this.selectedEditItem = null;

        },
        cancelItem(){
            this.step = 1;

            this.selectedEditItem = null;
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


        getDataFromApi(){
            this.loading = true;
            return new Promise((resolve,reject)=>{

                const { sortBy, sortDesc, page, itemsPerPage } = this.options;

                let search = this.search;
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

                                this.$store.dispatch('getEmployeesPaginationAction',pagination).finally(()=>{
                                    this.loading = false;
                                })
                }
                else if(search.length > 0){
                    if(pageNew > 1){
                            pageNew = this.employees.length ===0?1:pageNew;
                            this.loading = true;
                            pagination = {
                                        val:search,
                                        page:pageNew,
                                        sortRowsBy:sortBy[0],
                                        rowsPerPage:itemsPerPage,
                                        sortDesc:sortDesc[0],
                                    }

                                this.$store.dispatch('getEmployeesPaginationAction',pagination).finally(()=>{
                                    this.loading = false;
                                })

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

                                this.$store.dispatch('getEmployeesPaginationAction',pagination).finally(()=>{
                                    this.loading = false;
                                })

                    }
                }




            })
        }


    },

    computed:{
        ...mapState({
            employees:state=>state.employees,
            employeePagination:state=>state.employeePagination.page,
            totalEmployees:state=>state.totalEmployees,
            totalrowsPerPageEmployees:state=>state.employeePagination.rowsPerPage,
            employeeSortRowsBy:state=>state.employeeSortRowsBy,
        }),


        formatPaymentAmount:{
            get:function(){
                    if(this.selectedEditItem !== null){
                        return this.formatAsCurrency(this.selectedEditItem.wage_salary,0);
                    }



            },
            set:function(newValue){
                this.selectedEditItem.wage_salary = Number(newValue.replace(/[^0-9\.]/g,''))

            }
        },




    },
    created(){

    },
    mounted(){
        this.loading = true;
        this.$store.dispatch('getEmployeesAction',this.search,10).finally(() => {
                this.loading = false;
                });
    },
    watch:{
        search(value){
            if(!this.search) {
                this.search = "";
                };

                this.loading = true;
                this.getDataFromApi()
        },

        options:{
            handler(){
                this.getDataFromApi();
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
<style>

</style>
