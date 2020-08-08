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
                                  <template
                                    v-if="!PermissionSelection.length"
                                  >No permisions selected.</template>
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
                                      >mdi-minus-circle</v-icon>
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
                      <v-form @submit="savePermission()">
                        <v-text-field label="name" v-model="permissionName" />
                        <v-textarea label="Description" v-model="permissionDescription" />
                        <div class="form-group">
                          <v-btn
                            type="submit"
                            class="btn-block"
                            small
                            color="green darken-2"
                            dark
                          >Create Permission</v-btn>
                        </div>

                        <div class="form-group">
                          <v-btn class="btn-block" small color="red light-2" dark>Cancel</v-btn>
                        </div>
                      </v-form>
                    </v-window-item>
                    <v-window-item :value="3">
                      <v-form @submit.prevent="CreateUser()">
                        <div class="row">
                          <div class="col-12">
                            <v-text-field
                              dense
                              outlined
                              label="Member last Name"
                              v-model="memberLastName"
                            />
                          </div>
                          <div class="col-12">
                            <v-text-field
                              dense
                              outlined
                              label="Member First Name"
                              v-model="memberFirstName"
                            />
                          </div>
                          <div class="col-12">
                            <v-text-field
                              dense
                              outlined
                              label="Member Middle Name"
                              v-model="memberMiddleName"
                            />
                          </div>
                          <div class="col-12">
                            <v-text-field
                              disabled
                              dense
                              outlined
                              label="Member Username"
                              v-model="memberUsernameFormat"
                              :rules="usernameRules"
                            />
                          </div>
                          <div class="col-12">
                            <v-text-field
                              prepend-icon="mdi-mail"
                              disabled
                              outlined
                              dense
                              label="Email Address"
                              v-model="memberEmailFormat"
                              :rules="emailRules"
                            />
                          </div>
                          <div class="col-12">
                            <v-text-field
                              prepend-icon="mdi-phone"
                              outlined
                              dense
                              prefix="+256"
                              label="Mobile Contact"
                              v-model="memberContact"
                            />
                          </div>
                           <v-col cols="12">
                            <v-text-field
                            outlined
                                v-model="memberPassword"
                                :prepend-icon="'fa fas fa-cog'"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rulesPassword.required, rulesPassword.min]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                label="Member Password"
                                hint="At least 8 characters"
                                counter
                                @click:append="show1 = !show1"
                                @click:prepend="genPassword()"
                            ></v-text-field>
                            </v-col>
                          
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <h5>Grant Roles</h5>
                            <v-card class="mx-auto" max-width="500">
                              <v-sheet class="pa-4 teal darken-2">
                                <v-text-field
                                  v-model="searchRole"
                                  label="Search Roles"
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
                                    v-model="UserRoles"
                                    selectable
                                    :items="itemRoles"
                                    :search="searchRole"
                                    :open.sync="openRoles"
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
                                  <template v-if="!UserRoles.length">No role selected.</template>
                                  <template v-else>
                                    <v-chip
                                      v-for="node in UserRoles"
                                      :key="node.id"
                                      class="teal darken-4 permisions"
                                      dark
                                    >
                                      <v-icon
                                        fab
                                        small
                                        color="red"
                                        @click="removeRole(node)"
                                      >mdi-minus-circle</v-icon>
                                      {{" "}}
                                      {{ node.name }}
                                    </v-chip>
                                  </template>
                                </v-col>
                              </v-card-text>
                            </v-card>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <h5>Grant Permissions</h5>
                            <v-card class="mx-auto" max-width="500">
                              <v-sheet class="pa-4 indigo darken-2">
                                <v-text-field
                                  v-model="searchUserPermissions"
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
                                    v-model="UserPermissionSelection"
                                    selectable
                                    :items="items"
                                    :search="searchUserPermissions"
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
                                  <template
                                    v-if="!UserPermissionSelection.length"
                                  >No permision selected.</template>
                                  <template v-else>
                                    <v-chip
                                      v-for="node in UserPermissionSelection"
                                      :key="node.id"
                                      class="indigo darken-4 permisions"
                                      dark
                                    >
                                      <v-icon
                                        fab
                                        small
                                        color="red"
                                        @click="removeUserPermission(node)"
                                      >mdi-minus-circle</v-icon>
                                      {{" "}}
                                      {{ node.name }}
                                    </v-chip>
                                  </template>
                                </v-col>
                              </v-card-text>
                            </v-card>
                            <v-card class="mt-2 elevation-2">
                              <v-card-title>
                                <h5>Profile Picture</h5>
                              </v-card-title>
                              <v-card-text>
                                <div>
                                <div class="col-12 position-relative ">
                                    <input
                                        class="form-control "
                                        accept="image/jpeg, image/png"
                                        type="file"
                                        ref="files"
                                        id="files"
                                        multiple
                                        v-on:change="handleFiles()"
                                    />
                                    <p>
                                        Add file here...
                                        <i class="fas fa-upload"></i>
                                    </p>
                                    </div>
                                    <div class="col-12">
                                    <div class="col-12">
                                        <div v-for="(file, key) in files" :key="`f-${key}`" class="file-listing">
                                        <img class="preview" v-bind:ref="'preview' + parseInt(key)" />
                                        {{ `${file.name}`.substr(0,10)+`${`${file.name}`.length >10 ?'...':''}` }}
                                        <br />
                                        <span v-if="rulesStatus[key]" class="text-success">{{ rules[key] }}</span>
                                        <span v-else class="text-danger">
                                            {{
                                            rules[key]
                                            }}
                                        </span>
                                        <div class="success-container" v-if="file.id > 0">
                                            Success
                                            <input type="hidden" :name="input_name" :value="file.id" />
                                        </div>
                                        <div class="remove-container" v-else>
                                            <a class="remove" v-on:click="removeFile(key)">Remove</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                
                                
                                </div>
                                <v-card-actions>
                                    <div class="d-block col-12">
                                        <v-btn type="submit" color="teal darken-2" class="btn-block" small dark>
                                         Create User
                                        </v-btn>
                                        <v-btn @click="cancelCreateUser()" color="orange darken-2" class="btn-block" small dark>
                                         Cancel
                                        </v-btn>
                                    </div>
                                </v-card-actions>
                                
                              </v-card-text>
                            </v-card>
                          </div>
                        </div>
                      </v-form>
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
      UserPermissionSelection: [],
      open: [1, 2],
      openRoles: [1, 2],
      search: null,
      searchPermissions: "",
      searchUserPermissions: "",
      roleName: "",
      roleDescription: "",
      permissionName: "",
      permissionDescription: "",

      RoleSelected: [],
      itemRoleSelected: [],
      RoleSeleection: "",
      RoleLoading: false,
      UserRoles: [],
      searchRole: "",
        show1:false,
      rulesPassword: {
          required: value => !!value || 'Required.',
          min: v => v.length >= 8 || 'Min 8 characters',
        },

      memberLastName: "",
      memberFirstName: "",
      memberMiddleName: "",
      memberUsername: "",
      memberEmail: "",
      memberContact: "",
      memberPassword: "password",
      emailRules: [],
      usernameRules: [],

      files: [],
      rules: [],
      rulesStatus: [],
      fileType: [],
      groupI: "",
    };
  },
  mounted() {
    this.getPermissions();
    this.getRoles();
  },
  computed: {
    ...mapState({
      permissions: (state) => state.rolesModule.permissions,
      Roles: (state) => state.rolesModule.roles,
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
    itemRoles() {
      const children = this.Roles.map((role, index) => ({
        id: role.id,
        name: role.name,
      }));

      return [
        {
          id: this.$root.uuid.createUUID(),
          name: "All Roles",
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
    memberEmailFormat: {
      get: function () {
        let email = (
          `${this.memberLastName}`.substr(0, 1) +
          `${this.memberMiddleName}`.substr(0, 1) +
          `${this.memberFirstName}`.substr(0, 1)
        ).toLowerCase();

        this.$store
          .dispatch("rolesModule/CHECK_USERNAME_ACTION", {
            email: email + "@fak.com",
          })
          .then((result) => {
            this.memberEmail = result.email;
          })
          .catch((err) => console.log(err));
        return this.memberEmail;
      },
      set: function (newvalue) {
        // this.memberEmail = newvalue;
      },
    },

    memberUsernameFormat: {
      get: function () {
        let realusername = null;
        let username = (
          `${this.memberLastName}`.substr(0, 1) +
          `${this.memberMiddleName}`.substr(0, 1) +
          `${this.memberFirstName}`.substr(0, 1)
        ).toLowerCase();
        // username = "super_admin";
        this.$store
          .dispatch("rolesModule/CHECK_USERNAME_ACTION", { username })
          .then((result) => {
            this.memberUsername = result.username;
            realusername = result.username;
          })
          .catch((err) => console.log(err));
        return this.memberUsername;
      },
      set: function (newvalue) {
        // this.memberUsername = newvalue;
        // console.log(newvalue);
      },
    },
  },
  methods: {

    CreateUser()
    {
        let roles =[]; 
        this.UserRoles.forEach(r=>{
            roles.push(r.id);
        });
        let permisions =[]; 
        this.UserPermissionSelection.forEach(p=>{
            permisions.push(p.id);
        });
        const data = {
                username:this.memberUsername,
                email:this.memberEmail,
                first_name:this.memberFirstName,
                last_name:this.memberLastName,
                given_name:this.memberMiddleName,
                password:this.memberPassword,
                contact:this.memberContact,
                roles:roles,
                permissions:permisions,
                files:this.files
            };

        this.$store.dispatch('rolesModule/SAVE_USER_ACTION',data);
    },
    cancelCreateUser(){

    },

    genPassword(){
        let s = [];
        let hexDigits = "AaDd^7&$%54$56^7HjyuikKbVvc$%3@#6589*(*86^^";
        for (var i = 0; i < 8; i++) {
            s[i] = hexDigits.substr(Math.floor(Math.random() * 100%(hexDigits.length-1)), 1);
        }
        // s[4] = 4;
        // s[3] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);
        // s[3] = s[4] = s[7] = s[2] = "*^^%^%";
        var uuid = s.join("");
        this.memberPassword = uuid
        return uuid;
    },
    getRoles() {
      this.RoleLoading = true;
      let search = this.searchRole || null;
      let data = {
        query: search,
      };

      this.$store.dispatch("rolesModule/GET_ROLES_ACTION", data).finally(() => {
        this.RoleLoading = false;
      });
    },
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
    removeUserPermission(item) {
      let index = this.UserPermissionSelection.findIndex(
        (p) => p.id == item.id
      );
      this.UserPermissionSelection.splice(index, 1);
    },
    removeRole(item) {
      let index = this.UserRoles.findIndex((p) => p.id == item.id);
      this.UserRoles.splice(index, 1);
    },
    handleRoleSearch() {},
    textRole(item) {
      return item.name;
    },
    valueRoles(item) {},
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
      if (val.includes("role")) {
        this.formStep = 1;
      } else if (val.includes("permission")) {
        this.formStep = 2;
      } else if (val.includes("user")) {
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

    convertBytesToSize(bytes) {
      var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
      if (bytes === 0) return "0 Byte";
      var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
      return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
    },
    handleFiles() {
      let uploadedFiles = this.$refs.files.files;
      this.files = [];
      this.rules = [];
      this.rulesStatus = [];

      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
        if (uploadedFiles[i].size > 1024 * 1024 * 2) {
          this.rules.push(
            "file size is " +
              this.convertBytesToSize(uploadedFiles[i].size) +
              ", let size be atleast < 2MB"
          );
          this.rulesStatus.push(false);
        } else if (uploadedFiles[i].size < 1024 * 1024 * 2) {
          this.rules.push(
            "file size is " + this.convertBytesToSize(uploadedFiles[i].size)
          );
          this.rulesStatus.push(true);
        }
      }

      let data = {
        files: this.files,
        rules: this.rules,
        rulesStatus: this.rulesStatus,
      };
      // this.$store.dispatch('UPLOADED_FILE_ACTION',data);

      this.getImagePreviews();
    },
    getImagePreviews() {
      for (let i = 0; i < this.files.length; i++) {
        if (/\.(jpe?g|png|gif)$/i.test(this.files[i].name)) {
          // this.fileType.push(true);
          let reader = new FileReader();
          reader.addEventListener(
            "load",
            function () {
              this.$refs["preview" + parseInt(i)][0].src = reader.result;
            }.bind(this),
            false
          );
          reader.readAsDataURL(this.files[i]);
        } else {
          this.$nextTick(function () {
            this.$refs["preview" + parseInt(i)][0].src = "/images/generic.png";
          });
        }
      }
    },

    removeFile(key) {
      this.files.splice(key, 1);
      this.rules.splice(key, 1);
      this.rulesStatus.splice(key, 1);
      this.getImagePreviews();
    },
  },
  watch: {
    searchRole(val) {
      if (!val) {
        this.searchRole = "";
      } else if (this.searchRole !== "") {
        this.getPermissions();
      }

      this.getPermissions();
    },
    searchPermissions(val) {
      if (!val) {
        this.searchPermissions = "";
      } else if (this.searchPermissions !== "") {
        this.getPermissions();
      }

      this.getPermissions();
    },
    searchUserPermissions(val) {
      if (!val) {
        this.searchUserPermissions = "";
      } else if (this.searchUserPermissions !== "") {
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
input[type="file"] {
     

  opacity: 0;
  width: 50%;
  height: 1em;
  position: absolute;
  cursor: pointer;
}
div.file-listing img {
  max-width: 65%;
}

div.file-listing {
  margin: auto;
  padding: 0.8px;
  border-bottom: 0.3px solid #ddd;
  overflow-x: hidden;
}

div.file-listing img {
  height: 1.5em;
}
div.success-container {
  text-align: center;
  color: green;
}

div.remove-container {
  text-align: center;
}

div.remove-container a {
  color: red;
  cursor: pointer;
}
.files {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;

  border: 2px dashed #ccecc359;
  min-height: auto;
  background: #5769520d;
  padding: 0.2rem;
}
.file {
  bottom: 1rem;
  align-self: flex-end;
  max-width: 2.5rem;
  max-height: auto;
}
.file-pdf {
  width: 200px;
  height: 150px;
  margin-block-start: 0.3rem;
}
</style>
