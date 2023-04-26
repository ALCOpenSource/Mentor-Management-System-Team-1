import {defineStore} from 'pinia'
import axios from "axios"

interface AuthState {
    authUser: AuthUser | null;
    token: string | number;
}

export const useAuthStore = defineStore({
    id: 'auth',

    state: (): AuthState => {
        return {
            authUser: null,
            token: localStorage.getItem('token') || 0,
        }
    },

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
            const res = await axios.get('auth/user')
            this.authUser = res.data.data.user
        },

        async socialLoginRedirect () {
            await axios.get('auth/social/redirect/google').then(res => {
                if(res.data.success) {
                    window.location.href = res.data.data.url
                }
            })
        },

        async handleSocialLogin(token) {
            await this.setToken(token);
            location.reload();
            this.toaster.success("User successfully logged in");
        },

        async handleLogin (loginData) {
            await axios.post('auth/login', {
                email: loginData.value.email,
                password: loginData.value.password,
              }).then(res=>{
              if(res.data.success) {
                this.setToken(res.data.data.access_token)
                this.authUser = res.data.data.user
                this.router.push("admin/dashboard")
                this.toaster.success(res.data.message)
              }
            }).catch(error => {
                this.toaster.error('Invalid username or password.')
            });
        }
    }
})

interface AuthUser {
    id: number;
    name: string;
    email: string;
    avatar: string;
    city: string;
    state: string;
    country: string;
    zip_code: string;
    address: string;
    phone: number;
    timezone: string;
    about_me: string;
}