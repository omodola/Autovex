<template>
    <div class="container">
        <form @submit.prevent="login">
            <h2 >Login</h2>
            <div class="input">
                <label for="email">Email address</label>
                <input  v-model="formData.email" placeholder="Email address" class="form_control" />
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input v-model="formData.password" placeholder="Password" class="form_control"  />

            </div>
            <button type="submit" class="auth_button" id="login_button">
                Login
            </button>

            <div class="alternative-option">
                You don't have an account? <span @click="register">Register</span>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import router from "../router";
import { mapMutations } from "vuex";

export default {

    name: 'Login',

    data() {
        return {
            formData : {
                email: "",
                password: "",
            }
        };
    },

    methods: {
        ...mapMutations([ "setToken"]),

        login() {
            const body = JSON.stringify({
                                 email: this.formData.email,
                                 password: this.formData.password,
                             });

            const headers = {
                "Content-Type": "application/json",
                "Accept": "application/json",
            };

            axios.post("http://localhost/api/login", body, { headers })
                .then((response) => {
                    if(response.status == '200'){
                       this.setToken(response.data.data.api_token)
                        router.push("/");
                    }
                })
        },

        register() {

            router.push("/register");
        },
    },
};
</script>

