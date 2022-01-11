<template>
  <v-btn
    class="rounded-xl mr-2"
    title="Copy url"
    :color="show ? 'success' : 'primary'"
    elevation="2"
    small
    outlined
    v-bind="attrs"
    @click="copyToClipboard()"
  >
    <v-icon v-if="!show">mdi-link</v-icon>
    <span v-else>Copied <v-icon>mdi-check</v-icon></span>
  </v-btn>
</template>

<script>
export default {
  name: "UrlButton",
  data: () => ({
    show: false,
  }),
  props: {
    url: String,
  },
  methods: {
    copyToClipboard() {
      navigator.clipboard.writeText(this.url);
      this.show = true;
      setTimeout(() => (this.show = false), 2000);
    },
  },
};
</script>