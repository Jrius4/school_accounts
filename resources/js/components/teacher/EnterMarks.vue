<template>
  <v-app>
    <v-content>
      <v-container>
        <v-row justify="center" align="center">
          <v-col cols="12" md="10">
            <v-card class="animated slideInDown">
              <v-card-title
                class="indigo accent-3 white--text mb-4"
              >{{ getTerm }}{{' '}}/{{' '}}{{ getSet }}</v-card-title>
              <v-card-text>
                <v-form @submit.prevent="sendMarks()">
                  <v-autocomplete
                    outlined
                    dense
                    ref="resultClass"
                    :rules="[
                    ()=> !!resultClass || 'Class is required',
                    resultSubjectCheck
                    ]"
                    id="allClasses"
                    v-model="resultClass"
                    label="Search Class"
                    :loading="clLoading"
                    :items="classes"
                    :search-input.sync="searchClass"
                    :item-text="textClass"
                    autocomplete
                    append-icon="mdi-database-search"
                    :menu-props="{bottom: true,offsetY: true}"
                    hint="Please Search Class"
                    chips
                    attach
                    clearable
                    v-on:change="handleClassSearch()"
                  >
                    <template v-slot:selection="data">
                      <v-chip
                        v-bind="data.attrs"
                        :input-value="data.selected"
                        close
                        @click="data.select"
                        @click:close="
                                                    removeClass(data.item)
                                                "
                      >
                        {{
                        `${data.item.name} / ${data.item.level} `
                        }}
                      </v-chip>
                    </template>

                    <template v-slot:item="{ item }">
                      <v-row align="center" justify="center">
                        <v-col cols="12" sm="6" class="mx-1">
                          <h6
                            v-html="
                                                            `${item.name} / ${item.level}`
                                                        "
                          />
                        </v-col>
                      </v-row>
                    </template>
                  </v-autocomplete>

                  <v-autocomplete
                    outlined
                    dense
                    id="allSubjects"
                    v-model="resultSubject"
                    ref="resultSubject"
                    :rules="[
                    ()=> !!resultSubject || 'Subject is required',
                    resultSubjectCheck
                    ]"
                    label="Search Subject"
                    :loading="subtLoading"
                    :items="subjects"
                    :search-input.sync="searchSubject"
                    :item-text="textSubject"
                    autocomplete
                    append-icon="mdi-database-search"
                    :menu-props="{
                                            bottom: true,
                                            offsetY: true
                                        }"
                    hint="Please Search Subject"
                    chips
                    attach
                    clearable
                    v-on:change="handleSubjectSearch()"
                  >
                    <template v-slot:selection="data">
                      <v-chip
                        v-bind="data.attrs"
                        :input-value="data.selected"
                        close
                        @click="data.select"
                        @click:close="
                                                    removeSubject(data.item)
                                                "
                      >
                        {{
                        `${data.item.name} / ${data.item.level} `
                        }}
                      </v-chip>
                    </template>

                    <template v-slot:item="{ item }">
                      <v-row align="center" justify="center">
                        <v-col cols="12" sm="6" class="mx-1">
                          <h6
                            v-html="
                                                            `${item.name} / ${item.level}`
                                                        "
                          />
                        </v-col>
                      </v-row>
                    </template>
                  </v-autocomplete>

                  <v-autocomplete
                    ref="resultStudent"
                    :rules="[
                    ()=> !!resultStudent || 'Student is required',
                    resultStudentCheck
                    ]"
                    outlined
                    dense
                    id="allStudents"
                    v-model="resultStudent"
                    label="Search Student"
                    :loading="studLoading"
                    :items="students"
                    :search-input.sync="searchStudent"
                    :item-text="textStudent"
                    autocomplete
                    append-icon="mdi-database-search"
                    :menu-props="{
                                            bottom: true,
                                            offsetY: true
                                        }"
                    hint="Please Search Student"
                    chips
                    attach
                    clearable
                    v-on:change="handleStudentSearch()"
                  >
                    <template v-slot:selection="data">
                      <v-chip
                        v-bind="data.attrs"
                        :input-value="data.selected"
                        close
                        @click="data.select"
                        @click:close="
                                                    removeStudent(data.item)
                                                "
                      >
                        {{
                        `${data.item.name} / ${data.item.roll_number} `
                        }}
                      </v-chip>
                    </template>

                    <template v-slot:item="{ item }">
                      <v-row align="center" justify="center">
                        <v-col cols="12" sm="6" class="mx-1">
                          <h6
                            v-html="
                                                            `${item.name} / ${item.roll_number}`
                                                        "
                          />
                        </v-col>
                      </v-row>
                    </template>
                  </v-autocomplete>

                  <v-text-field
                    outlined
                    dense
                    v-model="paperOneFormat"
                    clearable
                    label="Paper One"
                    prepend-icon="mdi-percent-outline"
                  ></v-text-field>
                  <v-text-field
                    outlined
                    dense
                    v-model="paperTwoFormat"
                    clearable
                    label="Paper Two"
                    prepend-icon="mdi-percent-outline"
                    v-if="papercount > 1"
                  ></v-text-field>
                  <v-text-field
                    outlined
                    dense
                    v-model="paperThreeFormat"
                    clearable
                    label="Paper Three"
                    prepend-icon="mdi-percent-outline"
                    v-if="papercount===3"
                  ></v-text-field>
                  <div class="row justify-content-space col-12">
                    <v-btn
                      color="indigo"
                      class="mr-auto"
                      small
                      dark
                      @click="addPaper"
                      :disabled="(papercount ===3)"
                    >
                      <v-icon>mdi-plus</v-icon>Add Paper
                    </v-btn>
                    <v-btn
                      color="orange darken-3"
                      :disabled="(papercount ===1)"
                      class="ml-auto"
                      small
                      dark
                      @click="removePaper"
                    >
                      <v-icon>mdi-minus</v-icon>Remove Paper
                    </v-btn>
                  </div>

                  <div class="row justify-content-content">
                    <div class="col-md-10 mx-auto">
                      <table class="table table-sm green lighten-5 pa-2 elevation-3">
                        <tbody>
                          <tr v-if="classSelection !== null">
                            <th>class</th>
                            <td colspan="2">{{`${classSelection.name} - ${classSelection.level}`}}</td>
                          </tr>
                          <tr v-if="studentSelection !== null">
                            <th>Student</th>
                            <td
                              colspan="2"
                            >{{`${studentSelection.name}/${studentSelection.roll_number}/${studentSelection.combination ?studentSelection.combination.combination_name:''} - ${studentSelection.schclass.name}/${studentSelection.schclass.level}`}}</td>
                          </tr>
                          <tr v-if="subjectSelection !== null">
                            <th>Subject</th>
                            <td colspan="2">{{`${subjectSelection.name}/${subjectSelection.level}`}}</td>
                          </tr>
                          <tr>
                            <th :rowspan="papercount">Paper</th>
                            <td>Paper One</td>
                            <td>{{paperOne}}</td>
                          </tr>
                          <tr v-if="papercount > 1">
                            <td>Paper Two</td>
                            <td>{{paperTwo}}</td>
                          </tr>
                          <tr v-if="papercount === 3">
                            <td>Paper Three</td>
                            <td>{{paperThree}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="row justify-content-space">
                    <v-btn color="green darken-3" class="btn-block" small dark type="submit">
                      <v-icon>mdi-send</v-icon>Add Send Mark
                    </v-btn>
                    <v-btn color="red darken-3" class="btn-block" small dark @click="cancelSubmit">
                      <v-icon>mdi-cancel</v-icon>Cancel Submit
                    </v-btn>
                  </div>
                </v-form>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { mapState } from "vuex";
export default {
  props: ["term", "set"],
  data: () => {
    return {
      setID: "",
      termID: "",
      resultClass: "",
      searchClass: "",
      class: null,
      classSelection: null,
      classSelected: null,
      classSearch: "",
      clLoading: false,
      papercount: 1,
      paperOne: 0,
      paperTwo: 0,
      paperThree: 0,

      resultSubject: "",
      searchSubject: "",
      subject: null,
      subjectSelection: null,
      subjectSelected: null,
      subjectSearch: "",
      subtLoading: false,

      resultStudent: "",
      searchStudent: "",
      student: null,
      studentSelection: null,
      studentSelected: null,
      studentSearch: "",
      studLoading: false,

      errorMessages: "",
      formHasErrors: false,
    };
  },
  computed: {
    ...mapState({
      classes: (state) => state.enterResultsModule.classes,
      subjects: (state) => state.enterResultsModule.subjects,
      students: (state) => state.enterResultsModule.students,
    }),
    paperOneFormat: {
      get: function () {
        return this.paperOne;
      },
      set: function (newValue) {
        if (newValue > 100) {
          this.$toast.info({
            title: "Invalid Input",
            message:
              "Your Input is beyond scope \n use less than or equal t0 100",
            color: "#E65100",
            timeOut: 5000,
            showMethod: "lightSpeedIn",
            hideMethod: "slideOutUp",
          });
        } else if (newValue < 0) {
          this.$toast.info({
            title: "Invalid Input",
            message:
              "Your Input is beyond scope \n use more than or equal t0 0",
            color: "#E65100",
            timeOut: 5000,
            showMethod: "lightSpeedIn",
            hideMethod: "slideOutUp",
          });
        }
        this.paperOne = Number(
          newValue ? newValue.replace(/[^0-9\.]/g, "") : 0
        );
      },
    },
    paperTwoFormat: {
      get: function () {
        return this.paperTwo;
      },
      set: function (newValue) {
        if (newValue > 100) {
          this.$toast.info({
            title: "Invalid Input",
            message:
              "Your Input is beyond scope \n use less than or equal t0 100",
            color: "#E65100",
            timeOut: 5000,
            showMethod: "lightSpeedIn",
            hideMethod: "slideOutUp",
          });
        } else if (newValue < 0) {
          this.$toast.info({
            title: "Invalid Input",
            message:
              "Your Input is beyond scope \n use more than or equal t0 0",
            color: "#E65100",
            timeOut: 5000,
            showMethod: "lightSpeedIn",
            hideMethod: "slideOutUp",
          });
        }
        this.paperTwo = Number(
          newValue ? newValue.replace(/[^0-9\.]/g, "") : 0
        );
      },
    },
    paperThreeFormat: {
      get: function () {
        return this.paperThree;
      },
      set: function (newValue) {
        if (newValue > 100) {
          this.$toast.info({
            title: "Invalid Input",
            message:
              "Your Input is beyond scope \n use less than or equal t0 100",
            color: "#E65100",
            timeOut: 5000,
            showMethod: "lightSpeedIn",
            hideMethod: "slideOutUp",
          });
        } else if (newValue < 0) {
          this.$toast.info({
            title: "Invalid Input",
            message:
              "Your Input is beyond scope \n use more than or equal t0 0",
            color: "#E65100",
            timeOut: 5000,
            showMethod: "lightSpeedIn",
            hideMethod: "slideOutUp",
          });
        }
        this.paperThree = Number(
          newValue ? newValue.replace(/[^0-9\.]/g, "") : 0
        );
      },
    },
    getTerm() {
      let term = "";
      if (this.term === "term-1") {
        term += "Term One";
        this.termID += "1";
      } else if (this.term === "term-2") {
        term += "Term Two";
        this.termID += "2";
      } else if (this.term === "term-3") {
        term += "Term Three";
        this.termID += "3";
      }
      return term;
    },
    getSet() {
      let set = "";
      if (this.set === "b-o-t") {
        set += "Beginning Of Term";
        this.setID += "1";
      } else if (this.set === "m-o-t") {
        set += "Mid Of Term";
        this.setID += "2";
      } else if (this.set === "e-o-t") {
        set += "End Of Term";
        this.setID += "3";
      }
      return set;
    },
    form() {
      return {
        resultSubject: this.resultSubject,
        resultStudent: this.resultStudent,
        resultClass: this.resultClass,
      };
    },
  },
  methods: {
    addPaper() {
      this.$toast.info({
        title: "Paper Added",
        message: "You have added a paper to the subject",
        color: "#00ACC1",
        timeOut: 5000,
        showMethod: "lightSpeedIn",
        hideMethod: "slideOutUp",
      });
      this.papercount += 1;
      if (this.papercount > 3) {
        this.papercount = 3;
      } else if (this.papercount < 1) {
        this.papercount = 1;
      } else if (this.papercount === 1) {
        this.paperThree = 0;
        this.paperTwo = 0;
      } else if (this.papercount === 2) {
        this.paperThree = 0;
      }
    },
    removePaper() {
      this.$toast.info({
        title: "Paper Removed",
        message: "You have removed a paper to the subject",
        color: "#E65100",
        timeOut: 5000,
        showMethod: "lightSpeedIn",
        hideMethod: "slideOutUp",
      });
      this.papercount -= 1;
      if (this.papercount < 1) {
        this.papercount = 1;
      } else if (this.papercount === 1) {
        this.paperThree = 0;
        this.paperTwo = 0;
      } else if (this.papercount === 2) {
        this.paperThree = 0;
      }
    },
    getClasses() {
      const data = {
        keywords: this.searchClass,
      };
      this.clLoading = true;
      this.$store
        .dispatch("enterResultsModule/GET_CLASSES_ACTION", data)
        .finally(() => {
          this.clLoading = false;
        });
    },
    textClass(item) {
      this.classSelected = item;

      return item.name;
    },
    handleClassSearch() {
      this.classSelection = this.classSelected;
      if (!this.resultClass) {
        this.resultClass = "";
        this.classSelection = null;
        this.classSelected = null;
      }
    },
    removeClass() {
      this.classSelection = null;
      this.resultClass = null;
    },

    getSubjects() {
      let data = {
        keywords: this.searchSubject,
        level: this.classSelection ? this.classSelection.level : "",
      };
      this.subtLoading = true;
      this.$store
        .dispatch("enterResultsModule/GET_SUBJECTS_ACTION", data)
        .finally(() => {
          this.subtLoading = false;
        });
    },
    textSubject(item) {
      this.subjectSelected = item;

      return item.name;
    },
    handleSubjectSearch() {
      this.subjectSelection = this.subjectSelected;
      if (!this.resultSubject) {
        this.resultSubject = "";
        this.subjectSelection = null;
        this.subjectSelected = null;
      }
      if (!!this.resultSubject) {
        this.papercount = this.subjectSelection.papers_in.length;
        if (this.papercount < 1) this.papercount = 1;
      }
    },
    removeSubject() {
      this.subjectSelection = null;
      this.resultSubject = null;
    },

    getStudents() {
      let data = {
        keywords: this.searchStudent,
        level: this.classSelection ? this.classSelection.level : "",
        class_id: this.classSelection ? this.classSelection.id : "",
      };
      this.studLoading = true;
      this.$store
        .dispatch("enterResultsModule/GET_STUDENTS_ACTION", data)
        .finally(() => {
          this.studLoading = false;
        });
    },
    textStudent(item) {
      this.studentSelected = item;

      return item.name;
    },
    handleStudentSearch() {
      this.studentSelection = this.studentSelected;
      if (!this.resultStudent) {
        this.resultStudent = "";
        this.studentSelection = null;
        this.studentSelected = null;
      }
    },
    removeStudent() {
      this.studentSelection = null;
      this.resultStudent = null;
    },
    removeSubject() {
      this.subjectSelection = null;
      this.resultSubject = null;
    },
    sendMarks() {
      let papers = new Array();
      for (let index = 1; index <= this.papercount; index++) {
        if (index === 1) {
          papers.push(this.paperOne);
        } else if (index === 2) {
          papers.push(this.paperTwo);
        } else if (index === 3) {
          papers.push(this.paperThree);
        }
      }
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
        this.$toast.info({
          title: "sending Marks",
          message: "Your sending marks",
          color: "#FFC107",
          timeOut: 5000,
          showMethod: "lightSpeedIn",
          hideMethod: "slideOutUp",
        });
        let data = {
          setID: this.setID,
          termID: this.termID,
          papers,
          subject_id: this.subjectSelection.id,
          level: this.subjectSelection.level,
          student_id: this.studentSelection.id,
          class_id: this.classSelection.id,
        };
        this.$store
          .dispatch("enterResultsModule/SEND_MARKS_ACTION", data)
          .then(() => {
            this.$toast.success({
              title: "Save Marks",
              message: "Marks Saved successfully",
              color: "#00C853",
              timeOut: 5000,
              showMethod: "lightSpeedIn",
              hideMethod: "slideOutUp",
            });
            this.cancelSubmit();
          });
      }
    },

    cancelSubmit() {
      this.$toast.info({
        title: "Cleaning Entries",
        message: "Resetting form",
        color: "#6D4C41",
        timeOut: 5000,
        showMethod: "lightSpeedIn",
        hideMethod: "slideOutUp",
      });
      this.class = null;
      this.student = null;
      this.subject = null;
      this.classSelection = null;
      this.studentSelection = null;
      this.subjectSelection = null;
      this.classSelected = null;
      this.studentSelected = null;
      this.subjectSelected = null;
      this.resultClass = null;
      this.resultSubject = null;
      this.resultStudent = null;
      this.paperOne = 0;
      this.paperTwo = 0;
      this.paperThree = 0;
      this.papercount = 1;
      this.errorMessages = [];
      this.formHasErrors = false;

      Object.keys(this.form).forEach((f) => {
        this.$refs[f].reset();
      });
    },

    resultSubjectCheck() {
      this.errorMessages =
        this.resultSubject && !this.resultClass ? "This field is required" : "";

      return true;
    },
    resultStudentCheck() {
      this.errorMessages =
        this.resultStudent && !this.resultSubject && !this.resultClass
          ? "This field is required"
          : "";

      return true;
    },
  },
  mounted() {
    this.getClasses();
  },
  watch: {
    searchClass(val) {
      if (!this.searchClass) {
        this.searchClass = "";
      }
      if (this.searchClass !== "") {
        this.getClasses();
      }
    },
    searchSubject(val) {
      if (!this.searchSubject) {
        this.searchSubject = "";
      }
      if (this.searchSubject !== "") {
        this.getSubjects();
      }
    },
    searchStudent(val) {
      if (!this.searchStudent) {
        this.searchStudent = "";
      }
      if (this.searchStudent !== "") {
        this.getStudents();
      }
    },
    // resultClass() {
    //   this.errorMessages = "";
    // },
    // resultSubject() {
    //   this.errorMessages = "";
    // },
    // resultStudent() {
    //   this.errorMessages = "";
    // },
  },
};
</script>

<style lang="scss" scoped></style>
