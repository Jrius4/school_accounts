<template>
  <v-app>
    <v-content class="teal lighten-2">
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-card class="primary darken-2 col-md-10 mx-auto">
              <v-card-text>
                <v-toolbar dense>
                  <v-toolbar-title>Enter Term Results</v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn small color="primary" dark v-bind="attrs" v-on="on">I</v-btn>
                    </template>
                    <v-list>
                      <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        @click="'javascript:void(0)'"
                      >
                        <v-list-item-title>
                          <a
                            class="nav-link"
                            :href="`/enter-results/term-1/${item.link}/term-sets`"
                          >{{ item.title }}</a>
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                  <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn small color="primary" dark v-bind="attrs" v-on="on">II</v-btn>
                    </template>
                    <v-list>
                      <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        @click="'javascript:void(0)'"
                      >
                        <v-list-item-title>
                          <a
                            class="nav-link"
                            :href="`/enter-results/term-2/${item.link}/term-sets`"
                          >{{ item.title }}</a>
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                  <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn small color="primary" dark v-bind="attrs" v-on="on">III</v-btn>
                    </template>
                    <v-list>
                      <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        @click="'javascript:void(0)'"
                      >
                        <v-list-item-title>
                          <a
                            class="nav-link"
                            :href="`/enter-results/term-3/${item.link}/term-sets`"
                          >{{ item.title }}</a>
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </v-toolbar>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
export default {
  data() {
    return {
      items: [
        { title: "B.O.T", link: "b-o-t" },
        { title: "M.O.T", link: "m-o-t" },
        { title: "E.O.T", link: "e-o-t" },
      ],
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
