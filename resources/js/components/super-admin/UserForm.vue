<template>
  <v-app>
    <div>
      <v-form @submit.prevent="CreateUser()" ref="form">
        <div class="row">
          <div class="col-12">
            <v-text-field
              ref="memberLastName"
              dense
              outlined
              label="Member last Name"
              v-model="
                                                                memberLastName
                                                            "
              :rules="[
                                                                () =>
                                                                    !!memberLastName ||
                                                                    'Last Name is required'
                                                            ]"
              :error-messages="
                                                                errorMessages
                                                            "
              :hint="
                                                                `Last Name is required`
                                                            "
              required
            />
          </div>
          <div class="col-12">
            <v-text-field
              ref="memberFirstName"
              dense
              outlined
              label="Member First Name"
              :rules="[
                                                                () =>
                                                                    !!memberFirstName ||
                                                                    'First Name is required'
                                                            ]"
              :error-messages="
                                                                errorMessages
                                                            "
              :hint="
                                                                `First Name is required`
                                                            "
              required
              v-model="
                                                                memberFirstName
                                                            "
            />
          </div>
          <div class="col-12">
            <v-text-field
              dense
              outlined
              label="Member Middle Name"
              v-model="
                                                                memberMiddleName
                                                            "
            />
          </div>
          <div class="col-12">
            <v-text-field
              dense
              outlined
              label="Member Username"
              v-model="
                                                                memberUsername
                                                            "
              :rules="
                                                                usernameRules
                                                            "
            />
          </div>
          <div class="col-12">
            <v-text-field
              prepend-icon="mdi-mail"
              outlined
              dense
              label="Email Address"
              v-model="
                                                                memberEmail
                                                            "
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
              v-model="
                                                                memberContact
                                                            "
            />
          </div>
          <v-col cols="12">
            <v-text-field
              outlined
              v-model="memberPassword"
              :append-icon="
                            show1
                                ? 'mdi-eye'
                                : 'mdi-eye-off'
                        "
              :type="
                    show1
                        ? 'text'
                        : 'password'
                "
              name="input-10-1"
              label="Member Password"
              hint="At least 8 characters"
              counter
              @click:append="
                                                                show1 = !show1
                                                            "
              ref="memberPassword"
              required
              :error-messages="
                                                                errorMessages
                                                            "
            ></v-text-field>
          </v-col>
        </div>

        <div class="row">
          <div class="col-12">
            <h5>Grant Roles</h5>
            <v-card class="mx-auto" max-width="500">
              <v-sheet class="pa-4 teal darken-2">
                <v-text-field
                  v-model="
                                                                        searchRole
                                                                    "
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
                    :search="
                                                                            searchRole
                                                                        "
                    :open.sync="
                                                                            openRoles
                                                                        "
                    :selection-type="
                                                                            `leaf`
                                                                        "
                    return-object
                    dense
                  >
                    <template v-slot:prepend="{item}">
                      <v-icon
                        v-if="item.children"
                        v-text="`mdi-${item.id ===1? 'home-variant': 'folder-network'}`"
                      ></v-icon>
                    </template>
                  </v-treeview>
                </v-col>

                <v-divider vertical></v-divider>
                <v-col class="pa-2" cols="12">
                  <template
                    v-if="
                                                                            !UserRoles.length
                                                                        "
                  >
                    No role
                    selected.
                  </template>
                  <template v-else>
                    <v-chip
                      v-for="node in UserRoles"
                      :key="
                                                                                node.id
                                                                            "
                      class="teal darken-4 permisions"
                      dark
                    >
                      <v-icon
                        fab
                        small
                        color="red"
                        @click="
                                                                                    removeRole(
                                                                                        node
                                                                                    )
                                                                                "
                      >mdi-minus-circle</v-icon>
                      {{
                      " "
                      }}
                      {{
                      node.name
                      }}
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
                  v-model="
                                                                        searchUserPermissions
                                                                    "
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
                    v-model="
                                                                            UserPermissionSelection
                                                                        "
                    selectable
                    :items="
                                                                            items
                                                                        "
                    :search="
                                                                            searchUserPermissions
                                                                        "
                    :open.sync="
                                                                            open
                                                                        "
                    :selection-type="
                                                                            `leaf`
                                                                        "
                    return-object
                    dense
                  >
                    <template
                      v-slot:prepend="{
                                                                                item
                                                                            }"
                    >
                      <v-icon
                        v-if="
                                                                                    item.children
                                                                                "
                        v-text="
                                                                                    `mdi-${
                                                                                        item.id ===
                                                                                        1
                                                                                            ? 'home-variant'
                                                                                            : 'folder-network'
                                                                                    }`
                                                                                "
                      ></v-icon>
                    </template>
                  </v-treeview>
                </v-col>

                <v-divider vertical></v-divider>
                <v-col class="pa-2" cols="12">
                  <template
                    v-if="
                                                                            !UserPermissionSelection.length
                                                                        "
                  >
                    No
                    permision
                    selected.
                  </template>
                  <template v-else>
                    <v-chip
                      v-for="node in UserPermissionSelection"
                      :key="
                                                                                node.id
                                                                            "
                      class="indigo darken-4 permisions"
                      dark
                    >
                      <v-icon
                        fab
                        small
                        color="red"
                        @click="
                                                                                    removeUserPermission(
                                                                                        node
                                                                                    )
                                                                                "
                      >mdi-minus-circle</v-icon>
                      {{
                      " "
                      }}
                      {{
                      node.name
                      }}
                    </v-chip>
                  </template>
                </v-col>
              </v-card-text>
            </v-card>
            <v-card class="mt-2 elevation-2">
              <v-card-title>
                <h5>
                  Profile
                  Picture
                </h5>
              </v-card-title>
              <v-card-text>
                <div>
                  <div class="col-12 position-relative">
                    <input
                      class="form-control"
                      accept="image/jpeg, image/png"
                      type="file"
                      ref="files"
                      id="files"
                      multiple
                      v-on:change="
                                                                                handleFiles()
                                                                            "
                    />
                    <p>
                      Add
                      file
                      here...
                      <i
                        class="fas fa-upload"
                      ></i>
                    </p>
                  </div>
                  <div class="col-12">
                    <div class="col-12">
                      <div
                        v-for="(file,
                                                                                key) in files"
                        :key="
                                                                                    `f-${key}`
                                                                                "
                        class="file-listing"
                      >
                        <img
                          class="preview"
                          v-bind:ref="
                                                                                        'preview' +
                                                                                            parseInt(
                                                                                                key
                                                                                            )
                                                                                    "
                        />
                        {{
                        `${file.name}`.substr(
                        0,
                        10
                        ) +
                        `${
                        `${file.name}`
                        .length >
                        10
                        ? "..."
                        : ""
                        }`
                        }}
                        <br />
                        <span
                          v-if="
                                                                                        rulesStatus[
                                                                                            key
                                                                                        ]
                                                                                    "
                          class="text-success"
                        >
                          {{
                          rules[
                          key
                          ]
                          }}
                        </span>
                        <span v-else class="text-danger">
                          {{
                          rules[
                          key
                          ]
                          }}
                        </span>
                        <div
                          class="success-container"
                          v-if="
                                                                                        file.id >
                                                                                            0
                                                                                    "
                        >
                          Success
                          <input
                            type="hidden"
                            :name="
                                                                                            input_name
                                                                                        "
                            :value="
                                                                                            file.id
                                                                                        "
                          />
                        </div>
                        <div class="remove-container" v-else>
                          <a
                            class="remove"
                            v-on:click="
                                                                                            removeFile(
                                                                                                key
                                                                                            )
                                                                                        "
                          >Remove</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <v-card-actions>
                  <div class="d-block col-12">
                    <v-btn type="submit" color="teal darken-2" class="btn-block" small dark>
                      Create
                      User
                    </v-btn>
                    <v-btn
                      @click="
                                                                                cancelCreateUser()
                                                                            "
                      color="orange darken-2"
                      class="btn-block"
                      small
                      dark
                    >Cancel</v-btn>
                  </div>
                </v-card-actions>
              </v-card-text>
            </v-card>
          </div>
        </div>
      </v-form>
    </div>
  </v-app>
</template>

<script>
import { mapState } from "vuex";
export default {
  name: "UserForm",
  data: () => {
    return {
      formStep: 3,
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
      show1: false,
      rulesPassword: {
        required: (value) => "",
        min: (v) => "",
        // required: (value) => !!value || "Required.",
        // min: (v) => (v || "").length >= 5 || "Min 5 characters",
      },

      memberLastName: "",
      memberFirstName: "",
      memberMiddleName: "",
      memberUsername: "",
      memberEmail: "",
      memberContact: "",
      memberPassword: "",
      emailRules: [],
      usernameRules: [],
      selePermissions: [],
      files: [],
      rules: [],
      rulesStatus: [],
      fileType: [],
      groupI: "",
      errorMessages: "",
      formHasErrors: false,
    };
  },

  mounted() {
    this.getPermissions();
    this.getRoles();
    this.userSelected();
  },
  computed: {
    ...mapState({
      selectedUser: (state) => state.usersModule.selectedUser,
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

    form() {
      return {
        memberLastName: this.memberLastName,
        memberFirstName: this.memberFirstName,
        memberPassword: this.memberPassword,
      };
    },
  },
  methods: {
    CreateUser() {
      let roles = [];
      this.UserRoles.forEach((r) => {
        roles.push(r.id);
      });
      let permisions = [];
      this.UserPermissionSelection.forEach((p) => {
        permisions.push(p.id);
      });
      this.formHasErrors = false;

      Object.keys(this.form).forEach((f) => {
        if (!this.form[f]) this.formHasErrors = true;

        this.$refs[f].validate(true);
      });

      if (this.formHasErrors) {
        this.$toast.error({
          title: "Invalid Input",
          message: "Check Through Required Fields!",
          color: "tomato",
          timeOut: 5000,
          showMethod: "lightSpeedIn",
          hideMethod: "slideOutUp",
        });
      } else {
        const data = {
          username: this.memberUsername,
          email: this.memberEmail,
          first_name: this.memberFirstName,
          last_name: this.memberLastName,
          given_name: this.memberMiddleName,
          password: this.memberPassword,
          contact: this.memberContact,
          roles: roles,
          permissions: permisions,
          files: this.files,
        };
        console.log(data);

        // this.$store
        //   .dispatch("rolesModule/SAVE_USER_ACTION", data)
        //   .then((res) => {
        //     const message = res.message;
        //     this.memberLastName = "";
        //     this.memberFirstName = "";
        //     this.memberMiddleName = "";
        //     this.memberUsername = "";
        //     this.memberEmail = "";
        //     this.memberContact = "";
        //     this.memberPassword = "password";
        //     this.emailRules = [];
        //     this.usernameRules = [];
        //     this.files = [];
        //     this.rules = [];
        //     this.rulesStatus = [];
        //     this.fileType = [];
        //     this.groupI = "";
        //     this.UserPermissionSelection = [];
        //     this.UserRoles = [];
        //     this.searchUserPermissions = "";
        //     this.formHasErrors = false;
        //     this.errorMessages = [];

        //     Object.keys(this.form).forEach((f) => {
        //       this.$refs[f].reset();
        //     });
        //     this.$toast.success({
        //       title: "Successful",
        //       message: message,
        //       color: "teal",
        //       timeOut: 5000,
        //       showMethod: "lightSpeedIn",
        //       hideMethod: "slideOutUp",
        //     });
        //   })
        //   .catch((err) => {
        //     this.$toast.error({
        //       title: "Invalid Input",
        //       message: err,
        //       color: "tomato",
        //       timeOut: 5000,
        //       showMethod: "lightSpeedIn",
        //       hideMethod: "slideOutUp",
        //     });
        // });
      }
    },

    resetCreateUserForm() {
      this.errorMessages = [];
      this.formHasErrors = false;

      Object.keys(this.form).forEach((f) => {
        this.$refs[f].reset();
      });
    },
    cancelCreateUser() {},

    genPassword() {
      let s = [];
      let hexDigits = `${this.memberFirstName}${this.memberMiddleName}${this.memberLastName}&@${this.memberEmail}`;
      for (var i = 0; i < 8; i++) {
        s[i] = hexDigits.substr(
          Math.floor((Math.random() * 100) % (hexDigits.length - 1)),
          1
        );
      }
      // s[4] = 4;
      // s[3] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);
      // s[3] = s[4] = s[7] = s[2] = "*^^%^%";
      var uuid = s.join("");
      this.memberPassword = uuid;
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
    async userSelected() {
      let user = this.selectedUser || {};
      this.memberFirstName = user.first_name || "";
      this.memberLastName = user.last_name || "";
      this.memberMiddleName = user.given_name || "";
      this.memberUsername = user.username || "";
      this.memberEmail = user.email || "";
      this.UserPermissionSelection = user.permissions || "";
      this.UserRoles = user.roles || "";
      this.memberContact = user.contact || "";
    },
  },
  watch: {
    selectedUser() {
      this.userSelected();
    },
    searchRole(val) {
      if (!val) {
        this.searchRole = "";
      } else if (this.searchRole !== "") {
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

<style lang="scss" scoped>
</style>
