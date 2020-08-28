<template>
  <v-col md="6" lg="6">
    <base-material-card
      icon="mdi-format-list-bulleted-type"
      title="Classes"
      color="indigo darken-3"
      class="px-5 py-3 elevation-4 animated slideInDown"
    >
      <v-card flat>
        <v-card-title class="title font-weight-regular justify-space-between">
          <span>{{ currentTitle }}</span>
          <v-avatar
            color="primary lighten-2"
            class="subheading white--text"
            size="24"
            v-text="classStep"
          ></v-avatar>
        </v-card-title>
        <v-card-text>
          <v-window v-model="classStep">
            <v-window-item :value="1">
              <v-simple-table :dense="dense" :fixed-header="fixedHeader" :height="height">
                <template v-slot:top>
                  <v-text-field label="Search Class" dense></v-text-field>
                </template>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Name</th>
                      <th class="text-left">Calories</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in desserts" :key="item.name">
                      <td>{{ item.name }}</td>
                      <td>{{ item.calories }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <v-row align="baseline" justify="center">
                <v-col cols="12">
                  <template>
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
          </v-window>
        </v-card-text>
      </v-card>
    </base-material-card>
  </v-col>
</template>

<script>
export default {
  data: () => {
    return {
      classStep: 1,
      dense: true,
      fixedHeader: true,
      height: 200,
      desserts: [
        {
          name: "Frozen Yogurt",
          calories: 159,
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
        },
        {
          name: "Eclair",
          calories: 262,
        },
        {
          name: "Cupcake",
          calories: 305,
        },
        {
          name: "Gingerbread",
          calories: 356,
        },
        {
          name: "Jelly bean",
          calories: 375,
        },
        {
          name: "Lollipop",
          calories: 392,
        },
        {
          name: "Honeycomb",
          calories: 408,
        },
        {
          name: "Donut",
          calories: 452,
        },
        {
          name: "KitKat",
          calories: 518,
        },
      ],
      circle: true,
      disabled: false,
      length: 10,
      nextIcon: "navigate_next",
      nextIcons: "mdi-arrow-right",
      prevIcon: "navigate_before",
      prevIcons: "mdi-arrow-left",
      page: 1,
      totalVisible: 5,
    };
  },
  computed: {
    currentTitle() {
      switch (this.classStep) {
        case 1:
          return "Class list";
        case 2:
          return "Class Editor";
        default:
          return "Class";
      }
    },
    noPages() {
      let length = Math.ceil(this.desserts.length / 4);
      return length;
    },
  },
};
</script>
