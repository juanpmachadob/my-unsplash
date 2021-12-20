<template>
  <div>
    <!-- <v-btn color="success" class="rounded-lg">Add a </v-btn> -->
    <v-btn
      :disabled="dialog"
      color="primary"
      outlined
      class="mx-8 rounded-lg"
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
                <v-text-field label="Photo name*" required></v-text-field>
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
            :disabled="searching"
            :loading="searching"
            @click="searchPhoto()"
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
  }),
};
</script>