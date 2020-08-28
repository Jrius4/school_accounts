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
                      <template
                        v-if="
                                                    $vuetify.breakpoint.mdAndUp
                                                "
                      >
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
                    <v-row class>
                      <v-col
                        v-for="(item, n) in props.items"
                        :key="`${n}-result`"
                        cols="12"
                        sm="8"
                        md="6"
                        lg="6"
                      >
                        <v-card shaped raised class="mt-6">
                          <v-card-title
                            :style="
                                    `background:${
                                        [
                                            '#0097A7',
                                            '#00796B',
                                            '#43A047',
                                            '#FF6F00',
                                            '#D84315',
                                            '#546E7A'
                                        ][n % 6]
                                    };color:#FAFAFA`
                                "
                            class="subheading font-weight-bold"
                          >
                            <v-avatar
                              size="100"
                              class="mx-auto v-card--material__avatar elevation-6"
                              color="grey"
                            >
                              <v-img :src="`/images/${item.student.image}`" />
                            </v-avatar>
                            <v-row flat>
                              <v-col>
                                <h3>
                                  {{
                                  item.student.name
                                  }}
                                </h3>
                              </v-col>
                            </v-row>
                          </v-card-title>
                          <v-card-text>
                            <h4>{{ item.indexno }}</h4>
                            <div>
                              <table class="student--results" v-if="item.indexno[0] === 'A'">
                                <caption>
                                  Grade:
                                  <b>{{resultsCaption(item.subjects).letters}}</b>,
                                  Points:
                                  <b>
                                    {{resultsCaption(item.subjects).points}}
                                    <sub>pts</sub>,
                                  </b>
                                </caption>
                                <thead>
                                  <tr>
                                    <th rowspan="2">Subject</th>
                                    <th rowspan="2">Paper</th>
                                    <th colspan="3">Sets</th>
                                    <th rowspan="2">Total&nbsp;in Term</th>
                                    <th rowspan="2">Paper Grades&nbsp;in Term</th>
                                    <th rowspan="2">Grade</th>
                                  </tr>
                                  <tr>
                                    <th>
                                      BoT
                                      <sup>15%</sup>
                                    </th>
                                    <th>
                                      MoT
                                      <sup>20%</sup>
                                    </th>
                                    <th>
                                      EoT
                                      <sup>75%</sup>
                                    </th>
                                  </tr>
                                </thead>
                                <template v-for="(subject,subj) in item.subjects">
                                  <tbody
                                    :key="`${subj}-subject--3`"
                                    v-show="paperExtract(subject).count == 3"
                                  >
                                    <tr>
                                      <td
                                        rowspan="3"
                                        :style="`background-color:${['#2196F3','#42A5F5','#03A9F4'][0]};color:${['#FAFAFA'][0]};font-weight:bolder`"
                                      >{{subject.subject.subject_code}}</td>
                                      <td>1</td>
                                      <td>{{paperExtract(subject).b_o_t !== null?(paperExtract(subject).b_o_t.computed[0] ? paperExtract(subject).b_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).m_o_t !== null?(paperExtract(subject).m_o_t.computed[0] ? paperExtract(subject).m_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).e_o_t !== null?(paperExtract(subject).e_o_t.computed[0] ? paperExtract(subject).e_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).total !== null ?(paperExtract(subject).total[0]?paperExtract(subject).total[0].toFixed(2):""):""}}</td>
                                      <td>{{paperExtract(subject).papers !== null ?(paperExtract(subject).papers[0]?paperExtract(subject).papers[0]:""):""}}</td>
                                      <td rowspan="3">{{paperExtract(subject).grade}}</td>
                                    </tr>
                                    <tr>
                                      <td>2</td>
                                      <td>{{paperExtract(subject).b_o_t !== null?(paperExtract(subject).b_o_t.computed[1] ? paperExtract(subject).b_o_t.computed[1].score:""):""}}</td>
                                      <td>{{paperExtract(subject).m_o_t !== null?(paperExtract(subject).m_o_t.computed[1] ? paperExtract(subject).m_o_t.computed[1].score:""):""}}</td>
                                      <td>{{paperExtract(subject).e_o_t !== null?(paperExtract(subject).e_o_t.computed[1] ? paperExtract(subject).e_o_t.computed[1].score:""):""}}</td>
                                      <td>{{paperExtract(subject).total !== null ?(paperExtract(subject).total[1]?paperExtract(subject).total[1].toFixed(2):""):""}}</td>
                                      <td>{{paperExtract(subject).papers !== null ?(paperExtract(subject).papers[1]?paperExtract(subject).papers[1]:""):""}}</td>
                                    </tr>
                                    <tr>
                                      <td>3</td>
                                      <td>{{paperExtract(subject).b_o_t !== null?(paperExtract(subject).b_o_t.computed[2] ? paperExtract(subject).b_o_t.computed[2].score:""):""}}</td>
                                      <td>{{paperExtract(subject).m_o_t !== null?(paperExtract(subject).m_o_t.computed[2] ? paperExtract(subject).m_o_t.computed[2].score:""):""}}</td>
                                      <td>{{paperExtract(subject).e_o_t !== null?(paperExtract(subject).e_o_t.computed[2] ? paperExtract(subject).e_o_t.computed[2].score:""):""}}</td>
                                      <td>{{paperExtract(subject).total !== null ?(paperExtract(subject).total[2]?paperExtract(subject).total[2].toFixed(2):""):""}}</td>
                                      <td>{{paperExtract(subject).papers !== null ?(paperExtract(subject).papers[2]?paperExtract(subject).papers[2]:""):""}}</td>
                                    </tr>
                                  </tbody>
                                  <tbody
                                    :key="`${subj}-subject--2`"
                                    v-show="paperExtract(subject).count == 2"
                                  >
                                    <tr>
                                      <td
                                        rowspan="2"
                                        :style="`background-color:${['#2196F3','#42A5F5','#03A9F4'][1]};color:${['#FAFAFA'][0]};font-weight:bolder`"
                                      >{{subject.subject.subject_code}}</td>
                                      <td>1</td>
                                      <td>{{paperExtract(subject).b_o_t !== null?(paperExtract(subject).b_o_t.computed[0] ? paperExtract(subject).b_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).m_o_t !== null?(paperExtract(subject).m_o_t.computed[0] ? paperExtract(subject).m_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).e_o_t !== null?(paperExtract(subject).e_o_t.computed[0] ? paperExtract(subject).e_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).total !== null ?(paperExtract(subject).total[0]?paperExtract(subject).total[0].toFixed(2):""):""}}</td>
                                      <td>{{paperExtract(subject).papers !== null ?(paperExtract(subject).papers[0]?paperExtract(subject).papers[0]:""):""}}</td>
                                      <td rowspan="2">{{paperExtract(subject).grade}}</td>
                                    </tr>
                                    <tr>
                                      <td>2</td>
                                      <td>{{paperExtract(subject).b_o_t !== null?(paperExtract(subject).b_o_t.computed[1] ? paperExtract(subject).b_o_t.computed[1].score:""):""}}</td>
                                      <td>{{paperExtract(subject).m_o_t !== null?(paperExtract(subject).m_o_t.computed[1] ? paperExtract(subject).m_o_t.computed[1].score:""):""}}</td>
                                      <td>{{paperExtract(subject).e_o_t !== null?(paperExtract(subject).e_o_t.computed[1] ? paperExtract(subject).e_o_t.computed[1].score:""):""}}</td>
                                      <td>{{paperExtract(subject).total !== null ?(paperExtract(subject).total[1]?paperExtract(subject).total[1].toFixed(2):""):""}}</td>
                                      <td>{{paperExtract(subject).papers !== null ?(paperExtract(subject).papers[1]?paperExtract(subject).papers[1]:""):""}}</td>
                                    </tr>
                                  </tbody>
                                  <tbody
                                    :key="`${subj}-subject--1`"
                                    v-show="paperExtract(subject).count == 1"
                                  >
                                    <tr>
                                      <td
                                        colspan="2"
                                        :style="`background-color:${['#2196F3','#42A5F5','#03A9F4'][2]};color:${['#FAFAFA'][0]};font-weight:bolder`"
                                      >{{subject.subject.subject_code}}</td>

                                      <td>{{paperExtract(subject).b_o_t !== null?(paperExtract(subject).b_o_t.computed[0] ? paperExtract(subject).b_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).m_o_t !== null?(paperExtract(subject).m_o_t.computed[0] ? paperExtract(subject).m_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).e_o_t !== null?(paperExtract(subject).e_o_t.computed[0] ? paperExtract(subject).e_o_t.computed[0].score:""):""}}</td>
                                      <td>{{paperExtract(subject).total !== null ?(paperExtract(subject).total[0]?paperExtract(subject).total[0].toFixed(2):""):""}}</td>
                                      <td colspan="2">{{paperExtract(subject).grade}}</td>
                                    </tr>
                                  </tbody>
                                </template>
                              </table>
                              <table class="student--results" v-if="item.indexno[0] === 'O'">
                                <caption>
                                  Total:
                                  <b>11</b>,
                                  Agg:
                                  <b>11</b>
                                </caption>
                                <thead>
                                  <tr>
                                    <th rowspan="2">Subject</th>
                                    <th colspan="3">Sets</th>
                                    <th rowspan="2">Total&nbsp;in Term</th>
                                    <th rowspan="2">Grade</th>
                                  </tr>
                                  <tr>
                                    <th>
                                      BoT
                                      <sup>15%</sup>
                                    </th>
                                    <th>
                                      MoT
                                      <sup>20%</sup>
                                    </th>
                                    <th>
                                      EoT
                                      <sup>75%</sup>
                                    </th>
                                  </tr>
                                </thead>
                                <template v-for="(subject,subj) in item.subjects">
                                  <tbody :key="`${subj}-subject--0`">
                                    <tr>
                                      <td
                                        :style="`background-color:${['#2196F3','#42A5F5','#03A9F4'][subj %3]};color:${['#FAFAFA'][0]};font-weight:bolder`"
                                      >{{subject.subject.subject_code}}</td>
                                      <td>{{extractItems(subject).b_o_t !== null?(extractItems(subject).b_o_t.computed[0] ? extractItems(subject).b_o_t.computed[0].score:""):""}}</td>
                                      <td>{{extractItems(subject).m_o_t !== null?(extractItems(subject).m_o_t.computed[0] ? extractItems(subject).m_o_t.computed[0].score:""):""}}</td>
                                      <td>{{extractItems(subject).e_o_t !== null?(extractItems(subject).e_o_t.computed[0] ? extractItems(subject).e_o_t.computed[0].score:""):""}}</td>
                                      <td>{{extractItems(subject).total || ""}}</td>
                                      <td>{{extractItems(subject).grade || ""}}</td>
                                    </tr>
                                  </tbody>
                                </template>
                              </table>
                            </div>
                          </v-card-text>
                        </v-card>
                      </v-col>
                    </v-row>
                  </template>

                  <template v-slot:footer>
                    <v-row class="mt-2" align="center" justify="center">
                      <span class="grey--text">Items per page</span>
                      <v-menu offset-y>
                        <template
                          v-slot:activator="{
                                                        on,
                                                        attrs
                                                    }"
                        >
                          <v-btn dark text color="primary" class="ml-2" v-bind="attrs" v-on="on">
                            {{ itemsPerPage }}
                            <v-icon>mdi-chevron-down</v-icon>
                          </v-btn>
                        </template>
                        <v-list>
                          <v-list-item
                            v-for="(number,
                                                        index) in itemsPerPageArray"
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

                      <span class="mr-4 grey--text">
                        Page {{ page }} of
                        {{ numberOfPages }}
                      </span>
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
      let results = this.results;
      //   grouped = _.groupBy(results, "indexno");
      let children = Object.entries(results).map((result, index) => ({
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
      let grade = JSON.parse(exam.grade) || null;
      let papers = JSON.parse(exam.papers) || null;
      let points = JSON.parse(exam.point) || 0;
      let total = JSON.parse(exam.total) || null;
      let b_o_t = JSON.parse(exam.b_o_t) || null;
      let m_o_t = JSON.parse(exam.m_o_t) || null;
      let e_o_t = JSON.parse(exam.e_o_t) || null;
      let count = Math.max(...[total.length, papers.length]);
      let results = {
        count,
        b_o_t,
        m_o_t,
        e_o_t,
        total,
        grade,
        papers,
        points,
      };

      return results;
    },
    extractItems(exam) {
      let b_o_t = JSON.parse(exam.b_o_t) || null;
      let m_o_t = JSON.parse(exam.m_o_t) || null;
      let e_o_t = JSON.parse(exam.e_o_t) || null;
      let total = JSON.parse(exam.total) || null;
      let point = JSON.parse(exam.point) || null;
      let grade = exam.grade || null;

      let results = {
        b_o_t,
        m_o_t,
        e_o_t,
        total,
        point,
        grade,
      };

      return results;
    },
    resultsCaption(subjects) {
      let letters = "";
      let points = 0;
      for (let index = 0; index < subjects.length; index++) {
        //   const element = array[index];
        const grade = JSON.parse(subjects[index].grade) || "_";
        const point = JSON.parse(subjects[index].point) || 0;
        points += point;
        if (subjects[index].subject_name.includes("General Paper"))
          grade = grade.substring(1);
        letters += grade;
      }

      return { letters, points };
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
<style lang="scss" scoped>
.student--results {
  border: solid thin;
  border-collapse: collapse;
}
.student--results caption {
  padding-bottom: 0.28rem;
}
.student--results th,
.student--results td {
  border: solid thin;
  padding: 0.28rem 0.48rem;
}
.student--results td {
  white-space: nowrap;
}
.student--results th {
  font-weight: normal;
  background-color: #303f9f;
  color: #e8eaf6;
}
.student--results td {
  border-style: thin solid;
  vertical-align: top;
}
.student--results th {
  padding: 0.5em;
  vertical-align: middle;
  text-align: center;
}

.student--results tbody td:first-child::after {
  content: leader(". ");
}
</style>
