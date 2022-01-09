<template>
  <div>
    <v-btn
      :disabled="dialog"
      color="primary"
      outlined
      class="mx-6 rounded-lg"
      @click="dialog = true"
    >
      <v-icon left light> mdi-magnify </v-icon>
      Search
    </v-btn>
    <v-dialog v-model="dialog" width="400">
      <v-card class="rounded-lg">
        <v-card-title>
          <span class="text-h5">Search photo</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="labelToSearch"
                  label="Photo label*"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="rounded-lg"
            color="secondary"
            :disabled="searching"
            @click="dialog = false"
            >Cancel</v-btn
          >
          <v-btn
            class="rounded-lg"
            color="primary"
            :loading="searching"
            @click="searchPhotos()"
          >
            Search
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "SearchInput",
  data: () => ({
    dialog: false,
    searching: false,
    labelToSearch: null,
  }),
  mounted() {
    this.$root.$on("searchPhotos", (labelToSearch) => {
      this.labelToSearch = labelToSearch;
      this.searchPhotos();
    });
  },
  methods: {
    searchPhotos() {
      this.axios
        .get("/api/photo", {
          params: {
            label: this.labelToSearch,
          },
        })
        .then((res) => {
          this.$root.$emit("getSearchPhotos", this.labelToSearch, res.data);
        })
        .catch((err) => {
          this.$root.$emit("showToast", "An error has occurred. Try again.", 4);
          console.log("Error", err);
        });
    },
  },
};
</script>