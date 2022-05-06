<template>
  <div>
     <breadcumbs :data="{step1:'Roles',step2:'Add'}"></breadcumbs>
<div class="container-fluid">
    <div class="row card">
          <div class="row pl-3 pr-3 pt-2">
          <div class="col-md-6 text-left">
        <div class="icheck-info d-inline">
            <input type="checkbox" @click="select_all" id="select_all">
            <label for="select_all">
            Select All
            </label>
          </div>
       </div>
        <div class="col-md-6 text-right">
         <button type="button" @click="addpermission" class="btn bg-gradient-primary btn-sm pl-3 pr-3 text-white" >Save</button>
       </div>
     </div>
      <div class="row p-3">
         <div class="col-md-6">
         <input type="text" v-model="form.name" class="form-control " placeholder="Role Name">
         <p class="text-danger" v-if="errors.name.length > 0" >{{errors.name[0]}}</p>
       </div>
       <div class="col-md-6">
         <input type="text" v-model="form.title" class="form-control " placeholder="Role Title">
         <p class="text-danger" v-if="errors.title.length > 0" >{{errors.title[0]}}</p>
       </div>
      </div>
       <div class="col-md-12">
        <div class="row">
        <div class="col-md-3" v-for="permission  in permissions" :key="permission.id">
             <div class="icheck-primary d-inline">
            <input type="checkbox" v-bind:id="permission.id" v-bind:value='permission.id' v-model='form.permissions'>
            <label v-bind:for="permission.id">
             {{permission.title}}
            </label>
          </div>
         </div>
        </div>
       </div>
    </div>
</div>

    <!-- <v-breadcrumbs :items="bread">
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
  cols="12"
  sm="12"
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
  cols="12"
  sm="12"
  class="pb-0"
>
  <v-text-field
    v-model="form.title"
    :rules="[rules.required]"
    :error-messages="errors.name"
    label="Title"
  ></v-text-field>
</v-col>
<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-select
    v-model="form.permissions"
    :items="permissions"
    label="Permissions"
    item-text="title"
    item-value="id"
    return-object
    multiple
    chips
    hint="Select All permissions you want to sync with this role"
    persistent-hint
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
    @click="addpermission"
    :loading="btnloading"
    :disabled="btnloading"
  >{{form.id>0?'Update':'Add'}}</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row> -->
  </div>
</template>

<script>
import rolesservice from "@services/auth/roles";
import permissionservice from "@services/auth/permission";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
import Swal from 'sweetalert2';
export default {
  components:{
    breadcumbs
  },
  name: "auth.roles.add",
  async mounted(){
    this.permissions = await permissionservice.get('')
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          title: [],
          permissions: [],
      }
    },
    select_all: function() {
      if(this.permissions.length == this.form.permissions.length){
          this.form.permissions =[];
      }else{
      for( var key in this.permissions){
      this.form.permissions.push(this.permissions[key].id);
      }
      }
    },
    addpermission: async function () {
        this.resetError()
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("title", this.form.title);
        console.log(this.form.permissions);
        for(let i = 0; i < this.form.permissions.length; i++){
            formdata.append("permissions["+i+"]", this.form.permissions[i]);
        }
        this.btnloading = false;
        if(this.form.id>0){
            var res = await rolesservice.update(formdata, this.form.id)
        }else{
            var res = await rolesservice.create(formdata)
        }
        if(!res.status){
            if(res.data.name){
                this.errors.name = res.data.name
            }
            if(res.data.title){
                this.errors.title = res.data.title
            }
            if(res.data.permissions){
           Swal.fire({
            text: res.data.permissions,
            icon: "error",
            timer: 2000,
          });
            }
            //errors here
        }else{
            //suuccess here
              this.$toastr.s("Role Created successfully.", "Success");
              setTimeout(() => 
             this.$router.push({ name: "auth.roles.listing" }), 
              2000);
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
          title: '',
          permissions: [],
      },
      errors: {
          name:[],
          title: [],
          permissions: [],
      },
      permissions: [],
      loading: false,
      btnloading: false,
    };
  },
};
</script>
