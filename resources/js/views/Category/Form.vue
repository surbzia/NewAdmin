<template>
  <div>
    <v-breadcrumbs :items="bread">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template></v-breadcrumbs
    >
</v-breadcrumbs>
<v-row no-gutters  class="grey lighten-5 pa-10 rounded elevation-10">
<v-col
cols="12"
sm="12"
>
<v-form
ref="form"
v-model="loading"
lazy-validation
>

<v-row>
<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
  <v-text-field
    v-model="form.name"
    :rules="[rules.required]"
    :error-messages="errors.name"
    label="Name"
  ></v-text-field>
</v-col>

<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
  <v-text-field
    v-model="form.slug"
    :rules="[rules.required]"
    :error-messages="errors.slug"
    label="Slug"
  ></v-text-field>
</v-col>
<v-col
  cols="4"
  sm="4"
  class="pb-0"
>
  <v-text-field
    v-model="form.category_alias"
    :rules="[rules.required]"
    :error-messages="errors.alias"
    label="Alias"
  ></v-text-field>
</v-col>

<v-col cols="12" sm="12" class="pb-0">
    <label>Short Description</label>
    <ckeditor :editor="editor" v-model="form.short_description" :config="editorConfig"></ckeditor>
</v-col>

<v-col cols="12" sm="12" class="pb-0">
    <label>Description</label>
    <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
</v-col>
<v-col cols="4" sm="4" class="pb-0">
  <v-checkbox
    v-model="form.is_featured"
    label="Is Featured?"
  ></v-checkbox>
</v-col>
<v-col cols="4" sm="4" class="pb-0">
  <v-checkbox
    v-model="form.show_in_main_menu"
    label="Show In Main Menu?"
  ></v-checkbox>
</v-col>
<v-col cols="4" sm="4" class="pb-0">
  <v-checkbox
    v-model="form.show_in_home_sidemenu"
    label="Show In Side Menu?"
  ></v-checkbox>
</v-col>
<v-col cols="12" cm="12" class="pb-0">
<v-file-input
    accept="image/*"
    v-model="form.image"
    :error-messages="errors.image"
    label="Image"
  ></v-file-input>
</v-col>
<v-col v-if="form.id>0&&form.image_url" cols="12" cm="12" class="pb-0">
  <v-img
    :lazy-src="form.image_url"
    max-height="150"
    max-width="250"
    :src="form.image_url"
  ></v-img>
</v-col>

<!-- <v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-select
    v-model="form.parent_id"
    :items="categories"
    label="Parent"
    item-text="name"
    item-value="id"
></v-select>
</v-col> -->

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<label>Parent Category</label>
<v-alert
  dense
  outlined
  type="error"
  v-if="errors.parent_id.length>0"
>
  {{errors.parent_id.join(', ')}}
</v-alert>
<v-treeview
  @update:active="getCurrentSelectionParent"
  activatable
  dense
  :items="categories"
  :active="default_category"
  :open="default_category"
></v-treeview>
</v-col>
 <v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-btn
    color="secondary"
    elevation="1"
    large
    raised
    @click="addpermission(false)"
    :loading="btnloading"
    :disabled="btnloading"
  >{{form.id>0?'Update':'Add'}}</v-btn>

<v-btn
  color="secondary"
  elevation="1"
  large
  raised
  @click="addpermission(true)"
  :loading="btnloading"
  :disabled="btnloading"
  v-if="form.id==0"
>Create and Stay</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row>
  </div>
</template>

<script>
import categoryservice from "@services/auth/category";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  name: "auth.categories.add",
  watch: {
    "form.name": function () {
      let _val = this.form.name;
      _val = _val.replace(/([^a-zA-Z0-9\-_\s]+)/gi, "");
      _val = _val.replace(/\s+/g, "-");
      this.form.slug = _val.toLowerCase();
    },
  },
  async mounted() {
    categoryservice.getlist("").then((e) => {
      this.categories.push({ id: 0, name: "No Parent" });
      this.categories.push(
        ...e.data.filter((e) => {
          return e.parent_id == 0;
        })
      );
    });
    if (this.$route.params.id) {
      var res = await categoryservice.get(this.form.id);
      this.form = {
        name: res.name,
        slug: res.slug,
        parent_id: res.parent_id,
        description: res.description ? res.description : "",
        short_description: res.short_description ? res.short_description : "",
        is_featured: res.is_featured == 1 ? true : false,
        show_in_main_menu: res.show_in_main_menu == 1 ? true : false,
        show_in_home_sidemenu: res.show_in_home_sidemenu == 1 ? true : false,
        image_url: res.image_url,
        id: res.id,
      };
      this.default_category = [];
      this.default_category.push(res.parent_id);
      this.bread.push({
        text: "Edit",
        to: {
          name: "auth.categories.edit",
          params: { id: this.$route.params.id },
        },
        disabled: false,
        exact: true,
      });
      await this.$nextTick();
      this.form.slug = res.slug;
    } else {
      this.bread.push({
        text: "Add",
        to: { name: "auth.categories.add" },
        disabled: false,
        exact: true,
      });
    }
  },
  methods: {
    getCurrentSelectionParent(value) {
      this.form.parent_id = value[0];
    },
    resetError() {
      this.errors = {
        name: [],
        slug: [],
        parent_id: [],
        description: [],
        short_description: [],
        is_featured: [],
        show_in_main_menu: [],
        show_in_home_sidemenu: [],
        image: [],
      };
    },
    addpermission: async function (stay = false) {
      this.resetError();
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("slug", this.form.slug);
        formdata.append("category_alias", this.form.category_alias);
        formdata.append("parent_id", this.form.parent_id);
        formdata.append("description", this.form.description);
        formdata.append("short_description", this.form.short_description);
        formdata.append("is_featured", this.form.is_featured == true ? 1 : 0);
        formdata.append(
          "show_in_main_menu",
          this.form.show_in_main_menu == true ? 1 : 0
        );
        formdata.append(
          "show_in_home_sidemenu",
          this.form.show_in_home_sidemenu == true ? 1 : 0
        );
        if (this.form.image) {
          formdata.append("image", this.form.image);
        }
        this.btnloading = false;
        if (this.form.id > 0) {
          var res = await categoryservice.update(formdata, this.initialslug);
        } else {
          var res = await categoryservice.create(formdata);
        }
        if (!res.status) {
          if (res.data.name) {
            this.errors.name = res.data.name;
          }
          if (res.data.slug) {
            this.errors.slug = res.data.slug;
          }
          if (res.data.category_alias) {
            this.errors.category_alias = res.data.category_alias;
          }
          if (res.data.parent_id) {
            this.errors.parent_id = res.data.parent_id;
          }
          if (res.data.description) {
            this.errors.description = res.data.description;
          }
          if (res.data.short_description) {
            this.errors.short_description = res.data.short_description;
          }
          if (res.data.is_featured) {
            this.errors.is_featured = res.data.is_featured;
          }
          if (res.data.show_in_main_menu) {
            this.errors.show_in_main_menu = res.data.show_in_main_menu;
          }
          if (res.data.show_in_home_sidemenu) {
            this.errors.show_in_home_sidemenu = res.data.show_in_home_sidemenu;
          }
          if (res.data.image) {
            this.errors.image = res.data.image;
          }
          //errors here
        } else {
          //suuccess here
          if (stay === false) {
            this.$router.push({ name: "auth.categories.listing" });
          } else {
            this.$store.commit(
              "setNotification",
              "Category Saved, You can now add more"
            );
            this.form = {
              id: 0,
              name: "",
              category_alias: "",
              slug: "",
              parent_id: 0,
              description: "",
              short_description: "",
              image: undefined,
              is_featured: false,
              show_in_main_menu: false,
              show_in_home_sidemenu: false,
            };
          }
        }
      }
    },
  },
  computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
  },
  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {},
      categories: [],
      default_category: [],
      initialslug: this.$route.params.id ? this.$route.params.id : "",
      form: {
        id: this.$route.params.id ? this.$route.params.id : 0,
        name: "",
        slug: "",
        parent_id: 0,
        description: "",
        short_description: "",
        image: undefined,
        is_featured: false,
        show_in_main_menu: false,
        show_in_home_sidemenu: false,
      },
      errors: {
        name: [],
        slug: [],
        parent_id: [],
        description: [],
        short_description: [],
        is_featured: [],
        show_in_main_menu: [],
        show_in_home_sidemenu: [],
        image: [],
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Category",
          to: { name: "auth.categories.listing" },
          disabled: false,
          exact: true,
        },
      ],
      loading: false,
      btnloading: false,
      rules: {
        required: (value) => !!value || "Required.",
      },
    };
  },
};
</script>
