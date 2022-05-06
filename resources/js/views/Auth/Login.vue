<template>
    <div>
        <body class="hold-transition login-page">
            <div class="login-box">
                <div class="login-logo">
                    <!-- <a href="../../index2.html"><b>Login</b>HERE</a> -->
                    <img src="https://www.afterworkusa.com/images/logo/logo3.png" height="100px" alt="">
                </div>
                <!-- /.login-logo -->
                <div class="card">
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
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
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
