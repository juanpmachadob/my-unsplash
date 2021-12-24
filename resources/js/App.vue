<template>
  <v-app app>
    <app-bar />
    <v-main>
      <image-container />
      <!-- <router-view></router-view> -->
    </v-main>
  </v-app>
</template>

<script>
import AppBar from "./components/AppBar.vue";
import ImageContainer from './components/ImageContainer.vue'
export default {
  name: "App",
  components: {
    AppBar,
    ImageContainer
  },
};
</script>
