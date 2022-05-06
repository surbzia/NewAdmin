<template>
  <div>
    <breadcumbs :data="{ step1: 'Users', step2: 'Edit' }"></breadcumbs>
    <div class="container-fluid card">
      <div class="col-md-12 text-right">
        <router-link
          :to="{ name: 'auth.users.listing' }"
          class="btn bg-gradient-dark btn-sm pl-3 pr-3"
          >Back</router-link
        >
      </div>
      <div class="row p-3">
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-12">
              <div style="text-align: center">
                <img :src="image_url" height="86px" class="responsive" alt="" />
              </div>
            </div>
            <div class="col-md-12">
              <input
                type="file"
                class="form-control form-control-sm"
                placeholder="Password"
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
            <div class="col-md-6">
              <select class="form-control form-control-sm" v-model="role_id">
                <option value="">Select Role</option>
                <option
                  v-for="role in roles"
                  :key="role.id"
                  v-bind:value="role.id"
                >
                  {{ role.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input
                type="password"
                v-model="password"
                class="form-control form-control-sm"
                placeholder="Password"
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
<v-select
    :items="roles"
    item-text="name"
    item-value="id"
    label="Role*"
    required
    v-model="role_id"
    :error-messages="errors.role_id"
></v-select>
</v-col>


<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
  <v-text-field
    v-model="password"
    :error-messages="errors.password"
    label="Password"
    type="password"
    autocomplete="new-password"
  ></v-text-field>
</v-col>
{{image}}
<v-col cols="12" cm="12" class="pb-0">
<v-file-input
    accept="image/*"
    v-model="image"
    :error-messages="errors.image"
    label="Image"
  ></v-file-input>
</v-col>
<v-col v-if="image_url" cols="12" cm="12" class="pb-0">
  <v-img
    :lazy-src="image_url"
    max-height="150"
    max-width="250"
    :src="image_url"
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
  >Update</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row> -->
  </div>
</template>

<script>
import userervice from "@services/auth/user";
import rolesservice from "@services/auth/roles";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
export default {
  components: {
    breadcumbs,
  },
  name: "auth.users.add",
  async mounted() {
    this.id = this.$route.params.id;
    var res = await userervice.get(this.id);
    this.first_name = res.first_name;
    this.last_name = res.last_name;
    this.email = res.email;
    this.password = res.password;
    this.role_id = res.role_id;
    this.image_url = res.image_url;
    rolesservice.get("").then((e) => {
      this.roles = e;
    });
  },
  methods: {
    resetError() {
      this.errors = {
        first_name: [],
        last_name: [],
        email: [],
        password: [],
        role_id: [],
        image: [],
      };
    },
    adduser: async function () {
      this.resetError();
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("first_name", this.first_name);
        formdata.append("last_name", this.last_name);
        formdata.append("email", this.email);
        if (this.password != "") {
          formdata.append("password", this.password);
        }
        formdata.append("role_id", this.role_id);
        if (this.image) {
          formdata.append("image", this.image);
        }
        this.btnloading = false;
        var res = await userervice.update(formdata, this.id);
        if (!res.status) {
          if (res.data.first_name) {
            this.errors.first_name = res.data.first_name;
          }
          if (res.data.last_name) {
            this.errors.last_name = res.data.last_name;
          }
          if (res.data.email) {
            this.errors.email = res.data.email;
          }
          if (res.data.password) {
            this.errors.password = res.data.password;
          }
          if (res.data.role_id) {
            this.errors.role_id = res.data.role_id;
          }
          if (res.data.image) {
            this.errors.image = res.data.image;
          }
          //errors here
        } else {
          //suuccess here
          this.$router.push({ name: "auth.users.listing" });
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
      first_name: "",
      last_name: "",
      email: "",
      password: null,
      role_id: "",
      roles: [],
      image: undefined,
      image_url: "",
      id: 0,
      errors: {
        first_name: [],
        last_name: [],
        email: [],
        password: [],
        role_id: [],
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
          text: "User",
          to: { name: "auth.users.listing" },
          disabled: false,
          exact: true,
        },
        {
          text: "Add",
          to: {
            name: "auth.users.edit",
            params: { id: this.$route.params.id },
          },
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
