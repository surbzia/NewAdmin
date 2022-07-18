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
    v-model.number="form.tax_percent"
    :rules="[rules.required]"
    :error-messages="errors.tax_percent"
    label="Tax %"
    type="number"
    min="0"
    max="100"
  ></v-text-field>
</v-col>
<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-select
    :items="countries"
    item-text="name"
    item-value="id"
    label="Country*"
    required
    v-model="form.country_id"
    :error-messages="errors.country_id"
></v-select>
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
  >Add and Stay</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row>
  </div>
</template>

<script>
import defaultservice from "@services/auth/default";
const service = new defaultservice('states')
const countriesservice = new defaultservice('countries')
export default {
  name: "auth.states.add",
  async mounted(){
    countriesservice.get('').then(e=>{
      this.countries=e
    })
    if(this.$route.params.id){
        var res = await service.get(this.form.id)
        this.form = {
            name: res.name,
            country_id: res.country_id,
            tax_percent: res.tax_percent,
            id: this.$route.params.id,
        }
        this.bread.push({
          text: "Edit",
          to: { name: "auth.states.edit", params: {id: this.$route.params.id} },
          disabled: false,
          exact: true,
        })
    }else{
        this.bread.push({
          text: "Add",
          to: { name: "auth.states.add"},
          disabled: false,
          exact: true,
        })
    }
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          country_id: [],
          tax_percent: [],
      }
    },
    addpermission: async function (stay = false) {
        this.resetError()
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("country_id", this.form.country_id);
        formdata.append("tax_percent", this.form.tax_percent);
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
            if(res.data.country_id){
                this.errors.country_id = res.data.country_id
            }
            if(res.data.tax_percent){
                this.errors.tax_percent = res.data.tax_percent
            }
            //errors here
        }else{
            //suuccess here
            if(stay==false){
                this.$router.push({ name: "auth.states.listing" });
            }else{
                this.$store.commit("setNotification", "State Saved, You can now add more");
                this.form = {
                    country_id: 0,
                    name: '',
                    tax_percent: 0,
                    id: 0,
                }
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
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          name: '',
          country_id: 0,
          tax_percent: false,
      },
      countries: [],
      errors: {
          name:[],
          country_id: [],
          tax_percent: [],
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "State",
          to: { name: "auth.states.listing" },
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
