require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import CKEditor from "@ckeditor/ckeditor5-vue2";
import { store } from "./store";
import router from "./routes";
import Toaster from 'v-toaster';
import 'v-toaster/dist/v-toaster.css';
window.Vue = require("vue").default;
import loginservice from "@services/auth/login";
Vue.use(Toaster, {timeout: 5000})
Vue.use(VueRouter);
Vue.use(CKEditor);

import left_nav from "@/components/sidebars/left_nav.vue";
import topbar from "@/components/sidebars/topbar.vue";

router.beforeEach(async (to, from, next) => {
    if (to.meta.guest || to.meta.layout == 'Front') {
        next();
    } else {
        var isAuthenticated = localStorage.getItem("auth_token") ? true : false;
        if (to.meta.layout == "Admin" && to.name !== "auth.login" && !isAuthenticated)
            next({ name: "auth.login" });
        else if (to.meta.layout == "Admin" && to.name === "auth.login" && isAuthenticated)
            next({ name: "index" });
        else next();
    }
});

new Vue({
    router,
    store,
    async created() {
        var token = localStorage.getItem("auth_token")
            ? localStorage.getItem("auth_token")
            : "";
        if (token) {
            this.$store.commit("setAuthToken", token);
            this.$store.commit("setLoginStatus", true);
            var user = await loginservice.me();
            this.$store.commit("setloggedInUser", user);
            if (user.permissions.length > 0) {
                let permissions = user.permissions.map((e) => {
                    return e.permission_id;
                });
                this.$store.commit("setPermissions", permissions);
            }
            //redirecting to user dashboard
        }
    },
    // components: {
    //     left_nav,
    //     topbar,
    // },
    data() {
        return {};
    },
    computed: {
        sideBarStatus() {
            return this.$store.getters.sideBarStatus;
        },
        notificaitontext() {
            return this.$store.getters.notificationText;
        },
        notificaitonstatus() {
            return this.$store.getters.notificationStatus;
        },
    },
    watch: {
        $route() {
            if (this.$route.meta.showsidebar) {
                this.$store.commit("setSideBarStatus", true);
            } else {
                this.$store.commit("setSideBarStatus", false);
            }
        },
    },
}).$mount("#app");
