<template>

    <div class="flex_container">
        <div class="dashboard_auth_button">

            <button v-if="isLoggedIn"  type="submit"  id="dashboard_button" @click="logout">
                Logout
            </button>
            <button v-else  type="submit"  id="dashboard_button"  @click="login">
                Login
            </button>

        </div>

    </div>

    <div class="clock">
        <div class="center_div">
            <div   v-if="isLoggedIn"  class="edit_time" >
                <button @click="open = true" class="edit_time_button">Edit Time</button>
            </div>

            <div>
                <span class="hours"> {{ dateTime.hours }} </span>
                :<span class="minutes"> {{ dateTime.minutes }} </span>
                :<span class="seconds"> {{ dateTime.seconds }} </span>

            </div>

        </div>

        <Teleport  v-if="authenticated"   to="body">
            <div v-if="open" class="modal" style="">
                <div class="dash">
                    <vue-timepicker  :format="timeFormat" v-model="dateTime"></vue-timepicker>
                    <button @click="updateDateTime" class="edit_time_save">Save</button>
                </div>

            </div>
        </Teleport>
    </div>
</template>

<script>
import VueTimePicker from "vue3-timepicker"
import "vue3-timepicker/dist/VueTimepicker.css";
import router from "../router";
import axios from "axios";
import moment from "moment";
import { mapGetters } from "vuex";


var customDate = '01-01-1970 00:03:44';
const date = new Date(customDate);
export default {
    name: "Dashboard",
    computed: {
        ...mapGetters({
        isLoggedIn: 'isLoggedIn',
    })},

    data() {
        return {
            dateTime: {
                hours: date.getHours(),
                minutes: date.getMinutes(),
                seconds: date.getSeconds(),
            },
            timeFormat: "hh:mm:ss a",
            timer: undefined,
            modal:false,
            authenticated:localStorage.getItem('token'),
        };
    },
    methods: {

        setAuthenticated(status){
            this.isLoggedIn = status
        },
        logout(){

        },
        setDateTime() {
            const date = new Date();
            this.dateTime = {
                hours: date.getHours(),
                minutes: date.getMinutes(),
                seconds: date.getSeconds(),
            };
        },

        updateDateTime(){
            axios.get('http://localhost/api/clock', this.email)
                .then((response) => {
                    const time = moment().format('h:mm:ss a');
                    this.dateTime = time

                })
                .then((
                    response=>
                    console.log(response)
                ))
                .catch(error => console.log(error))
        },

        clickMethod(){
            alert('im clicked');
        },
        modalAction(){

            if( this.modal === false){
                this.modal = true
            }else {
                this.modal = false

            }
        },
        login() {
            router.push("/login");
        },

    },
    beforeMount() {
        this.timer = setInterval(this.setDateTime, 1000);
    },
    beforeUnmount() {
        clearInterval(this.timer);
    },
    components:{
        "vue-timepicker" : VueTimePicker
    },

};
</script>

<style>

.clock {
    height: 100vh;
    width: 100%;
    color:  #0b6dff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 150px;

}

@media only screen and (max-width: 600px) {
    .clock {
        font-size: 80px;

    }
}

.dash{
    border: 1px solid #0b6dff;
    max-width: 400px;
    text-align: center;
    margin: 0 auto;
    margin-bottom: 20px;
    padding: 15px;
    color: #fff;
}

.dashboard_edit_modal{
    position: fixed;
    z-index: 999;
    top: 20%;
    left: 50%;
}

.modal {
    position: fixed;
    z-index: 999;
    top: 20%;
    left: 50%;
    width: 300px;
    margin-left: -150px;
    background: white;
}

.center_div {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    min-height: 100vh;
}

.edit_time{
    position: absolute;
    top: 120px;
}

.edit_time_button{
    background-color:  #0b6dff;
    color: white;
    border: none;
    height: 45px;
}

.edit_time button{
    padding: 16px;
    font-size: 14px;

}

#dashboard_button{
    top: 30px;
    right: 30px;
    /*position: absolute;*/
    padding: 10px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    font-weight: 700;
    border: none;
    background-color:  #0b6dff;
    border-radius: 10px;
    cursor: pointer;
    outline: none;
    transform: translateX(-50%);
    color: white;

}

.dropbtn{
    top: 30px;
    right: 30px;
    position: absolute;
}

.vue__time-picker {
    margin-bottom: 10px;
}

.edit_time_save{
    display: flex;
    margin-left: 99px;
}

.flex_container{
    display: flex;
    float: right;
}



</style>
