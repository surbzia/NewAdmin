<template>
  <div>
    <breadcumbs :data="{ step1: 'Users', step2: 'Add' }"></breadcumbs>
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
                <img
                  src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png"
                  height="86px"
                  class="responsive"
                  alt=""
                />
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
  mounted() {
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
      this.btnloading = true;
      var formdata = new FormData();
      formdata.append("first_name", this.first_name);
      formdata.append("last_name", this.last_name);

      formdata.append("email", this.email);
      formdata.append("password", this.password);
      formdata.append("role_id", this.role_id);
      if (this.image) {
        formdata.append("image", this.image);
      }
      this.btnloading = false;
      var res = await userervice.create(formdata);
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
            this.$toaster.success("User has been added successfully.");
        setTimeout(
          () => this.$router.push({ name: "auth.users.listing" }),
          3000
        );
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
      image: undefined,
      roles: [],
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
          to: { name: "auth.users.add" },
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
