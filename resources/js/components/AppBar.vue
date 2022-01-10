<template>
  <v-app-bar app color="white" elevate-on-scroll>
    <v-container>
      <v-app-bar color="white" dense elevation="0" class="pa-0">
        <v-toolbar-title>
        <v-list-item class="pa-0">
          <v-list-item-avatar class="mr-0"
            ><v-icon left> mdi-image-album </v-icon>
          </v-list-item-avatar>
          <v-list-item-content class="d-block">
            <v-list-item-title>My unsplash</v-list-item-title>
            <v-list-item-subtitle>By Juan Pablo Machado</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        </v-toolbar-title>
        <search-input></search-input>
        <v-chip
          color="primary"
          v-if="labelToSearch"
          close
          @click:close="resetSearch()"
          >Searching:
          <strong>{{ labelToSearch }}</strong>
        </v-chip>
        <v-spacer></v-spacer>
        <add-dialog />
      </v-app-bar>
    </v-container>
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
    labelToSearch: String,
  },
  methods: {
    resetSearch() {
      this.$emit("resetSearch");
    },
  },
};
</script>

<style>
.v-toolbar__content {
  padding: 0 !important;
}
</style>