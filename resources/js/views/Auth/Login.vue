<template>
  <div>
    <body class="hold-transition login-page parent">
      <div class="login-box card">
        <div class="login-logo">
          <img
            src="data:image/jpeg;base64,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9rV3rnyZZ/lfn6ho/OW1ERFqLqoiIiIiIiIiIiItHCeDYMzDMONDbEbtiu2077SMrTxhbyIoIBFCo1wpqauBLpWKC3NxcjhyOaKHoC8CJiVhBpyyxPG18JwPQ5TSi2WzUQd650S5Uu81FRsNoPCihUYn4Q4O/rN71cMUJ/gz+s3vU0IrY4/QFi9TQdZ28WKGRijP8Hf1m96vGKU/wd/WZ3qY0U46/QFX1JB13bxYofGKc9wd/WZ3q9uKc7wc9YKXUU48/QONqqbhQD8bt4sUTNxVnODnrNWRuKs5mD1gpVRTj79A42qp9H4B+N28faovbivN5j3gsrcWZvMnrNUloresYmgcbVjPo5Ln4372/ao5bi3NZk9Zqytxdmc17zVIKJ6yiaBxtVf0xLa797ftXBNxfmM17zVeMAzGaPWau6RVN0ImgcbVX9Lyuu/e37VxH9BR80es3vVP6DmM17zV3CJj8TQONqj9Kymu/ePtXDHAMfNHrNVhwBMZr3mrvET1hE0DjapHotK6797ftUfuxdmc17zVjdi3M5n3mqREVvWUXQONqkejEsPjfvb9qjV2LM1mfeCxOxXm8wesFJ6J6xiaBxtVx6Ny4+N+9v2qK3YrTmYPWCxuxVnODnrNUsIq4+/QONquPR6XHxu3j7VEZxUneDnrBYzinO8Hd1m96mBFGPP0Djari4UAfG7eLFDhxSnuDv6ze9WnFGf4M/rN71MqKMdfoCt6kg67t4sULnFCf4O/rN71T+p8+f8Ap39Zg+amlFGOP0BW9TQdZ28WKJZLU9nIhF5Yl27tp7XupxBlQekLtcXsTpWTIeBfRhlvXgUad9jNpvLlPGulRYnx3vFCfzmtuBIQIJq0VOk5f9bgiIiwrcREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREX/2Q=="
            height="100px"
            alt=""
          />
        </div>
        <!-- /.login-logo -->
        <div class="">
          <div class="card-body login-card-body">
            <form ref="form" lazy-validation>
              <div class="input-group mb-3">
                <input
                  type="email"
                  v-model="loggedinemail"
                  class="form-control"
                  placeholder="Email"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input
                  type="password"
                  v-model="loggedinpassword"
                  class="form-control"
                  placeholder="Password"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember" />
                    <label for="remember"> Remember Me </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">

                </div>
                <div class="col-md-12">
                     <button
                    type="button"
                    @click="dologin"
                    class="btn btn-primary btn-block text-white"
                  >
                    Sign In
                  </button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
          <!-- /.login-card-body -->
        </div>
      </div>
    </body>
  </div>
</template>

<script>
import loginservice from "@services/auth/login";
export default {
  name: "Login",
  components: {},
  mounted() {
    this.$nextTick(function () {
      // this.$store.commit("setAppCls", "login-screen-main");
    });
  },
  data() {
    return {
      loader: null,
      loading: false,
      btnloading: false,
      snackbar: false,
      loggedinemail: "",
      loggedinpassword: "",
      show3: false,
      password: "Password",
      erorrs: {
        email: "",
        password: "",
      },
      rules: {
        required: (value) => !!value || "Required.",
        email: (value) => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Invalid e-mail.";
        },
      },
    };
  },
  methods: {
    dologin: async function () {
      // if (this.$refs.form.validate()) {
      this.btnloading = true;
      var logindetail = await loginservice.dologin(
        this.loggedinemail,
        this.loggedinpassword
      );
      this.btnloading = false;
      if (logindetail.data) {
        if (logindetail.status) {
          this.$toaster.success("You have login successfully.");
          this.$store.commit("setLoginStatus", true);
          this.$store.commit("setAuthToken", logindetail.data);
          var user = await loginservice.me();
          this.$store.commit("setloggedInUser", user);
          if (user.permissions.length > 0) {
            let permissions = user.permissions.map((e) => {
              return e.permission_id;
            });
            this.$store.commit("setPermissions", permissions);
          }
          this.$router.push({ name: "auth.dashboard" });
          // $route.push('auth.dashboard')
        } else {
          this.erorrs.email = logindetail.data;
          this.snackbar = true;
        }
      }
    },
  },
  watch: {},
};
</script>
