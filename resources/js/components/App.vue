<template>
    <div id="app" class="app" v-cloak>
        <router-link to="/">Dashboard</router-link>
        <router-link to="/login">Login</router-link>
        <router-view  />

    </div>

</template>

<script>

export default {
    name: 'AppVue',
}

</script>

<style>

.container {
    width: 400px;
    max-width: 95%;
    margin-right: auto;
    margin-left: auto;
    padding: 48px 70px 56px;
    margin-top: 8%;
}

.input {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.input > label {
    text-align: start;
}
.input > input {
    margin-top: 6px;
    height: 38px !important;
}

.form_control{
    padding: 5px;

}

.auth_button {
    position: relative;
    left: 50%;
    padding: 1em 2.5em;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    font-weight: 700;
    color: #ffffff;
    border: none;
    background-color:   #0b6dff;
    border-radius: 45px;
    transition: all 0.3s ease 0s;
    cursor: pointer;
    outline: none;
    transform: translateX(-50%);
    margin-bottom: 10px;
}
.auth_button:hover {
    background-color: #fff;
    box-shadow: 0px 15px 20px rgb(0, 92, 230);
    color: #000000;
    transform: translate(-50%, -7px);
}
.auth_button:active {
    transform: translate(-50%, -1px);
}

.alternative-option {
    margin-top: 10px;
    text-align: center;
}
.alternative-option > span {
    color: #0d6efd;
    cursor: pointer;
}

</style>

