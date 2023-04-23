import {defineStore} from 'pinia'
import axios from "axios"

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

        async handleSocialLogin () {
            console.log('yes!')
            await axios.get('auth/social/redirect/google')
        },

        async handleLogin (loginData) {
            await axios.post('api/auth/login', {
                email: loginData.value.email,
                password: loginData.value.password,
              }).then(res=>{
              if(res.data.success) {
                this.setToken(res.data.data.access_token)
                this.router.push("admin/dashboard")
                this.toaster.success(res.data.message)
              }
            }).catch(error => {
                this.toaster.error('Invalid username or password.')
            });
        }
    }
})
