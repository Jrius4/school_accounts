<template>
  <v-container fluid>
    <v-window v-model="stepTeacher">
      <v-row align="baseline" justify="center">
        <v-flex md9>
          <h5
            class="title font-weight-bold justify-space-between text-center"
          >{{`${user?user.first_name || '':""} ${user?user.last_name || '':""}`.toUpperCase()}}</h5>
        </v-flex>
      </v-row>
      <v-window-item :value="1">
        <v-row>
          <v-col cols="12">
            <v-row align="baseline" justify="center" class="grey lighten-5">
              <h4 class="col-12">Your Classes</h4>
              <v-card
                v-for="(cl, n) in classes"
                :key="`${n}-cla`"
                class="ma-3 pa-6"
                shaped
                dark
                raised
                :color="['#0097A7','#00796B','#43A047','#FF6F00','#D84315','#546E7A'][n%6]"
              >
                <v-card-subtitle>{{ cl.name }}</v-card-subtitle>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <a :href="`/class-results?event=${'class'}&query=${cl.slug}`">
                        <v-icon icon v-bind="attrs" v-on="on">mdi-clipboard-list</v-icon>
                      </a>
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
                v-for="(subj, n) in filterSubjects"
                :key="`${n}-subj`"
                class="ma-3 pa-6"
                shaped
                tile
                dark
                :color="['#607D8B','#5D4037','#00796B','#1565C0'][n%4]"
              >
                <v-card-subtitle>
                  {{ subj.name }} {{ "/" }}
                  {{ subj.level }}
                </v-card-subtitle>
                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <a :href="`/class-results?event=${'subject'}&query=${subj.slug}`">
                        <v-icon icon v-bind="attrs" v-on="on">mdi-clipboard-list</v-icon>
                      </a>
                    </template>
                    <span>View Student Results</span>
                  </v-tooltip>
                </v-card-actions>
              </v-card>
            </v-row>
          </v-col>
        </v-row>
      </v-window-item>
      <v-window-item :value="2"></v-window-item>
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
    }),
    filterSubjects() {
      return this.subject
        ? this.subjects.filter((o) =>
            `${o.name}`.toLowerCase().includes(`${this.subject}`.toLowerCase())
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

<style lang="scss" scoped></style>
