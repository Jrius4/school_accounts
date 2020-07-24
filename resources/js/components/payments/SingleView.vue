<template>
    <v-app>
        <v-content>
        <div class="invoice overflow-auto">
            <div style="min-width: 400px">
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to">
                            <div class="text-gray-light">CASH RECIEPT:</div>
                            <h2 class="to">{{payment.paid_by}}</h2>
                        </div>
                        <div class="col invoice-details">
                            <h1 class="invoice-id">RECIEPT NUMBER: {{payment.reciept_no}}</h1>
                            <div class="date">CATEGORY: {{payment.paymentType}}</div>
                            <div class="date">Date of Invoice: {{payment.created_at | moment}}</div>
                            <div class="date">Amount Paid: {{payment.fullAmount | currency}}</div>
                            <div class="date">Amount Balance: {{payment.balance | currency}}</div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" colspan="2">SECTION</th>
                                <th class="text-right">BALANCE</th>
                                <th class="text-right" colspan="2">PAID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(fee,ind) in JSON.parse(payment.paidItems)" :key="`pa-${ind}`">
                                <td class="no">{{++ind}}</td>
                                <td class="text-left" colspan="2">
                                    <h3>{{fee.account_name}}</h3>
                                </td>
                                <td class="unit">{{fee.balance | currency}}</td>
                                <td class="total" colspan="2">{{fee.deposited | currency}}</td>
                            </tr>
                        </tbody>
                        <tfoot>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">BALANCE: {{payment.balance | currency}}</td>
                                <td colspan="2">GRAND TOTAL</td>
                                <td>{{payment.fullAmount | currency}}</td>
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
        props:['payment'],
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
