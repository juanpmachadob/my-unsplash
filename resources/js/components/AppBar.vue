<template>
  <v-app-bar app light color="white" elevate-on-scroll>
    <v-toolbar-title>My unsplash</v-toolbar-title>
    <search-input></search-input>
    <v-chip color="primary" v-if="labelToSearch" close @click:close="resetSearch()"
      >Searching:
      <strong>{{ labelToSearch }}</strong>
    </v-chip>
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
  props: {
    labelToSearch: String
  },
  methods: {
    resetSearch(){
      this.$emit("resetSearch");
    }
  }
};
</script>