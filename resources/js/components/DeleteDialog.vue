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
                  class="rounded-lg"
                  max-width="250px"
                  :src="photo.url"
                ></v-img>
              </v-col>
              <v-col cols="12">
                <v-alert dense text type="error">
                  Please, type
                  <strong
                    >delete/{{
                      photo.label.toLowerCase().replace(" ", "-")
                    }}</strong
                  >
                  to delete.
                </v-alert>
                <v-text-field
                  label="Confirmation*"
                  required
                  v-model="confirmation"
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
            :disabled="deleting"
            @click="dialog = false"
            >Cancel</v-btn
          >
          <v-btn
            ref="test"
            class="rounded-lg"
            color="danger"
            :dark="checkConfirmation"
            :disabled="!checkConfirmation"
            :loading="deleting"
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
    deleting: false,
    confirmation: null,
  }),
  props: {
    index: String,
    photo: Object,
  },
  methods: {
    deletePhoto() {
      if (this.checkConfirmation) {
        this.deleting = true;
        this.axios
          .delete(`/api/photo/${this.index}`, this.photo)
          .then((res) => {
            this.$root.$emit("getPhotos");
            this.deleting = false;
            this.dialog = false;
            this.$root.$emit("showToast", res.data, 2);
          })
          .catch((err) => {
            if (err.response.status === 400) {
              this.deleting = false;
              this.$root.$emit("showToast", err.response.data, 4);
            } else {
              this.$root.$emit(
                "showToast",
                "An error has occurred. Try again.",
                4
              );
              console.log("Error:", err);
            }
          });
      } else if (!this.confirmation) {
        this.$root.$emit(
          "showToast",
          "Please, type the confirmation to continue.",
          1
        );
      } else {
        this.$root.$emit(
          "showToast",
          "The confirmation message doesnt' match.",
          3
        );
      }
    },
  },
  computed: {
    checkConfirmation() {
      let confirmationText =
        "delete/" + this.photo.label.toLowerCase().replaceAll(" ", "-");
      return this.confirmation == confirmationText;
    },
  },
};
</script>