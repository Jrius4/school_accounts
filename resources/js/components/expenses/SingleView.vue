<template>
    <v-app>
        <v-content>
        <div class="invoice overflow-auto">
            <div style="min-width: 400px">
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to">
                            <div class="text-gray-light">CASH RECIEPT:</div>
                            <h2 class="to">{{expense.requested_by}}</h2>
                        </div>
                        <div class="col invoice-details">
                            <h1 class="invoice-id">RECIEPT NUMBER: {{expense.token}}</h1>
                            <div class="date">CATEGORY: {{expense.expensetype}}</div>
                            <div class="date">Date of Invoice: {{expense.created_at | moment}}</div>
                            <div class="date">Amount Paid: {{expense.expenseTotal | currency}}</div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr v-if="expense.expenseItems!==null">
                                <th>#</th>
                                <th class="text-left" colspan="2">DESCRIPTION</th>
                                <th class="text-right">RATE</th>
                                <th class="text-right">QTY</th>
                                <th class="text-right" colspan="2">AMOUNT</th>
                            </tr>
                            <tr v-if="(expense.expensetype).toLowerCase() === 'salary'">
                                <th class="text-left" colspan="2">Description</th>
                                <th class="text-left">Salary Type</th>
                                <th class="text-left" colspan="2">Recieved</th>
                            </tr>

                        </thead>
                        <tbody v-if="expense.expenseItems!==null">
                            <tr v-for="(exp,ind) in JSON.parse(expense.expenseItems)" :key="`pa-${ind}`">
                                <td class="no">{{++ind}}</td>
                                <td class="text-left" colspan="2">
                                    <h3>{{exp.name}}</h3>
                                    <p>{{exp.description}}</p>
                                </td>
                                <td class="unit">{{exp.rate | currency}}</td>
                                <td class="qty">{{exp.quantity | currency}} <small>{{exp.units}}</small></td>
                                <td class="total" colspan="2">{{exp.amount | currency}}</td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr v-if="(expense.expensetype).toLowerCase() === 'salary'">
                                <td colspan="2">
                                    <h3 v-if="expense.worker !== null">
                                        {{(JSON.parse(expense.worker)).name}}
                                    </h3>
                                    <h5>Recieved By</h5>
                                    <p>{{expense.requested_by}}</p>
                                </td>
                                <td class="unit">
                                    {{expense.salaryPaymentType}}
                                </td>
                                <td class="total" colspan="2">{{expense.expenseTotal | currency}}</td>
                            </tr>
                        </tbody>
                        <tfoot>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td>{{expense.expenseTotal | currency}}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <table v-if="expense.makeBorrowItems !== null">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    Total Borrow From Others
                                </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th class="qty">Balance</th>
                                <th>Borrowed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bor,ind) in JSON.parse(expense.makeBorrowItems)" :key="ind">
                                <th class="no">{{++ind}}</th>
                                <td>{{bor.selectedAccount.name}}</td>
                                <td class="qty">{{(parseInt(bor.selectedAccount.balance) - parseInt(bor.credit)) | currency}}</td>
                                <td class="total">{{bor.credit | currency}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2">Total Credit: {{expense.totalBorrow | currency}}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <table v-if="expense.makeLoanBorrowItems !== null">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    Total Borrow From Other Loans
                                </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Account Name</th>
                                <th class="qty">Balance</th>
                                <th>Borrowed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(loa,inlo) in JSON.parse(expense.makeLoanBorrowItems)" :key="inlo">
                                <th class="no">{{++inlo}}</th>
                                <td>{{loa.selectedAccount.name}}</td>
                                <td class="qty">{{(parseInt(loa.selectedAccount.balance) - parseInt(loa.credit)) | currency}}</td>
                                <td class="total">{{loa.credit | currency}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2">Total Credit: {{expense.totalBorrowLoan | currency}}</td>
                            </tr>
                        </tfoot>
                    </table>

                </main>

            </div>
            <div></div>
        </div>
        </v-content>
    </v-app>
</template>

<script>
import moment from 'moment';
    export default {
        name:'SingleView',
        props:['expense'],
        methods:{

        },
        mounted(){

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
        },
    }
</script>

<style lang="css" scoped>
#invoice{
    padding: 30px;
}

.invoice {
    font-size: 0.8rem;
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3947c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3947c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 0.9rem;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3947c6
}

.invoice main .notices .notice {
    font-size: 0.8rem;
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3947c6;
    font-size: 0.9rem;
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 0.9rem
}

.invoice table .no {
    color: #fff;
    font-size: 0.9rem;
    background: #3947c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3947c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 0.9rem;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3947c6;
    font-size: 1rem;
    border-top: 1px solid #3947c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}
.invoice-id{
    font-size: 0.8rem;
}

</style>
