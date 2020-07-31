<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row flat>
                   <v-col cols="12">
                       <payments-graph/>
                    </v-col>
                    <v-col cols="12">
                       <expenses-graph/>
                    </v-col>
                    <v-col cols="12">
                       <income-statements-graph/>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import IncomeStatementsCharts from "./IncomeStatementsCharts";
    export default {
        name:'FinancialGraphs',
    }
</script>

<style>

</style>
