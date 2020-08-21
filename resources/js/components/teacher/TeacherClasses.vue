<template>
  <v-container fluid>
    <v-window v-model="stepTeacher">
      <v-row align="baseline" justify="center">
        <v-flex md9>
          <h5>jsdkadjsa</h5>
        </v-flex>
      </v-row>
      <v-window-item :value="1">
        <v-row>
          <v-col cols="12">
            <v-row align="baseline" justify="center" class="grey lighten-5">
              <h4 class="col-12">Your Classes</h4>
              <v-card v-for="(cl,n) in classes" :key="`${n}-cla`" class="ma-3 pa-6" shaped raised>
                <v-card-subtitle>{{cl.name}}</v-card-subtitle>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        icon
                        small
                        v-bind="attrs"
                        v-on="on"
                        @click="viewResults({event:'class',item:cl})"
                      >
                        <v-icon>mdi-clipboard-list</v-icon>
                      </v-btn>
                    </template>
                    <span>View Student Results</span>
                  </v-tooltip>
                </v-card-actions>
              </v-card>
            </v-row>
          </v-col>
          <v-col cols="12">
            <v-row align="baseline" justify="center" class="grey lighten-5">
              <v-col cols="12">
                <h4 class="col">Your Subjects</h4>
                <v-spacer></v-spacer>
                <v-text-field label="search subject" v-model="subject"></v-text-field>
              </v-col>

              <v-card
                v-for="(subj,n) in filterSubjects"
                :key="`${n}-subj`"
                class="ma-3 pa-6"
                shaped
                tile
              >
                <v-card-subtitle>{{subj.name}} {{"/"}} {{subj.level}}</v-card-subtitle>
                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        icon
                        small
                        v-bind="attrs"
                        v-on="on"
                        @click="viewResults({event:'subject',item:subj})"
                      >
                        <v-icon>mdi-clipboard-list</v-icon>
                      </v-btn>
                    </template>
                    <span>View Student Results</span>
                  </v-tooltip>
                </v-card-actions>
              </v-card>
            </v-row>
          </v-col>
        </v-row>
      </v-window-item>
      <v-window-item :value="2">
        <v-window v-model="resultStep">
          <v-row align="baseline" justify="center">
            <v-flex md9>
              <h4>Students Results</h4>
              <v-btn icon small @click="stepTeacher = 1">
                <v-icon>mdi-keyboard-backspace</v-icon>
              </v-btn>
            </v-flex>
          </v-row>
          <v-window-item :value="1">
            <v-row align="baseline" justify="center">
              <v-col cols="12">
                <base-material-card
                  icon="mdi-finance"
                  title="Student Results"
                  color="indigo darken-3"
                  class="px-5 py-3 elevation-4"
                >
                  <v-data-table></v-data-table>
                </base-material-card>
              </v-col>
            </v-row>
          </v-window-item>
        </v-window>
      </v-window-item>
    </v-window>
  </v-container>
</template>

<script>
import { mapState, mapMutations } from "vuex";
export default {
  name: "TeacherClass",
  data: () => {
    return {
      subject: "",
      stepTeacher: 1,
      resultStep: 1,
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.user,
      classes: (state) => state.teacherModule.classes,
      subjects: (state) => state.teacherModule.subjects,
      results: (state) => state.teacherModule.results,
      totalresults: (state) => state.teacherModule.totalresults,
      resultsPage: (state) => state.teacherModule.resultPagination.page,
      resultsRowsPerPage: (state) =>
        state.teacherModule.resultPagination.rowsPerPage,
    }),
    filterSubjects() {
      return this.subject
        ? this.subjects.filter((o) =>
            `${o.name}`.toLowerCase().includes(this.subject)
          )
        : this.subjects;
    },
  },
  methods: {
    ...mapMutations({
      resultFetch: "teacherModule/FETCH_RESULTS",
    }),
    viewResults(item) {
      let data = {
        event: item.event,
        item_id: item.item.id,
      };

      this.$store
        .dispatch("teacherModule/FETCH_RESULTS_ACTIONS", data)
        .then((res) => {
          this.resultFetch(res);
        });
      this.stepTeacher = 2;
      console.log("results", data);
    },
    getTeacher() {
      let data = {
        user_id: this.user !== null ? this.user.id : 0,
      };
      this.$store.dispatch("teacherModule/GET_CLASSES_ACTIONS", data);
    },
  },
  mounted() {
    this.getTeacher();
  },
  watch: {
    user(val) {
      this.getTeacher();
    },
    subject() {},
  },
  filters: {},
};
</script>

<style lang="scss" scoped>
</style>
