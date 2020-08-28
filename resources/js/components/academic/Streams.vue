<template>
  <v-col md="6" lg="6">
    <base-material-card
      icon="mdi-format-list-bulleted-type"
      title="Streams"
      color="#00796B"
      titleColor="#00796B"
      class="px-5 py-3 elevation-4 teal--text animated slideInDown"
    >
      <v-card flat>
        <v-card-title class="title font-weight-regular justify-space-between">
          <v-icon
            color="#00796B"
            large
            @click="tableView"
            v-if="streamStep !== 1"
          >mdi-table-arrow-left</v-icon>
          <span>
            {{ currentTitle }}{{" "}}
            <v-avatar color="#00838F" class="subheading white--text" size="24" v-text="streamStep"></v-avatar>
          </span>
        </v-card-title>
        <v-card-text>
          <v-window v-model="streamStep">
            <v-window-item :value="1">
              <v-simple-table :dense="dense" :fixed-header="fixedHeader" :height="height">
                <template v-slot:top>
                  <v-row>
                    <v-col cols="12" sm="8" md="8">
                      <v-text-field v-model="search" clearable label="Search Stream" dense></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" md="4">
                      <v-btn large text @click="editItem()" color="#00ACC1">
                        <v-icon>mdi-book-plus-multiple</v-icon>Stream
                      </v-btn>
                    </v-col>
                  </v-row>
                </template>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th class="text-left">Name</th>
                      <th class="text-left">Students</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="stream--heads" v-for="(item,i) in streams" :key="`${i}-stream`">
                      <th>{{i+1}}</th>
                      <td>{{ item.name }}</td>
                      <td>{{ item.students.length }}</td>
                      <td>
                        <v-btn small icon @click="viewItem(item)" color="#2196F3">
                          <v-icon>mdi-eye</v-icon>
                        </v-btn>
                        <v-btn small icon @click="editItem(item)" color="green">
                          <v-icon>mdi-database-edit</v-icon>
                        </v-btn>
                        <v-btn small icon @click="deleteItem(item)" color="#B71C1C">
                          <v-icon>mdi-trash-can</v-icon>
                        </v-btn>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <v-row align="baseline" justify="center">
                <v-col cols="12">
                  <template>
                    <span class="grey--text">Items per page</span>
                    <v-menu offset-y>
                      <template
                        v-slot:activator="{
                                                        on,
                                                        attrs
                                                    }"
                      >
                        <v-btn dark text color="primary" class="ml-2" v-bind="attrs" v-on="on">
                          {{ per_page }}
                          <v-icon>mdi-chevron-down</v-icon>
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item
                          v-for="(number, index) in itemsPerPageArray"
                          :key="index"
                          @click="
                                                            updateItemsPerPage(
                                                                number
                                                            )
                                                        "
                        >
                          <v-list-item-title>
                            {{
                            number
                            }}
                          </v-list-item-title>
                        </v-list-item>
                      </v-list>
                    </v-menu>

                    <v-spacer></v-spacer>
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
                  </template>
                </v-col>
              </v-row>
            </v-window-item>
            <v-window-item :value="2">
              <v-card-title
                :style="`color:#FAFAFA;background-color:${editorTitleColor};border-radius: 104px 78px 52px 26px/26px 52px 78px 104px;`"
              >
                <h4 class="text-center">{{editorTitle}}</h4>
              </v-card-title>
              <v-card-text>
                <v-form>
                  <v-text-field label="Name" v-model="streamName"></v-text-field>
                  <v-row align="baseline" justify="center">
                    <v-col cols="10">
                      <v-btn-toggle v-model="editorBtn" dark>
                        <v-btn small dark @click="saveItem()" :color="editorTitleColor">
                          <v-icon>mdi-content-save</v-icon>
                          {{editorTitle}}
                        </v-btn>
                        <v-btn small dark @click="cancelForm()" :color="'#E53935'">
                          <v-icon>mdi-close-circle</v-icon>Cancel
                        </v-btn>
                      </v-btn-toggle>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
            </v-window-item>
            <v-window-item :value="3">
              <h4>View</h4>
            </v-window-item>
          </v-window>
        </v-card-text>
      </v-card>
    </base-material-card>
  </v-col>
</template>

<script>
import { mapState } from "vuex";
export default {
  data: () => {
    return {
      streamStep: 1,
      search: "",
      dense: true,
      fixedHeader: true,
      height: 200,
      actionBtn: "",
      editorBtn: "",
      itemsPerPageArray: [4, 8, 12, 24, "All"],
      circle: true,
      disabled: false,
      length: 10,
      nextIcon: "navigate_next",
      nextIcons: "mdi-arrow-right",
      prevIcon: "navigate_before",
      prevIcons: "mdi-arrow-left",
      page: 1,
      totalVisible: 5,
      editorTitleColor: "",
      selectedItem: null,
      streamName: null,
      per_page: 4,
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let pagination = {
        val: `${this.search}`.toLowerCase(),
        page: this.page,
        rowsPerPage: this.per_page || 15,
      };
      this.$store.dispatch("classesModule/GET_STREAMS_ACTION", pagination);
    },
    updateItemsPerPage(number) {
      this.per_page = number;
    },
    tableView() {
      this.selectedItem = null;
      this.streamStep = 1;
    },
    editItem(item) {
      if (!!item) {
        this.selectedItem = item;
      }
      this.streamName =
        this.selectedItem !== null ? this.selectedItem.name : null;
      this.streamStep = 2;
    },
    viewItem(item) {
      this.streamStep = 3;
    },
    deleteItem(item) {},
    saveItem() {},
    cancelForm() {
      this.streamStep = 1;
      this.selectedItem = null;
      this.streamName = null;
    },
  },
  computed: {
    ...mapState({
      streams: (state) => state.classesModule.streams,
      //   page: (state) => state.classesModule.accountPagination.page,
      rowsPerPage: (state) => state.classesModule.streamPagination.rowsPerPage,
      totalstreams: (state) => state.classesModule.totalstreams,
      streamSortRowsBy: (state) => state.classesModule.streamSortRowsBy,
    }),
    currentTitle() {
      switch (this.streamStep) {
        case 1:
          return "Streams list";
        case 2:
          return "Streams Editor";
        case 3:
          return "Stream View";
        default:
          return "Streams";
      }
    },
    noPages() {
      let length = Math.ceil(this.totalstreams / this.rowsPerPage);
      return length;
    },
    editorTitle() {
      if (this.selectedItem === null) {
        this.editorTitleColor = "#03A9F4";
        return "Create New Stream";
      } else {
        this.editorTitleColor = "#43A047";
        return "Update Stream";
      }
    },
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
    },
    per_page(val) {
      if (!val) {
        this.search = "";
      } else if (this.search !== "") {
        this.getData();
      }

      this.getData();
    },
  },
};
</script>
<style lang="scss" scoped>
.stream--heads > th {
  font-weight: normal;
  background-color: #039be5;
  color: #e8eaf6;
}
</style>
