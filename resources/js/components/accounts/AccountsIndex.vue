<template>
    <v-app>
        <AccountTypes/>
        <Accounts/>
        <ModalItem/>
    </v-app>
</template>

<script>
import AccountTypes from "./AccountTypes";
import Accounts from "./Accounts";
    export default {
        components:{
            AccountTypes,Accounts
        }

    }
</script>

<style lang="scss" scoped>

</style>
