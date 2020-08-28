<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-row align="baseline" justify="center">
          <Streams />
          <Classes />
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import Classes from "./Classes";
import Streams from "./Streams";
export default {
  components: { Classes, Streams },
};
</script>
