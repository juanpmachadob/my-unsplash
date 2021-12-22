<template>
  <div>
    <v-btn
      :disabled="dialog"
      class="rounded-lg"
      color="red darken-2"
      outlined
      @click="dialog = true"
    >
      <v-icon>mdi-delete</v-icon>
    </v-btn>
    <v-dialog v-model="dialog" max-width="500px" persistent>
      <v-card class="rounded-lg">
        <v-card-title>
          <span class="text-h5">Delete photo</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" align="center">
                <v-img
                  max-width="250px"
                  src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                ></v-img>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Password*"
                  type="password"
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
            :disabled="uploading"
            @click="dialog = false"
            >Cancel</v-btn
          >
          <v-btn
            class="rounded-lg"
            color="danger"
            dark
            :disabled="uploading"
            :loading="uploading"
            @click="deletePhoto()"
          >
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "DeleteDialog",
  data: () => ({
    dialog: false,
    uploading: false,
  }),
  props: {
    index: String,
  },
  methods: {
    deletePhoto() {
      this.axios
        .delete(`/api/photo/${this.index}`, this.photo)
        .then((res) => {})
        .catch((err) => {});
    },
  },
};
</script>