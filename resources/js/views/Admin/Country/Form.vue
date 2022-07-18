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
  cols="8"
  sm="8"
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
    v-model="form.iso_code"
    :rules="[rules.required]"
    :error-messages="errors.iso_code"
    label="ISO Code (3)"
  ></v-text-field>
</v-col>

<v-col cols="12" sm="12" class="pb-0">
  <v-checkbox
    v-model="form.is_allowed_for_checkout"
    label="Is Allowed for Checkout?"
  ></v-checkbox>
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
const service = new defaultservice('countries')
export default {
  name: "auth.countries.add",
  async mounted(){
    if(this.$route.params.id){
        var res = await service.get(this.form.id)
        this.form = {
            name: res.name,
            iso_code: res.iso_code,
            is_allowed_for_checkout: (res.is_allowed_for_checkout==1?true:false),
            id: this.$route.params.id,
        }
        this.bread.push({
          text: "Edit",
          to: { name: "auth.countries.edit", params: {id: this.$route.params.id} },
          disabled: false,
          exact: true,
        })
    }else{
        this.bread.push({
          text: "Add",
          to: { name: "auth.countries.add"},
          disabled: false,
          exact: true,
        })
    }
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          iso_code: [],
          is_allowed_for_checkout: [],
      }
    },
    addpermission: async function () {
        this.resetError()
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("iso_code", this.form.iso_code);
        formdata.append("is_allowed_for_checkout", (this.form.is_allowed_for_checkout==true?1:0));
        this.btnloading = false;
        if(this.form.id>0){
            var res = await service.update(formdata, this.form.id)
        }else{
            var res = await service.create(formdata)
        }
        if(!res.status){
            if(res.data.name){
                this.errors.name = res.data.name
            }
            if(res.data.iso_code){
                this.errors.iso_code = res.data.iso_code
            }
            if(res.data.is_allowed_for_checkout){
                this.errors.is_allowed_for_checkout = res.data.is_allowed_for_checkout
            }
            //errors here
        }else{
            //suuccess here
            this.$router.push({ name: "auth.countries.listing" });
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
          name: '',
          iso_code: '',
          is_allowed_for_checkout: false,
      },
      errors: {
          name:[],
          iso_code: [],
          is_allowed_for_checkout: [],
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Country",
          to: { name: "auth.countries.listing" },
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
