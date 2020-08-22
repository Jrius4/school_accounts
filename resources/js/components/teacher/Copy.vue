<template>
  <v-app>
    <v-content>
      <v-container>
        <v-window v-model="resultStep">
          <v-row align="baseline" justify="center">
            <v-flex md9>
              <v-card flat>
                <v-card-title class="title font-weight-bold justify-space-between text-center">
                  <span>{{ currentTitle }}</span>
                  <v-avatar
                    color="primary lighten-2"
                    class="subheading white--text"
                    size="24"
                    v-text="resultStep"
                  ></v-avatar>
                </v-card-title>
              </v-card>
            </v-flex>
          </v-row>
          <v-window-item :value="1">
            <v-row align="baseline" justify="center">
              <v-flex lg10 md10>
                <v-data-iterator
                  :items="results"
                  :items-per-page.sync="resultsRowsPerPage.rowsPerPage"
                  :page="resultsPage"
                  :search="search"
                  :sort-by="sortBy.toLowerCase()"
                  :sort-desc="sortDesc"
                  hide-default-footer
                ></v-data-iterator>
              </v-flex>

              <!-- <v-col cols="12">
                <base-material-card
                  icon="mdi-format-list-text"
                  title="Student Results"
                  color="indigo darken-3"
                  class="px-5 py-3 elevation-4"
                >
                  <v-data-table
                    dense
                    :search="search"
                    item-key="id"
                    :headers="headers"
                    :items="results"
                    sort-by="created_at"
                    class="mr-2"
                    :loading="loading"
                    :options.sync="options"
                    :items-per-page="resultsRowsPerPage.rowsPerPage"
                    :server-items-length="totalresults"
                  ></v-data-table>
                </base-material-card>
              </v-col>-->
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
  data: () => {
    return {
      resultStep: 1,
      loading: false,
      pageloading: false,
      search: "",
      options: {},
      sortBy: "student_name",
      sortDesc: false,
      headers: [
        { text: "S/N", align: "left", sortable: true, value: "id" },
        { text: "Index", align: "left", sortable: true, value: "indexno" },
        {
          text: "Name",
          align: "left",
          sortable: true,
          value: "student_name",
        },
        {
          text: "Subject",
          align: "left",
          sortable: true,
          value: "subject_name",
        },
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
    currentTitle() {
      switch (this.resultStep) {
        case 1:
          return "All Students Results List";
        case 2:
          return "Student Results View";
        default:
          return "All Students Results";
      }
    },
  },
  methods: {
    getResults() {
      let search = this.search || "";
      this.loading = true;
      const { sortBy, sortDesc, page, itemsPerPage } = this.options;

      let pageNew = page;

      if (!search) {
        search = "";
        let pagination = {
          search,
          event: this.event || "",
          query: this.query || "",
          page: pageNew,
          sortRowsBy: sortBy[0],
          rowsPerPage: itemsPerPage,
          sortDesc: sortDesc[0],
        };

        this.$store
          .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", pagination)
          .then((res) => {
            //   this.resultFetch(res);
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
            sortRowsBy: sortBy[0],
            rowsPerPage: itemsPerPage,
            sortDesc: sortDesc[0],
          };

          this.$store
            .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", pagination)
            .then((res) => {
              //   this.resultFetch(res);
              this.loading = false;
            });
        } else {
          pageNew = 1;
          let pagination = {
            search,
            event: this.event || "",
            query: this.query || "",
            page: pageNew,
            sortRowsBy: sortBy[0],
            rowsPerPage: itemsPerPage,
            sortDesc: sortDesc[0],
          };

          this.$store
            .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", pagination)
            .then((res) => {
              //   this.resultFetch(res);
              this.loading = false;
            });
        }
      }
    },
  },
  mounted() {
    this.getResults();
  },
  watch: {
    search(val) {
      if (!!this.search) {
        this.getResults();
      }
    },
    options: {
      handler() {
        this.getResults();
      },
      deep: true,
    },
  },
};
</script>

<style lang="scss" scoped></style>
