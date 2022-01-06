<template>
  <v-snackbar
    app
    v-model="toast.enabled"
    :timeout="onTimeout"
    :color="toast.type"
    text
    elevation="4"
    absolute
    top
    right
    class="fixed-pos"
  >
    {{ toast.message }}
    <template v-slot:action="{ attrs }">
      <v-btn icon v-bind="attrs" @click="resetToast()">
        <v-icon :color="toast.type">mdi-close-circle</v-icon>
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  name: "Toast",
  data: () => ({
    toast: {
      enabled: false,
      type: null,
      message: null,
    },
    timeout: 5000,
  }),
  mounted() {
    this.$root.$on("showToast", (message, type = 1) => {
      this.showToast(message, type);
    });
  },
  methods: {
    showToast(message, type) {
      let types = {
        1: "info",
        2: "success",
        3: "warning",
        4: "error",
      };
      this.toast = {
        enabled: true,
        type: types[type],
        message: message,
      };
    },
    resetToast() {
      this.toast = {
        enabled: false,
        type: null,
        message: null,
      };
    },
  },
  computed: {
    onTimeout() {
      this.resetToast();
      return this.timeout;
    },
  },
};
</script>

<style>
.fixed-pos {
  z-index: 300 !important;
}
.fixed-pos .v-snack__wrapper {
  position: fixed;
}
</style>