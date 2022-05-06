<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
    transition="dialog-bottom-transition"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" dark v-bind="attrs" v-on="on"> Open File Uploader </v-btn>
    </template>
    <v-card>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="dialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>File Uploader</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <fileGrid v-on:selected_url="giveUrl" :tablename="tablename" />
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import fileGrid from "@/components/fileuploader/fileGrid.vue";
export default {
  components:{
    fileGrid,
  },
  data() {
    return {
      dialog: false,
    };
  },
  props: {
    tablename: {
      type: String,
      default: "",
    },
  },
  methods: {
    async giveUrl(url){
      this.dialog = !this.dialog
      this.$emit('input', url)
    }
  },
};
</script>
