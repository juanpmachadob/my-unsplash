<template>
  <v-app-bar app light color="white" elevate-on-scroll>
    <v-toolbar-title>My unsplash</v-toolbar-title>
    <search-input></search-input>
    <v-spacer></v-spacer>
    <add-dialog />
  </v-app-bar>
</template>
<script>
import AddDialog from "./AddDialog.vue";
import SearchInput from "./SearchInput.vue";
export default {
  name: "AppBar",
  components: {
    AddDialog,
    SearchInput,
  },
};
</script>