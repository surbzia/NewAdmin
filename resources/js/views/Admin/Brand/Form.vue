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
  cols="6"
  sm="6"
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
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    v-model="form.slug"
    :rules="[rules.required]"
    :error-messages="errors.slug"
    label="Slug"
  ></v-text-field>
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
    @click="addpermission"
    :loading="btnloading"
    :disabled="btnloading"
  >{{form.id>0?'Update':'Add'}}</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row>
  </div>
</template>

<script>
import brandservice from "@services/auth/brand";
export default {
  name: "auth.users.add",
  watch:{
    'form.name': function(){
      let _val = this.form.name
      _val = _val.replace(/([^a-zA-Z0-9\-_\s]+)/gi, "");
      _val = _val.replace(/\s+/g, '-');
      this.form.slug = (_val.toLowerCase());
    }
  },
  async mounted(){
    if(this.$route.params.id){
        var res = await brandservice.get(this.form.id)
        this.form = {
            name: res.name,
            slug: res.slug,
            id: this.$route.params.id,
            image_url: res.image_url,
        }
        this.bread.push({
          text: "Edit",
          to: { name: "auth.brands.edit", params: {id: this.$route.params.id} },
          disabled: false,
          exact: true,
        })
    }else{
        this.bread.push({
          text: "Add",
          to: { name: "auth.brands.add"},
          disabled: false,
          exact: true,
        })
    }
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          slug: [],
          image: [],
      }
    },
    addpermission: async function () {
        this.resetError()
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("slug", this.form.slug);
        if(this.form.image){
            formdata.append("image", this.form.image);
        }
        this.btnloading = false;
        if(this.form.id>0){
            var res = await brandservice.update(formdata, this.form.id)
        }else{
            var res = await brandservice.create(formdata)
        }
        if(!res.status){
            if(res.data.name){
                this.errors.name = res.data.name
            }
            if(res.data.slug){
                this.errors.slug = res.data.slug
            }
            if(res.data.image){
                this.errors.image = res.data.image
            }
            //errors here
        }else{
            //suuccess here
            this.$router.push({ name: "auth.brands.listing" });
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
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          name: '',
          slug: '',
          image: undefined,
      },
      errors: {
          name:[],
          slug: [],
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
          text: "Brand",
          to: { name: "auth.brands.listing" },
          disabled: false,
          exact: true,
        }
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
