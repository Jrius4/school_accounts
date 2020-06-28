import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";
import PrefsModule from "./preferences";
import NavModule from "../components/cities/navigation";
import ExpenseNavModule from "../components/burser/expenses/navigation";

const citiesUrl = "/api/vue-cities";

Vue.use(Vuex);

const testData = [];
const expData = [];
for (let i= 1;i<=20;i++){
    testData.push({
        id:i,name:`Item #${i}`,category:`Category ${i%3}`,description:`This is Item #${i}`,price:i*187500
    })
}

for (let i= 1;i<=20;i++){
    var x = 3;
    expData.push({
        id:i,name:`Item #${i}`,units:`unit #${i}`,quantity:(i+x)*15,rate:(15990000*i),amount:((i+x)*15)*(7500*i)
    })

}

export default new Vuex.Store({
    modules:{
        prefs:PrefsModule,
        nav:NavModule,
        expNav:ExpenseNavModule
    },
    state:{
        cities:[],
        selectedCity:null,
        selectedExpItem:null,
        token:localStorage.getItem('access_token') || null,
        user:null,
        items:testData,
        expenseItems:[],
        amntTtlExpBorSub : 0,
        accountSelected:null,
        selectedBorrowItem:null,
        selectedLoanItem:null,
        expenseTotal:0,
        borrowDetails:null,
        makeBorrowItems:[],
        makeLoanBorrowItems:[],
        itemsTotal:testData.length,
        currentPage:1,
        pageSize:4,

        currentCategory:"All",
        employees:[],
        employeePagination:{
            page:1,
            rowsPerPage:10,
        },
        totalEmployees:null,
        employeeSortRowsBy:'name',
    },
    mutations:{
        getUser(state,user){
            state.user = user;
        },
        getUserToken(state,token){
            state.token = token;
        },
        saveCity(currentState,city){

            let index = currentState.cities.findIndex(c=>c.id == city.id);
            if(index == -1){
                currentState.cities.push(city);
            }else{
                Vue.set(currentState.cities,index,city);
            }
        },
        saveNewCity(currentState,city){
            let index = currentState.cities.findIndex(c=>c.id == city.id);
            if(index == -1){
                currentState.cities.unshift(city);
            }else{
                Vue.set(currentState.cities,index,city);
            }
        },
        selectCity(currentState,city){
            currentState.selectedCity = city;
        },

        deleteCity(currentState,city){
            let index = currentState.cities.findIndex(c=>c.id == city.id);
            currentState.cities.splice(index,1);
        },
        //expense start
        saveExpenseItem(currentState,item){
            let index = currentState.expenseItems.findIndex(c=>c.id == item.id);
            if(index == -1){
                currentState.expenseItems.push(item);
            }
            else{
                Vue.set(currentState.expenseItems,index,item);
            }
        },
        gettotalSubstraction(currentState,data){
            currentState.amntTtlExpBorSub = data;
        },
        getExpenseTotal(currentState,total){
            currentState.expenseTotal = total;
        },
        saveNewExpenseItem(currentState,item){
            let index = currentState.expenseItems.findIndex(c=>c.id == item.id);
            if(index == -1){
                currentState.expenseItems.push(item);
            }
            else{
                Vue.set(currentState.expenseItems,index,item);
            }
        },
        RESET_EXPENSE(currentState){


        },
        selectLoanItem(currentState, item){

            currentState.selectedLoanItem = item;
        },
        selectExpItem(currentState,item){
            currentState.selectedExpItem = item;
        },

        deleteExpItem(currentState,item){
            let index = currentState.expenseItems.findIndex(c=>c.id == item.id);
            currentState.expenseItems.splice(index,1);
        },
        getBorrowDetails(currentState,borrowDetail){
            currentState.borrowDetails = borrowDetail;
        },
        selectBorrowItem(currentState,item){
            currentState.selectedBorrowItem = item;
        },
        makeBorrow(currentState,borrow){
            let index = currentState.makeBorrowItems.findIndex(c=>c.selectedAccount.id == borrow.selectedAccount.id);
            if(index == -1){
                currentState.makeBorrowItems.push(borrow);
            }
            else{
                Vue.set(currentState.makeBorrowItems,index,borrow);
            }


        },
        makeBorrowLoan(currentState,borrow){
            let index = currentState.makeLoanBorrowItems.findIndex(c=>c.selectedAccount.id == borrow.selectedAccount.id);
            if(index == -1){
                currentState.makeLoanBorrowItems.push(borrow);
            }
            else{
                Vue.set(currentState.makeLoanBorrowItems,index,borrow);
            }

        },
        deleteBorrowItem(currentState,data){
            let index = currentState.makeBorrowItems.findIndex(c=>c.selectedAccount.id == data.selectedAccount.id);
            currentState.makeBorrowItems.splice(index,1);
        },
        deleteBorrowLoanItem(currentState,data){
            let index = currentState.makeLoanBorrowItems.findIndex(c=>c.selectedAccount.id == data.selectedAccount.id);
            currentState.makeLoanBorrowItems.splice(index,1);
        },
        getCreditTotal(currentState,data){
            currentState.expNav.totalBorrowed = data;

        },
        getCreditTotalLoan(currentState,data){
            currentState.expNav.totalCreditLoan = data;

        },
        storeMadeExpense(currentState){
            currentState.makeBorrowItems = [];
            currentState.expenseItems = [];
            currentState.expenseTotal = 0;
            currentState.borrowDetails = null;
            currentState.selectedBorrowItem = null;
            currentState.expNav.selectedItem = null;
            currentState.expNav.totalBorrowed = 0;
            currentState.expNav.expSelection = {term:"",account:""};

        },
        getAccounts(currentState,accounts){
            currentState.expNav.accounts = accounts;
        },
        getBorrowAccounts(currentState,accountsBorrow){
            currentState.expNav.accountsBorrow = accountsBorrow;
        },
        SET_SELECTED_ACCOUNT(currentState,payload){
            currentState.accountSelected = payload;
        },
        getLoanAccounts(currentState,accounts){
            currentState.expNav.loanAccounts = accounts;
        },
        //expense end

        setCurrentPage(state,page){
            state.currentPage = page;
        },
        setPageSize(state,size){
            state.pageSize=size;
            state.currentPage = 1;
        },
        setCurrentCategory(state,category){
            state.currentCategory = category;
            state.currentPage = 1;
        },
        getSearchedItems(state,items){
            state.items = items;
        },
        // SOCKET_ONOPEN(currentState,event){
        //     Vue.prototype.$socket = event.currentTarget;
        //     currentState.socket.isConnected = true;
        // },
        // SOCKET_ONCLOSE(currentState,event){
        //     currentState.socket.isConnected = false;
        // },
        // SOCKET_ONERROR(currentState,event){
        //     console.error(currentState,event)
        // },
        // SOCKET_ONMESSAGE(currentState,message){
        //     currentState.socket.message = message;
        // },
        // SOCKET_RECONNECT(currentState,count){
        //     console.info(currentState, count)
        // },
        // SOCKET_RECONNECT_ERROR(currentState){
        //     currentState.socket.reconnectError = true;
        // }

        //start employees
        SET_EMPLOYEES(currentState,payload){
            currentState.employees = payload.data;
            currentState.employeePagination.page = parseInt(payload.current_page);
            currentState.employeePagination.rowsPerPage =parseInt(payload.per_page);
            currentState.totalEmployees = parseInt(payload.total);
        },
        SAVE_EMPLOYEE_INFO(currentState,item){


            let index = currentState.employees.findIndex(c=>c.id == item.id);
            if(index == -1){
                currentState.employees.push(item);
            }
            else{
                Vue.set(currentState.employees,index,item);
            }
        }
        //end employees
    },
    getters:{
        loggedIn(state){
            return state.token !== null;
        },
        employees:(currentState)=>{
            return currentState.employees;
        },
        rowsPerPageEmployeesGetter(currentState){
                return currentState.totalEmployees;
        },
        totalEmployeesGetter(currentState){
                    return currentState.employeePagination.rowsPerPage;
        },
        orderedCities(state){
            return state.cities.concat().sort((c1,c2)=>c2.sqmiles - c1.sqmiles);

        },
        filteredCities(state,getters){
            // return (amount) => getters.orderedCities.filter(c=>c.sqmiles > amount);
            return (str_search) => getters.orderedCities.filter(c=>c.country.includes(str_search));

        },
        itemFilteredByCategory:state=>state.items.filter(item=>
            state.currentCategory=="All" ||
            item.category == state.currentCategory),
        processedItems:(state,getters)=>{
            let index = (state.currentPage - 1) * state.pageSize;
            return getters.itemFilteredByCategory.slice(index,index + state.pageSize);

        },
        pageCount:(state,getters)=>
        Math.ceil(getters.itemFilteredByCategory.length/state.pageSize),

        categories:state=>["All",
            ...new Set(state.items.map(item=>item.category).sort())]

    },
    actions:{
        // sendMessageAction:function(context,message){
        //     Vue.prototype.$socket.send(message)
        // },
        async getCitiesAction(context){
            (await Axios.get(citiesUrl)).data.data.forEach(
            // (await this.restDataSource.getCities()).forEach(
                c=>context.commit("saveCity",c)
            );
        },
        /**
         * async getSeachedItemsAction(context,keywords){
            return new Promise((resolve,reject)=>{
                Axios.get('/api/search-student',{
                    headers:{
                        Authorization: "Bearer "+context.state.token
                    },
                    params:{
                        keywords
                    }
                }).then(response=>{
                    let items = response.data.data
                    context.commit('getSearchedItems',items);
                    resolve(items);
                }).catch(err=>
                    reject(err))

            });
        },
         *
        */


        async getUserAction(context){
            if(context.getters.loggedIn){
                return new Promise((resolve,reject)=>{
                    Axios.get('/api/user',{
                        headers:{
                            Authorization: "Bearer "+context.state.token
                        }
                    }).then(
                        response=>{
                            const user = response.data;
                            context.commit('getUser',user);

                            resolve(response);
                        }
                    ).catch(error=>{
                        reject(error);
                    });
                })
            }else{console.log("none")}
        },
        async getUserTokenAcion(context){
            return new Promise((resolve,reject)=>{
                if(Object.keys(localStorage).includes('access_token'))
                {
                    const token = localStorage.access_token;
                    context.commit('getUserToken',token);
                    resolve(token);
                }
                else{
                    const error = 'No Token';
                    reject(error);
                }
            })

        },
        async saveCityAction(context,city){
            let index = context.state.cities.findIndex(c=>c.id == city.id);

            if(index == -1){
                city = ((await Axios.post(citiesUrl,city)).data.data);

            }else{
               city = ((await Axios.put(`${citiesUrl}/${city.id}`,city)).data.data);
            }
            context.commit("saveNewCity",city);

        },
        async deleteCityAction(context,city){

            await Axios.delete(`${citiesUrl}/${city.id}`);
            context.commit("deleteCity",city);
        },
        //expenses
        async getExpenseItemAction(context){
            if(context.getters.loggedIn){
                return new Promise((resolve,reject)=>{
                    Axios.get('/api/make-expenses',{
                        headers:{
                            Authorization: "Bearer "+context.state.token
                        }
                    }).then(
                        response=>{
                            const expItems = response.data.data.expenseItems;
                            let itemTotal = response.data.data.totalItems;
                            context.commit('getExpenseItem',expItems,itemTotal)
                            resolve(response);

                        }
                    ).catch(err=>
                        reject(err)
                        );
                })
            }
        },
        async createExpenseItemAction(context,item){
            item = ((await Axios.post('/api/make-expenses',item,{
                headers:{
                    Authorization: "Bearer "+context.state.token
                }
            })).data);

            let total = item.totalItems;
            item = item.expenseItems;
            context.commit('getExpenseTotal',total)
            context.commit("saveNewExpenseItem",item);
        },
        async updateExpenseItemAction(context,item){
            item = ((await Axios.put(`/api/make-expenses/${item.id}`,item,{
                headers:{
                    Authorization: "Bearer "+context.state.token
                }
            })).data)

           let total = item.totalItems;
            item = item.expenseItems;
            context.commit('getExpenseTotal',total)
            context.commit("saveNewExpenseItem",item);

        },
        /**
        async saveExpenseItemAction(context,item){
            let index = context.state.expenseItems.findIndex(i=>i.name == item.name);
            let total;
            console.log(index)
            if (index == -1) {
                item = ((await Axios.post('/api/make-expenses',item,{
                        headers:{
                            Authorization: "Bearer "+context.state.token
                        }
                    })).data)

                    total = item.totalItems;
                    item = item.expenseItems;
                    context.commit('getExpenseTotal',total)

            } else {
                item = ((await Axios.put(`/api/make-expenses/${item.id}`,item,{
                        headers:{
                            Authorization: "Bearer "+context.state.token
                        }
                    })).data)

                    total = item.totalItems;
                    item = item.expenseItems;
                    context.commit('getExpenseTotal',total)


            }
            context.commit("saveNewExpenseItem",item,total);
        },
        */
        async getExpenseItemAction(context){
            Axios.get('/api/make-expenses',{
                headers:{
                    Authorization: "Bearer "+context.state.token
                }}).then(response=>{
                    response.data.expenseItems.forEach(item=>{
                    context.commit('saveExpenseItem',item)
                    });
                    let itemsTotal = response.data.totalItems;
                    context.commit('getExpenseTotal',itemsTotal);

                }).catch(err=>console.log(err));

        },
        async deleteExpItemAction(context,item){
            let total = (await (Axios.delete(`/api/make-expenses/${item.id}`))).data.totalItems;
            context.commit('getExpenseTotal',total)
            context.commit('deleteExpItem',item)
        },
        async getBorrowDetailsAction(context,borrowDetail){
            return new Promise((resolve,reject)=>{
                let details = [];
                let account,term;

                this.state.expNav.accounts.forEach(element=>{
                    if(element.name === borrowDetail.account){
                        account = element;
                    }
                });
                this.state.expNav.terms.forEach(element=>{
                    if(element.name === borrowDetail.term){
                        term = element;
                    }
                })
                details.push({account,term})
                resolve(details)

                context.commit('getBorrowDetails',...details);
            });
        },

        async makeBorrowAction(context,data){
            context.commit('makeBorrow',data)
        },
        async makeBorrowLoanAction(context,data){
            context.commit('makeBorrowLoan',data)
        },
        async deleteBorrowItemAction(context,data){
            context.commit("deleteBorrowItem",data)
        },
        async deleteBorrowLoanItemAction(context,data){
            context.commit("deleteBorrowLoanItem",data)
        },
        async getCreditTotalAction(context,data){
            context.commit("getCreditTotal",data);
        },
        async getCreditTotalLoanAction(context,data){
            context.commit("getCreditTotalLoan",data);
        },
        RESET_EXPENSE_ACTION(context){
            context.commit('RESET_EXPENSE');
        },
        async storeMadeExpenseAction(context,expenseInfo){
            if(context.getters.loggedIn){
                return new Promise((resolve,reject)=>{
                    Axios.post('/api/store-expense',expenseInfo,{
                        headers:{
                            Authorization: "Bearer "+context.state.token
                        }
                    }).then(res=>{
                        let data = res.data.expense;
                        const index1 = data.uuid;
                        const index2 = data.token;
                        console.log({index1,index2});

                        console.log({data});
                        window.location.href = `/print-expense?index1=${index1}&index2=${index2}`
                    }).catch(err=>{
                        console.log(err);
                        reject(err)
                    })
                });
            }
        },
        async getAccountsAction(context,payload){

            if(!payload){
                payload = null
            }
            else if(payload!==null){
            }

            let accounts= null;
            Axios.get('/api/get_accountz',{
                headers:{
                    Authorization: "Bearer "+context.state.token
                },
                params:{
                    term:'',
                    accBorrow:payload!==null?'true':'false',
                    account:''
                },
            }).then(response=>{
                accounts = response.data.data;
                context.commit('getAccounts',accounts);
            }).catch(err=>{console.log(err);context.commit('getAccounts',[]);})
        },
        async getBorrowAccountsAction(context,payload){
            if(!payload){
                payload = null
            }
            else if(payload!==null){
            }

            let accounts= null;
            Axios.get('/api/get_accountz',{
                headers:{
                    Authorization: "Bearer "+context.state.token
                },
                params:{
                    term:payload!==null?payload.term:'',
                    accBorrow:payload!==null?'true':'false',
                    account:payload!==null?payload.account:''
                },
            }).then(response=>{
                accounts = response.data.data;
                context.commit('getBorrowAccounts',accounts);
            }).catch(err=>{console.log(err);context.commit('getAccounts',[]);})
        },
        async SET_SELECTED_ACCOUNT_ACTION(context,payload){
            context.commit('SET_SELECTED_ACCOUNT',payload);
        },
        async getLoanAccountsAction(context){
            let accounts= null;
            Axios.get('/api/getloanaccounts',{
                headers:{
                    Authorization: "Bearer "+context.state.token
                }
            }).then(response=>{
                accounts = response.data.data;
                context.commit('getLoanAccounts',accounts);
            }).catch(err=>{console.log(err);context.commit('getAccounts',[]);})
        },
        //expense start
        async searchEmployeesAction(context,query){
            let params = {
                query
            };

            Axios.get('/api/v1/getEmployees',{params}).then(
                res =>{
                    context.commit('SET_EMPLOYEES',res.data)
                }
            ).catch(err=>console.log(err))

        },
        async getEmployeesAction(context,val,page){

           if(val!==null) return new Promise((resolve,reject)=>{

                Axios.get('/api/v1/getEmployees',{
                    headers:{
                        Authorization: "Bearer "+context.state.token
                    },
                    params:{
                        query:val,
                        rowsPerPage:page
                    }
                }).then(
                    res =>{
                        context.commit('SET_EMPLOYEES',res.data);
                        resolve(res.data);
                    }
                ).catch(err=>{
                    console.log(err)
                    reject(err)
                })

            })



        },

        async gettotalSubstractionAction(context,data){
            context.commit('gettotalSubstraction',data)
        },

        async getEmployeesPaginationAction(context,sortBy){

            if(sortBy.val!==null) return new Promise((resolve,reject)=>{
                let page_number = sortBy.page || context.state.employeePagination.page;
                let rowsPerPage = sortBy.rowsPerPage || context.state.employeePagination.rowsPerPage;
                let sortRowsBy =  sortBy.sortRowsBy || context.state.EmployeeSortRowsBy;
                let sortDesc = sortBy.sortDesc|| false;


                 Axios.get('/api/v1/getEmployees?page='+page_number+'&rowsPerPage='+rowsPerPage,{
                     headers:{
                         Authorization: "Bearer "+context.state.token
                     },
                     params:{
                         query:sortBy.val,
                         sortRowsBy:sortRowsBy,
                         sortDesc:sortDesc
                     }
                 }).then(
                     res =>{
                         context.commit('SET_EMPLOYEES',res.data);
                         resolve(res);
                     }
                 ).catch(err=>{
                     console.log(err)
                     reject(err)
                 })

             })



         },
         async saveEmployeeInfoAction(context,payload){

             return new Promise((resolve,reject)=>{
                    axios.post(`/api/v1/saveSalaryEmployee`,{
                        setSalary:payload.setSalary,
                        worker_id:payload.worker_id,
                        worker_salary:payload.worker_salary,
                    },{
                        headers:{
                         Authorization: "Bearer "+context.state.token
                     }
                    })
                    .then((res)=>{
                    context.commit('SAVE_EMPLOYEE_INFO',res.data.user);
                    resolve(res.data.user);

                    })
                    .catch((err)=>{
                        console.log(err);
                        reject(err);
                        })
             });
         }
        //expense end

    },
    inject:["eventBus","restDataSource"],

});
