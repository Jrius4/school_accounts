<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-window v-model="resultStep">
          <v-window-item :value="1">
            <v-row>
              <v-col cols="12">
                <v-data-iterator
                  :items="items"
                  :items-per-page.sync="itemsPerPage"
                  :page="page"
                  :search="search"
                  :sort-by="sortBy.toLowerCase()"
                  :sort-desc="sortDesc"
                  hide-default-footer
                >
                  <template v-slot:header>
                    <v-toolbar dark color="blue darken-3" class="mb-1">
                      <v-text-field
                        v-model="search"
                        clearable
                        flat
                        solo-inverted
                        hide-details
                        prepend-inner-icon="mdi-database-search"
                        label="Search"
                      ></v-text-field>
                      <template v-if="$vuetify.breakpoint.mdAndUp">
                        <v-spacer></v-spacer>
                        <v-select
                          v-model="sortBy"
                          flat
                          solo-inverted
                          hide-details
                          :items="keys"
                          :item-text="textName"
                          :item-value="textValue"
                          prepend-inner-icon="mdi-sort-alphabetical-ascending"
                          label="Sort by"
                        ></v-select>
                        <v-spacer></v-spacer>
                        <v-btn-toggle v-model="sortDesc" mandatory>
                          <v-btn large depressed color="blue" :value="false">
                            <v-icon>mdi-arrow-up</v-icon>
                          </v-btn>
                          <v-btn large depressed color="blue" :value="true">
                            <v-icon>mdi-arrow-down</v-icon>
                          </v-btn>
                        </v-btn-toggle>
                      </template>
                    </v-toolbar>
                  </template>

                  <template v-slot:default="props">
                    <v-row>
                      <v-col
                        v-for="(item,n) in props.items"
                        :key="`${n}-result`"
                        cols="12"
                        sm="8"
                        md="6"
                        lg="6"
                      >
                        <v-card shaped raised>
                          <v-card-title
                            :style="`background:${['#0097A7','#00796B','#43A047','#FF6F00','#D84315','#546E7A'][n%6]};color:#FAFAFA`"
                            class="subheading font-weight-bold"
                          >{{ item.student.name }}</v-card-title>
                          <v-card-text>
                            <!-- <v-list dense>
                              <v-list-item v-for="(key, index) in filteredKeys" :key="index">
                                <v-list-item-content
                                  :class="{ 'blue--text': sortBy === key.value }"
                                >{{ key.name }}:</v-list-item-content>
                                <v-list-item-content
                                  class="align-end"
                                  :class="{ 'blue--text': sortBy === key.value }"
                                >{{ item[key.value.toLowerCase()] }}</v-list-item-content>
                              </v-list-item>
                            </v-list>-->
                            <h4>{{item.indexno}}</h4>
                            <v-simple-table dense>
                              <template v-slot:default>
                                <thead>
                                  <tr>
                                    <th class="text-left">Subject</th>
                                    <th class="text-left">Papers</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(exam,ind) in item.subjects" :key="`${ind}-index`">
                                    <td
                                      :colspan="JSON.parse(exam).papers.length"
                                    >{{ exam.subject.subject_code }}</td>
                                    <td>{{ exam.student_name }}</td>
                                  </tr>
                                </tbody>
                              </template>
                            </v-simple-table>
                          </v-card-text>
                        </v-card>
                      </v-col>
                    </v-row>
                  </template>

                  <template v-slot:footer>
                    <v-row class="mt-2" align="center" justify="center">
                      <span class="grey--text">Items per page</span>
                      <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn dark text color="primary" class="ml-2" v-bind="attrs" v-on="on">
                            {{ itemsPerPage }}
                            <v-icon>mdi-chevron-down</v-icon>
                          </v-btn>
                        </template>
                        <v-list>
                          <v-list-item
                            v-for="(number, index) in itemsPerPageArray"
                            :key="index"
                            @click="updateItemsPerPage(number)"
                          >
                            <v-list-item-title>{{ number }}</v-list-item-title>
                          </v-list-item>
                        </v-list>
                      </v-menu>

                      <v-spacer></v-spacer>

                      <span class="mr-4 grey--text">Page {{ page }} of {{ numberOfPages }}</span>
                      <v-btn fab dark color="blue darken-3" class="mr-1" @click="formerPage">
                        <v-icon>mdi-chevron-left</v-icon>
                      </v-btn>
                      <v-btn fab dark color="blue darken-3" class="ml-1" @click="nextPage">
                        <v-icon>mdi-chevron-right</v-icon>
                      </v-btn>
                    </v-row>
                  </template>
                </v-data-iterator>
              </v-col>
            </v-row>
          </v-window-item>
        </v-window>
      </v-container>
    </v-content>
  </v-app>
</template>


<script>
import { mapState } from "vuex";
export default {
  props: ["event", "query"],
  data() {
    return {
      resultStep: 1,
      itemsPerPageArray: [4, 8, 12, 24, "All"],
      search: "",
      filter: {},
      sortDesc: false,
      page: 1,
      itemsPerPage: 4,
      sortBy: "indexno",
      keys: [
        { name: "index number", value: "indexno" },
        { name: "student name", value: "student_name" },
        { name: "subjects", value: "subjects" },
      ],
    };
  },
  computed: {
    ...mapState({
      results: (state) => state.teacherModule.results,
      totalresults: (state) => state.teacherModule.totalresults,
      resultsPage: (state) => state.teacherModule.resultPagination.page,
      resultsRowsPerPage: (state) =>
        state.teacherModule.resultPagination.rowsPerPage,
    }),
    items() {
      let results = this.results,
        grouped = _.groupBy(results, "indexno");
      let children = Object.entries(grouped).map((result, index) => ({
        id: this.$root.uuid.createUUID(),
        indexno: result[0],
        student: result[1][0].student,
        student_name: result[1][0].student_name,
        subjects: result[1],
      }));
      return children;
    },
    numberOfPages() {
      return Math.ceil(this.items.length / this.itemsPerPage);
    },
    filteredKeys() {
      return this.keys.filter(
        (key) => key.value !== `student_name` || key.value !== `indexno`
      );
    },
  },
  methods: {
    paperExtract(exam) {
      let papers = JSON.parse(exam.b_o_t || "{}");
      console.log({ papers });
      return 4;
    },
    textName(val) {
      return val.name;
    },
    textValue(val) {
      return val.value;
    },
    getResults() {
      let search = this.search;
      this.loading = true;
      let pageNew = this.page;
      let itemsPerPage = this.itemsPerPage;
      let sortBy = this.sortBy;
      let sortDesc = this.sortDesc;
      if (!search) {
        search = "";
        let pagination = {
          search,
          event: this.event || "",
          query: this.query || "",
          page: pageNew,
          sortBy: sortBy,
          rowsPerPage: itemsPerPage,
          sortDesc: sortDesc,
        };

        this.$store
          .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", pagination)
          .then((res) => {
            this.loading = false;
          });
      } else if (search.length > 0) {
        if (pageNew > 1) {
          pageNew = this.payments.length === 0 ? 1 : pageNew;
          this.loadingPay = true;
          let pagination = {
            search,
            event: this.event || "",
            query: this.query || "",
            page: pageNew,
            sortBy: sortBy,
            rowsPerPage: itemsPerPage,
            sortDesc: sortDesc,
          };

          this.$store
            .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", pagination)
            .then((res) => {
              this.loading = false;
            });
        } else {
          pageNew = 1;
          let pagination = {
            search,
            event: this.event || "",
            query: this.query || "",
            page: pageNew,
            sortBy: sortBy,
            rowsPerPage: itemsPerPage,
            sortDesc: sortDesc,
          };

          this.$store
            .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", pagination)
            .then((res) => {
              this.loading = false;
            });
        }
      }
    },
    nextPage() {
      if (this.page + 1 <= this.numberOfPages) this.page += 1;
    },
    formerPage() {
      if (this.page - 1 >= 1) this.page -= 1;
    },
    updateItemsPerPage(number) {
      this.itemsPerPage = number;
    },
  },
  mounted() {
    this.getResults();
  },
};
</script>
