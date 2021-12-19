<template>
  <v-app-bar app light color="white" elevate-on-scroll>
    <v-toolbar-title>My unsplash</v-toolbar-title>
    <v-spacer></v-spacer>
    <add-dialog/>
  </v-app-bar>
</template>
<script>
import AddDialog from './AddDialog.vue'
export default {
  name: "AppBar",
  components: {
    AddDialog
  },
  data: () => ({
  }),
};
</script>