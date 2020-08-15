<template>
  <v-app>
    <v-row justify="center" flat>
      <v-col>
        <v-card class="mx-auto" flat>
          <v-card-title class="title font-weight-regular justify-space-between">
            <v-icon @click="tableView()" v-if="userStep !== 1">mdi-table-arrow-left</v-icon>
            <span>
              <v-icon v-if="userStep === 3">mdi-account-tie</v-icon>
              {{" "}}
              {{ currentTitle }}
            </span>

            <v-avatar
              color="primary lighten-2"
              class="subheading white--text"
              size="24"
              v-text="userStep"
            ></v-avatar>
          </v-card-title>
          <v-window v-model="userStep">
            <v-window-item :value="1">
              <v-col cols="12" lg="12">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th colspan="4">Available Members</th>
                      <th>
                        <v-btn
                          id="refreshBtn"
                          small
                          text
                          color="blue"
                          class="float-left mt-4"
                          @click="editItem(null)"
                        >
                          <v-icon>mdi-plus</v-icon>Add
                          account
                        </v-btn>
                      </th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <v-text-field
                          v-model="search"
                          append-icon="mdi-database-search"
                          label="Quick Search"
                          clearable
                        ></v-text-field>
                      </td>
                      <td></td>
                      <td>
                        <v-btn
                          id="refreshBtn"
                          small
                          text
                          color="blue"
                          class="float-left mt-4"
                          @click="refreshaccounts"
                        >
                          <v-icon>mdi-refresh</v-icon>Refresh
                        </v-btn>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">Member</th>
                      <th>Number Of Roles</th>
                      <th>Number Of Permissions</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, k) in users" :key="`${k}user`">
                      <td colspan="2">
                        <div class="row d-block">
                          <v-avatar
                            v-if="user.image"
                            size="50"
                            class="mx-auto elevation-6"
                            color="grey"
                          >
                            <img
                              :src="
                                                                `/files/${
                                                                    user.image
                                                                        ? user.image
                                                                        : 'users_all.png'
                                                                }`
                                                            "
                              :alt="
                                                                `${user.first_name}`
                                                            "
                            />
                          </v-avatar>
                          <span>
                            {{
                            ` ${user.first_name ||
                            ""} ${user.last_name ||
                            ""} ${user.given_name ||
                            ""}`
                            }}
                          </span>
                        </div>
                      </td>
                      <td>
                        {{
                        user.roles
                        ? user.roles.length
                        : "none"
                        }}
                      </td>
                      <td>
                        {{
                        user.permissions
                        ? user.permissions
                        .length
                        : "none"
                        }}
                      </td>
                      <td>
                        <v-icon
                          small
                          fab
                          class="mr-2"
                          color="blue"
                          @click="viewitem(user)"
                        >fa fa-eye</v-icon>
                        <v-icon
                          small
                          fab
                          class="mr-2"
                          color="green"
                          @click="edititem(user)"
                        >fa fa-edit</v-icon>
                        <v-icon
                          small
                          fab
                          class="mr-2"
                          color="red"
                          @click="deleteitem(user)"
                        >fa fa-trash</v-icon>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5">
                        <v-pagination
                          v-model="page"
                          :circle="circle"
                          :disabled="disabled"
                          :length="noPages"
                          :next-icon="nextIcons"
                          :prev-icon="prevIcons"
                          :page="page"
                          :total-visible="
                                                        totalVisible
                                                    "
                        ></v-pagination>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </v-col>
              <v-col cols="12" lg="12"></v-col>
            </v-window-item>
            <v-window-item :value="2">
              <v-row align="center" justify="center">
                <v-col cols="10">
                  <user-form />
                </v-col>
              </v-row>
            </v-window-item>
            <v-window-item :value="3">
              <hr />
              <v-row align="center" justify="center">
                <v-col cols="12" class="my-6"></v-col>
                <v-col cols="12" lg="6" v-if="selectedItem !== null">
                  <base-material-card
                    :avatar="`${selectedItem.image?`/files/${selectedItem.image||'/files/users_all.png'}`:'/files/users_all.png'}`"
                  >
                    <v-card flat>
                      <v-card-text>
                        <table class="table table-sm table-striped">
                          <tbody>
                            <tr class="black lighten-3 white--text">
                              <th>Name</th>
                            </tr>
                            <tr>
                              <td>
                                {{`${selectedItem.first_name || ""} ${
                                selectedItem.last_name || ""
                                } ${selectedItem.given_name || ""}`}}
                              </td>
                            </tr>
                            <tr v-if="selectedItem.email">
                              <td>Email: {{selectedItem.email}}</td>
                            </tr>
                            <tr class="indigo lighten-3">
                              <th>Roles</th>
                            </tr>
                            <tr v-for="(r,k) in selectedItem.roles" :key="`r${k}`">
                              <td>{{r.display_name || r.name}}</td>
                            </tr>
                            <tr class="teal lighten-3">
                              <th>Permissions</th>
                            </tr>
                            <tr v-for="(r,k) in selectedItem.permissions" :key="`p${k}`">
                              <td>{{r.display_name || r.name}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </v-card-text>
                    </v-card>
                  </base-material-card>
                </v-col>
              </v-row>
            </v-window-item>
          </v-window>
        </v-card>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import UserForm from "./UserForm";
export default {
  name: "SystemUsers",
  components: {
    UserForm,
  },
  data: () => {
    return {
      search: "",
      circle: true,
      disabled: false,
      length: 10,
      nextIcon: "navigate_next",
      nextIcons: "mdi-arrow-right",
      prevIcon: "navigate_before",
      prevIcons: "mdi-arrow-left",
      page: 1,
      totalVisible: 5,
      userStep: 1,
      selectedItem: null,
    };
  },
  computed: {
    ...mapState({
      users: (state) => state.usersModule.users,
      selectedUser: (state) => state.usersModule.selectedUser,
      usersPage: (state) => state.usersModule.usersPage,
      totalUsers: (state) => state.usersModule.totalUsers,
      users_per_page: (state) => state.usersModule.users_per_page,
    }),
    noPages() {
      let length = Math.ceil(this.totalUsers / this.users_per_page);
      return length;
    },
    currentTitle() {
      switch (this.userStep) {
        case 1:
          return "Members list";
        case 2:
          return "Members Editor";
        case 3:
          return typeof this.selectedItem === "object"
            ? `${this.selectedItem.first_name || ""} ${
                this.selectedItem.last_name || ""
              } ${this.selectedItem.given_name || ""}`
            : "Member Details";
        default:
          return "Members";
      }
    },
  },
  methods: {
    ...mapMutations({
      disselectUser: "usersModule/SELECT_USER",
    }),
    getUsers() {
      const search = this.search || null;
      const page = this.page || null;
      const pagination = {
        keywords: search,
        page,
      };
      this.$store.dispatch("usersModule/GET_USERS_ACTION", pagination);
    },
    tableView() {
      this.selectedItem = null;
      this.userStep = 1;
      this.disselectUser({ user: null });
    },
    edititem(item) {
      const data = {
        id: item.id || null,
      };

      this.$toast.info({
        title: "Update Member",
        message: "Look at the right Panel",
        color: "#004D41",
        timeOut: 10000,
        showMethod: "lightSpeedIn",
        hideMethod: "slideOutUp",
      });
      this.$store
        .dispatch("usersModule/GET_USERS_ACTION", data)
        .then()
        .catch((err) => console.log(err))
        .finally(() => (this.userStep = 2));
    },
    refreshaccounts() {
      this.page = 1;
      this.search = "";
    },
    viewitem(item) {
      console.log(item);
      this.selectedItem = item;
      this.userStep = 3;
    },
    deleteitem(item) {},
  },
  mounted() {
    this.getUsers();
  },
  watch: {
    search(val) {
      if (!val) {
        this.search = "";
      } else if (this.search !== "") {
        this.getUsers();
      }

      this.getUsers();
    },
    page(val) {
      if (!val) {
        this.search = "";
      } else if (this.search !== "") {
        this.getUsers();
      }

      this.getUsers();
    },
  },
};
</script>

<style lang="scss" scoped></style>
