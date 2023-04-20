import {defineStore} from 'pinia'
import axios from "axios"
import { createToaster } from "@meforma/vue-toaster";

export const useAuthStore = defineStore({
    id: 'auth',

    state: () => ({
        authUser: null,
        token: localStorage.getItem('token') || 0,
    }),

    getters:{
        user: (state) => state.authUser,

        getToken: (state) => state.token
    },

    actions: {
        setToken: function (token) {
            this.token = token
            localStorage.setItem('token', token)
        },

        removeToken: function() {
            this.token = 0
            localStorage.removeItem('token')
        },

        async getUser () {
            const data = await axios.get('api/auth/user')
            this.authUser = data.data
        },

        async handleLogin (loginData) {
            const toaster = createToaster({ 
                position: "top-right",
            });
            await axios.post('api/auth/login', {
                email: loginData.value.email,
                password: loginData.value.password,
              }).then(res=>{
              if(res.data.success) {
                this.setToken(res.data.data.access_token)
                this.router.push("admin/dashboard")
                toaster.success(res.data.message)
              }
            }).catch(error => {
                toaster.error('Invalid username or password.')
            });
        }
    }
})