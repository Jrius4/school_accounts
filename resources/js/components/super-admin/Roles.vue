<template>
    <v-app>
        <v-row justify="center" flat>
            <v-col>
                <v-card class="mx-auto" flat>
                    <v-card-title
                        class="title font-weight-regular justify-space-between"
                    >
                        <span>{{ currentTitle }}</span>
                        <v-avatar
                            color="primary lighten-2"
                            class="subheading white--text"
                            size="24"
                            v-text="roleStep"
                        ></v-avatar>
                    </v-card-title>

                    <v-window v-model="roleStep">
                        <v-window-item :value="1">
                            <v-col cols="12" lg="12">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Available Roles</th>
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
                                            <td colspan="2">
                                                <v-text-field
                                                    v-model="search"
                                                    append-icon="mdi-database-search"
                                                    label="Quick Search"
                                                    clearable
                                                ></v-text-field>
                                            </td>
                                            <td>
                                                <v-btn
                                                    id="refreshBtn"
                                                    small
                                                    text
                                                    color="blue"
                                                    class="float-left mt-4"
                                                    @click="refreshaccounts"
                                                >
                                                    <v-icon>mdi-refresh</v-icon
                                                    >Refresh
                                                </v-btn>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Number Of Staffs</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(i, k) in roles" :key="k">
                                            <td colspan="1">
                                                {{ i.display_name }}
                                            </td>
                                            <td>
                                                {{
                                                    i.users
                                                        ? i.users.length
                                                        : "none"
                                                }}
                                            </td>
                                            <td>
                                                <v-icon
                                                    small
                                                    fab
                                                    class="mr-2"
                                                    color="blue"
                                                    @click="viewitem(i)"
                                                    >fa fa-eye</v-icon
                                                >
                                                <v-icon
                                                    small
                                                    fab
                                                    class="mr-2"
                                                    color="green"
                                                    @click="edititem(i)"
                                                    >fa fa-edit</v-icon
                                                >
                                                <v-icon
                                                    small
                                                    fab
                                                    class="mr-2"
                                                    color="red"
                                                    @click="deleteitem(i)"
                                                    >fa fa-trash</v-icon
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-col>
                            <v-col cols="12" lg="12">
                                <v-pagination
                                    v-model="page"
                                    :circle="circle"
                                    :disabled="disabled"
                                    :length="noPages"
                                    :next-icon="nextIcons"
                                    :prev-icon="prevIcons"
                                    :page="page"
                                    :total-visible="totalVisible"
                                ></v-pagination>
                            </v-col>
                        </v-window-item>
                        <v-window-item :value="2">
                            <v-col cols="12" lg="6">
                                <v-form>
                                    <v-text-field
                                        label="Name"
                                        v-model="roleName"
                                    />
                                    <v-btn>Save</v-btn>
                                    <v-btn @click="roleStep = 1">Cancel</v-btn>
                                </v-form>
                            </v-col>
                        </v-window-item>
                    </v-window>
                </v-card>
            </v-col>
        </v-row>
    </v-app>
</template>

<script>
import { mapState } from "vuex";
export default {
    name: "Roles",
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
            roleStep: 1,
            roleName: ""
        };
    },
    mounted() {
        this.getData();
    },
    computed: {
        ...mapState({
            roles: state => state.rolesModule.roles,
            rolesPage: state => state.rolesModule.rolesPage,
            totalRoles: state => state.rolesModule.totalRoles,
            roles_per_page: state => state.rolesModule.roles_per_page,
            selectedRole: state => state.rolesModule.selectedRole
        }),
        noPages() {
            let length = Math.ceil(this.totalRoles / this.roles_per_page);
            return length;
        },
        currentTitle() {
            switch (this.roleStep) {
                case 1:
                    return "Roles list";
                case 2:
                    return "Roles Editor";
                default:
                    return "Roles";
            }
        }
    },
    methods: {
        getData() {
            let search = this.search || null;
            let page = this.page || null;
            let pagination = {
                query: search,
                page
            };

            this.$store.dispatch("rolesModule/GET_ROLES_ACTION", pagination);
        },
        refreshaccounts() {
            this.page = 1;
            this.search = "";
        },
        edititem(item) {
            let data = {
                id: item.id || null
            };
            this.$store
                .dispatch("rolesModule/SELECT_ROLE_ACTION", data)
                .then()
                .catch(err => console.log(err))
                .finally(() => (this.roleStep = 2));
        },
        viewitem(item) {},
        deleteitem(item) {}
    },
    watch: {
        search(val) {
            if (!val) {
                this.search = "";
            } else if (this.search !== "") {
                this.getData();
            }

            this.getData();
        },
        page(val) {
            if (!val) {
                this.search = "";
            } else if (this.search !== "") {
                this.getData();
            }

            this.getData();
        }
    }
};
</script>

<style lang="scss" scoped></style>
