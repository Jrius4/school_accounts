<template>
  <v-app style="height:150px">
    <v-card-text class="teal white--text elevation-6">
      <h3>User Dashboard</h3>
      <p>
        Welcome
        <span
          v-if="user !== null"
          class="font-italic"
        >{{`${user.first_name?user.first_name:""}${user.given_name?" "+user.given_name:""} ${user.last_name?user.last_name:""}`}}</span>
        <span v-if="user == null" class="font-italic">username</span>.
      </p>
    </v-card-text>
  </v-app>
</template>

<script>
import Axios from "axios";
export default {
  data: function () {
    return {
      user: null,
    };
  },
  methods: {},
  async created() {
    this.$store
      .dispatch("getUserTokenAcion")
      .then((response) => {})
      .catch((err) => {
        console.error(err);
      });
    this.$store
      .dispatch("getUserAction")
      .then((response) => {
        this.user = this.$store.state.user;
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>

<style lang="css" scoped>
.teal {
  padding: 1.5rem;
  font-size: 1.3rem;
  background-color: #005252;
  font-weight: 400;
  color: #ffffff;
}
</style>
