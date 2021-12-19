<template>
  <v-app-bar app dark color="primary">
    <v-toolbar-title>Title</v-toolbar-title>
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