<template>
    <div class="container">
        <form @submit.prevent="register">
            <h2 class="mb-3">Register</h2>
            <div class="input">
                <label for="email">Name</label>
                <input  v-model="formData.name" placeholder="Name" class="form_control" />
            </div>
            <div class="input">
                <label for="email">Email address</label>
                <input  v-model="formData.email" placeholder="Email address" class="form_control" />
            </div>
            <div class="input">
                <label for="email">Password</label>
                <input  v-model="formData.password" placeholder="Password" class="form_control" />
            </div>
            <div class="input">
                <label for="password">Confirm Password</label>
                <input v-model="formData.password_confirmation" placeholder="Confirm Password" class="form_control"  />

            </div>
            <button type="submit" class="auth_button" id="register_button">
                Register
            </button>

            <div class="alternative-option">
                Already have an account? <span @click="login">Login</span>
            </div>
        </form>
    </div>
</template>

<script>

import router from "../router";

export default {
    name : 'Register',
    data() {
        return {
            formData : {
                name:"",
                email: "",
                password: "",
                password_confirmation:""
            }
        };
    },
    methods: {
        async register(e) {
            e.preventDefault();
            const response = await fetch("http://localhost/api/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    name: this.formData.email,
                    email: this.formData.email,
                    password: this.formData.password,
                    password_confirmation: this.formData.password,

                }),
            });

        },
        login() {
            router.push("/login");
        },
    },
};
</script>
