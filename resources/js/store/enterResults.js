export default {
    namespaced: true,
    state: {
        students: [],
        subjects: [],
        classes: [],
        papers: []
    },
    mutations: {
        GET_CLASSES(currentState, payload) {
            currentState.classes = payload;
        },
        GET_SUBJECTS(currentState, payload) {
            currentState.subjects = payload;
        },
        GET_STUDENTS(currentState, payload) {
            currentState.students = payload;
        }
    },

    actions: {
        async GET_CLASSES_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const url = "/api/teacher-classes";
                    const q = payload.keywords || "";

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                q
                            }
                        })
                        .then(res => {
                            const classes = res.data;
                            context.commit("GET_CLASSES", classes);
                            resolve(classes);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    err = "No loggedIn";
                    console.log(err);
                    reject({ err });
                }
            });
        },
        async GET_SUBJECTS_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const url = "/api/teacher-subjects";
                    const q = payload.keywords || "";
                    const level = payload.level || "";

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                q,
                                level
                            }
                        })
                        .then(res => {
                            const subjects = res.data;
                            context.commit("GET_SUBJECTS", subjects);
                            resolve(subjects);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    err = "No loggedIn";
                    console.log(err);
                    reject({ err });
                }
            });
        },
        async GET_STUDENTS_ACTION(context, payload) {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    const url = "/api/teacher-students";
                    const q = payload.keywords || "";
                    const level = payload.level || "";
                    const class_id = payload.class_id || "";

                    axios
                        .get(url, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            },
                            params: {
                                q,
                                level,
                                class_id
                            }
                        })
                        .then(res => {
                            const students = res.data;
                            context.commit("GET_STUDENTS", students);
                            resolve(students);
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    err = "No loggedIn";
                    console.log(err);
                    reject({ err });
                }
            });
        },

        async SEND_MARKS_ACTION(context, payload)
        {
            return new Promise((resolve, reject) => {
                if (context.rootGetters.loggedIn) {
                    let url = "/api/teacher-enter-student-results";
                    let papers = payload.papers || "";
                    let subject_id = payload.subject_id || "";
                    let student_id = payload.student_id || "";

                    let formData = new FormData();
                    if (papers !== "")
                    {
                        for (let index = 0; index < papers.length; index++) {
                             formData.append('papers[]', papers[index]);                            
                        }
                    }
                    else {
                        formData.append('papers', papers);
                    }
                    formData.append('student_id', student_id);
                    formData.append('subject_id', subject_id);


                    



                    axios
                        .post(url,formData, {
                            headers: {
                                Authorization:
                                    "Bearer " + context.rootState.token
                            }
                        })
                        .then(res => {
                            const results = res.data;
                            // context.commit("GET_STUDENTS", students);
                            resolve(results);
                            console.log(results)
                        })
                        .catch(err => {
                            console.log(err);
                            reject(err);
                        });
                } else {
                    err = "No loggedIn";
                    console.log(err);
                    reject({ err });
                }
            });
        }
    }
};
