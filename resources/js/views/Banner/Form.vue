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
    v-model="form.redirect_to"
    :rules="[rules.required]"
    :error-messages="errors.redirect_to"
    :hint="MIX_FRONT_WEBSITE_URL+'/'+form.redirect_to"
    label="Redirect To"
    persistent-hint
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
<v-select
    :items="['Home']"
    label="Page"
    :rules="[rules.required]"
    :error-messages="errors.page"
    v-model="form.page"
></v-select>
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
import defaultservice from "@services/auth/default";
const service = new defaultservice('banners')
export default {
  name: "auth.banners.add",
  async mounted(){
    if(this.$route.params.id){
        var res = await service.get(this.form.id)
        this.form = {
            redirect_to: res.redirect_to,
            page: res.page,
            id: this.$route.params.id,
            image_url: res.image_url,
        }
        this.bread.push({
          text: "Edit",
          to: { name: "auth.banners.edit", params: {id: this.$route.params.id} },
          disabled: false,
          exact: true,
        })
    }else{
        this.bread.push({
          text: "Add",
          to: { name: "auth.banners.add"},
          disabled: false,
          exact: true,
        })
    }
  },
  methods: {
    resetError(){
        this.errors = {
          redirect_to:[],
          page: [],
          image: [],
      }
    },
    addpermission: async function () {
        this.resetError()
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("redirect_to", this.form.redirect_to);
        formdata.append("page", this.form.page);
        if(this.form.image){
            formdata.append("image", this.form.image);
        }
        this.btnloading = false;
        if(this.form.id>0){
            var res = await service.update(formdata, this.form.id)
        }else{
            var res = await service.create(formdata)
        }
        if(!res.status){
            if(res.data.redirect_to){
                this.errors.redirect_to = res.data.redirect_to
            }
            if(res.data.page){
                this.errors.page = res.data.page
            }
            if(res.data.image){
                this.errors.image = res.data.image
            }
            //errors here
        }else{
            //suuccess here
            this.$router.push({ name: "auth.banners.listing" });
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
    MIX_FRONT_WEBSITE_URL: process.env.MIX_FRONT_WEBSITE_URL,
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          redirect_to: '',
          page: '',
          image: undefined,
      },
      errors: {
          redirect_to:[],
          page: [],
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
          text: "Banner",
          to: { name: "auth.banners.listing" },
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
