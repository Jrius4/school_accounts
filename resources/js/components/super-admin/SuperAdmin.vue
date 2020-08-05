<template>
  <v-app>
    <v-content class="indigo lighten-2">
      <v-container>
        <v-row>
          <v-col cols="12" xl="7" lg="7" md="7">
            <v-card class="sticky">
              <v-toolbar color="indigo darken-1" dark flat>
                <v-toolbar-title>Manage Users' Roles, and Permissions</v-toolbar-title>

                <v-spacer></v-spacer>
                <v-btn icon>
                  <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>

                <template v-slot:extension>
                  <v-tabs v-model="tab" align-with-title>
                    <v-tabs-slider color="yellow"></v-tabs-slider>

                    <v-tab>Roles</v-tab>
                    <v-tab>Permissions</v-tab>
                    <v-tab>Staffs</v-tab>
                  </v-tabs>
                </template>
              </v-toolbar>

              <v-tabs-items v-model="tab">
                <v-tab-item>
                  <v-card flat>
                    <Roles />
                  </v-card>
                </v-tab-item>
                <v-tab-item>
                  <v-card flat>
                    <Permissions />
                  </v-card>
                </v-tab-item>
                <v-tab-item>
                  <v-card flat>
                    <SystemUsers />
                  </v-card>
                </v-tab-item>
              </v-tabs-items>
            </v-card>
          </v-col>
          <v-col cols="12" justify="center" xl="5" lg="5" md="5">
            <div class="sticky">
              <v-card>
                <v-sheet elevation="10" class="py-4 px-1">
                  <v-card-title>Create</v-card-title>
                  <v-chip-group mandatory active-class="primary--text">
                    <v-chip @click="formSelector('role')">Role</v-chip>
                    <v-chip @click="formSelector('permission')">Permission</v-chip>
                    <v-chip @click="formSelector('user')">User</v-chip>
                  </v-chip-group>
                </v-sheet>

                <v-card-text>
                  <h2>Create {{formTitle}} Form</h2>
                  <v-window v-model="formStep">
                    <v-window-item :value="1">
                      <v-form @submit.prevent="storeRole()">
                        <v-text-field label="Name" v-model="roleName" />

                        <div class="row">
                          <div class="col-12">
                            <h5>Grant Permissions</h5>
                            <v-card class="mx-auto" max-width="500">
                              <v-sheet class="pa-4 indigo darken-2">
                                <v-text-field
                                  v-model="searchPermissions"
                                  label="Search Permissions"
                                  dark
                                  flat
                                  solo-inverted
                                  hide-details
                                  clearable
                                  clear-icon="mdi-close-circle-outline"
                                ></v-text-field>
                              </v-sheet>
                              <v-card-text>
                                <v-col cols="12">
                                  <v-treeview
                                    v-model="PermissionSelection"
                                    selectable
                                    :items="items"
                                    :search="searchPermissions"
                                    :open.sync="open"
                                    :selection-type="`leaf`"
                                    return-object
                                    dense
                                  >
                                    <template v-slot:prepend="{ item }">
                                      <v-icon
                                        v-if="item.children"
                                        v-text="`mdi-${item.id === 1 ? 'home-variant' : 'folder-network'}`"
                                      ></v-icon>
                                    </template>
                                  </v-treeview>
                                </v-col>

                                <v-divider vertical></v-divider>
                                <v-col class="pa-2" cols="12">
                                  <template v-if="!PermissionSelection.length">No nodes selected.</template>
                                  <template v-else>
                                    <v-chip
                                      v-for="node in PermissionSelection"
                                      :key="node.id"
                                      class="indigo darken-4 permisions"
                                      dark
                                    >
                                      <v-icon
                                        fab
                                        small
                                        color="red"
                                        @click="removePermission(node)"
                                      >mdi-delete</v-icon>
                                      {{" "}}
                                      {{ node.name }}
                                    </v-chip>
                                  </template>
                                </v-col>
                              </v-card-text>
                            </v-card>
                          </div>
                        </div>
                        <v-textarea label="Description" v-model="roleDescription" />

                        <div class="form-group">
                          <v-btn type="submit" class="btn-block" small color="indigo" dark>Save</v-btn>
                        </div>

                        <div class="form-group">
                          <v-btn class="btn-block" small color="red light-2" dark>Cancel</v-btn>
                        </div>
                      </v-form>
                    </v-window-item>
                    <v-window-item :value="2">
                      <h3>Permissions</h3>
                    </v-window-item>
                    <v-window-item :value="3">
                      <h3>Users</h3>
                    </v-window-item>
                  </v-window>
                </v-card-text>
              </v-card>
            </div>
          </v-col>
        </v-row>
        <ModalItem />
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import Roles from "./Roles";
import Permissions from "./Permissions";
import SystemUsers from "./SystemUsers";
import { mapState } from "vuex";
export default {
  name: "SuperAdmin",
  components: { Roles, Permissions, SystemUsers },

  data() {
    return {
      tab: null,
      tags: ["Role", "Permission", "User"],
      formStep: 1,
      PermissionSelection: [],
      open: [1, 2],
      search: null,
      searchPermissions: "",
      roleName: "",
      roleDescription: "",
    };
  },
  mounted() {
    this.getPermissions();
  },
  computed: {
    ...mapState({
      permissions: (state) => state.rolesModule.permissions,
    }),
    items() {
      const arr = Object.entries(this.permissions);

      const children = arr.map((permission, index) => ({
        id: this.$root.uuid.createUUID(),
        name: permission[0],
        children: permission[1],
      }));

      return [
        {
          id: this.$root.uuid.createUUID(),
          name: "All Permissions",
          children,
        },
      ];
    },
    formTitle() {
      switch (this.formStep) {
        case 1:
          return "Roles";
        case 2:
          return "Permissions";
        case 3:
          return "Users";
        default:
          return "Users";
      }
    },
  },
  methods: {
    getPermissions() {
      let search = this.searchPermissions || null;
      let data = {
        query: search,
      };
      this.$store.dispatch("rolesModule/GET_PERMISSIONS_ACTION", data);
    },
    removePermission(item) {
      let index = this.PermissionSelection.findIndex((p) => p.id == item.id);
      this.PermissionSelection.splice(index, 1);
    },
    storeRole() {
      if (!this.roleName) {
        let alert = {
          status: "failed",
          open: true,
          message: "role name is required",
          title: "Action Failed!",
        };
        this.$store.dispatch("alertActionModule/ALERT_ACTION", alert);
      } else {
        console.log("ye", this.roleName);
        let permission = "";

        if (this.PermissionSelection.length > 0) {
          permission = [];
          this.PermissionSelection.forEach((item) => {
            permission.push(item.id);
          });
        }
        let data = {
          name: this.roleName,
          permissions: permission,
          description: this.roleDescription,
        };
        this.$store
          .dispatch("rolesModule/STORE_ROLE_ACTION", data)
          .then((res) => {
            this.PermissionSelection = [];
            this.roleName = "";
            this.roleDescription = "";

            let alert = {
              status: "successful",
              open: true,
              message: res.message || "role successfully Stored",
              title: "Action Successful",
            };
            this.$store.dispatch("alertActionModule/ALERT_ACTION", alert);
          })
          .catch(() => {
            let alert = {
              status: "failed",
              open: true,
              message: "Save Role Action Failed",
              title: "Action Failed!",
            };
            this.$store.dispatch("alertActionModule/ALERT_ACTION", alert);
          });
      }
    },
    formSelector(val) {
      console.log(val);
      if (val.includes("role")) {
        console.log("role");
        this.formStep = 1;
      } else if (val.includes("permission")) {
        console.log("permission");
        this.formStep = 2;
      } else if (val.includes("user")) {
        console.log("user");
        this.formStep = 3;
      }
    },
    getChildren(type) {
      const permission = [];

      for (const brewery of this.permission) {
        if (brewery.brewery_type !== type) continue;

        permission.push({
          ...brewery,
          name: this.getName(brewery.name),
        });
      }

      return breweries.sort((a, b) => {
        return a.name > b.name ? 1 : -1;
      });
    },
    getName(name) {
      return `${name.charAt(0).toUpperCase()}${name.slice(1)}`;
    },
  },
  watch: {
    searchPermissions(val) {
      if (!val) {
        this.searchPermissions = "";
      } else if (this.searchPermissions !== "") {
        this.getPermissions();
      }

      this.getPermissions();
    },
  },
};
</script>

<style lang="css" scoped>
.sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
.permisions {
  display: -webkit-inline-flex;
  display: inline-flex;
  margin-block-start: 0.3rem;
  margin-inline: 0.3rem;
}
</style>
