<template>
  <div>
        <breadcumbs :data="{ step1: 'User Profile', step2: 'Update' }"></breadcumbs>
    <div class="container-fluid card">
      <div class="row p-3">
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-12">
              <div style="text-align: center">
                <img :src="imageurl" height="86px" class="responsive" alt="" />
              </div>
            </div>
            <div class="col-md-12">
              <input
                type="file"
                class="form-control form-control-sm"
                placeholder="Password"
               @change="onFileChange"
              />
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-6">
              <input
                type="text"
                v-model="first_name"
                class="form-control form-control-sm"
                placeholder="First Name"
              />
            </div>
            <div class="col-md-6">
              <input
                type="text"
                v-model="last_name"
                class="form-control form-control-sm"
                placeholder="Last Name"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <input
                type="email"
                v-model="email"
                class="form-control form-control-sm"
                placeholder="Email Address"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input
                type="password"
                v-model="password"
                class="form-control form-control-sm"
                placeholder="write password if want to update"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="row pb-3 pr-3">
        <div class="col-md-12 text-right">
          <button
            type="button"
            @click="adduser"
            class="btn bg-gradient-primary btn-sm pl-3 pr-3 text-white"
          >
            Submit
          </button>
        </div>
      </div>
    </div>
<!-- <v-row no-gutters  class="grey lighten-5 pa-10 rounded elevation-10">
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
    v-model="first_name"
    :rules="[rules.required]"
    :error-messages="errors.first_name"
    label="First Name"
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    v-model="last_name"
    :rules="[rules.required]"
    :error-messages="errors.last_name"
    label="Last Name"
  ></v-text-field>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
  <v-text-field
    v-model="email"
    :rules="[rules.required]"
    :error-messages="errors.email"
    label="Email"
  ></v-text-field>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
  <v-text-field
    v-model="password"
    :error-messages="errors.password"
    label="password"
    type="password"
    autocomplete="new-password"
  ></v-text-field>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
  <v-file-input
    show-size
    v-model="image"
    :error-messages="errors.file"
    accept="image/png, image/jpeg, image/bmp"
    label="Title Image"
    :rules="[rules.required]"
    truncate-length="15"
  ></v-file-input>
  <v-img
    :lazy-src="imageurl"
    max-height="100"
    max-width="150"
    contain
    :src="imageurl"
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
    @click="addbrand"
    :loading="btnloading"
    :disabled="btnloading"
  >Save</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row> -->
  </div>
</template>

<script>
import loginservice from "@services/auth/login";
import fileservice from "@services/auth/file";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
export default {
  components: {
    breadcumbs,
  },
  name: "auth.company.edit",
  mounted(){
      this.startProfile()
  },
  methods: {
    async startProfile(){
      this.id = this.$route.params.id
      var res = await loginservice.me()
      this.last_name = res.last_name
      this.first_name = res.first_name
      this.email = res.email
      this.password = ''
      this.imageurl = res.image_url
    },
    resetError(){
        this.errors = {
          last_name:[],
          first_name:[],
          password: [],
          email: [],
          file: [],
      }
    },
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;
      this.image = files[0];
      this.file = 1;
    },
        adduser: async function () {
        this.resetError()
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("first_name", this.first_name);
        formdata.append("last_name", this.last_name);
        formdata.append("email", this.email);
        if(this.password){
            formdata.append("password", this.password);
        }
        if(this.file == 1){
            formdata.append("file", this.image);
        }
        this.btnloading = false;
        var res = await loginservice.updateProfile(formdata, this.id)
        if(!res.status){
            if(res.data.last_name){
                this.errors.last_name = res.data.last_name
            }
            if(res.data.first_name){
                this.errors.first_name = res.data.first_name
            }
            if(res.data.email){
                this.errors.email = res.data.email
            }
            if(res.data.password){
                this.errors.password = res.data.password
            }
            if(res.data.file){
                this.errors.file = res.data.file
            }
            //errors here
        }else{
            //suuccess here
            if(this.image.size){
                var fileData = new FormData();
                fileData.append("ref_id", res.data.id);
                fileData.append("table_name", 'users');
                fileData.append("type", '1');
                fileData.append("attachements[0]", this.image);
                await fileservice.create(fileData)
            }
            this.$toaster.success("Profile Updated successfully.");
            //   setTimeout(() => 
            //  this.$router.push({ name: "auth.roles.listing" }), 
            //   2000);
            this.startProfile()
        }
    },
  },
  data() {
    return {
      last_name: "",
      first_name: "",
      id: 0,
      email:'',
      password: '',
      imageurl: '',
      errors: {
          last_name:[],
          first_name: [],
          email: [],
          password: [],
          file: [],
      },
      image: {},
      file: 0,
      loading: false,
      btnloading: false,
      rules: {
        required: (value) => !!value || "Required.",
      },
    };
  },
};
</script>
