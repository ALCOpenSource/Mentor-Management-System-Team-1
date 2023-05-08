import {defineStore} from 'pinia'
import axios from "axios"

interface userState {
    avatar: Avatar | null;
    user: User | null;
}

interface Avatar {
    avatar_url: string
}

interface User {
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
    first_name: string;
    last_name: string;
    avatar_url: string;
    unread_messages_count: number;
    unread_notifications_count: number;
    member_since: string;
    social_links: Links | null;
    website: Site | null;
    flag: string;
    tags: array | null;

}

interface Links {
    github_username: Github | null;
    linkedin_username: Linkedin | null;
    twitter_username: Twitter | null;
    instagram_username: Instagram | null;
}

interface Github {
    name: string | null;
    url: string | null;
}

interface Linkedin {
    name: string | null;
    url: string | null;
}

interface Twitter {
    name: string | null;
    url: string | null;
}

interface Instagram {
    name: string | null;
    url: string | null;
}

interface Site {
    webiste: Website | null;
    my_website: Mywebite | null;
}

interface Website {
    name: string | null;
    url: string | null;
}

interface Mywebite {
    name: string | null;
    url: string | null;
}

export const useUserStore = defineStore({
    id: 'user',

    state: (): userState => {
        return {
            avatar: null,
            user: null,
        }
    },

    getters:{
        getAvatar: (state) => state.avatar,
        getUser: (state) => state.user,
    },

    actions: {
        async fetchAvatar() {
            const res = await axios.get('v1/user/avatar')
            this.avatar = res.data.data
        },

        async uploadAvatar(avatarData: avatarData) {
            await axios.post('v1/user/avatar', {
                avatar: avatarData.avatar,
              }).then(res=>{
              if(res.data.success) {
                  console.log(res.data.data)
                // this.authUser = res.data.data.user
                // this.toaster.success(res.data.message)
              }
            }).catch(error => {
                // this.toaster.error('Invalid username or password.')
            });
        },

        async fetchUser() {
            const res = await axios.get('v1/user')
            this.user = res.data.data
        },

        async updateUser(userData: userData) {
            await axios.post('v1/user/avatar', {
                name: userData.value.first_name +' '+ userData.value.last_name,
                email: userData.value.email,
                phone: userData.value.phone,
                country: userData.value.country,
                state: userData.value.state,
                city: userData.value.city,
                address: userData.value.address,
                zip_code: userData.value.zip_code,
                about_me: userData.value.about_me,
                webiste: userData.value.webiste,
                github_username: userData.value.github_username,
                linkedin_username: userData.value.linkedin_username,
                twitter_username: userData.value.twitter_username,
                instagram_username: userData.value.instagram_username,
                timezone: userData.value.instagram_username,
                tags: userData.value.tags
              }).then(res=>{
              if(res.data.success) {
                  //this.fetchUser();
                  console.log(res.data.data)
                // this.authUser = res.data.data.user
                // this.toaster.success(res.data.message)
              }
            }).catch(error => {
                // this.toaster.error('Invalid username or password.')
            });
        }
    }
})

interface userData {
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
    first_name: string;
    last_name: string;
    avatar_url: string;
    unread_messages_count: number;
    unread_notifications_count: number;
    member_since: string;
    social_links: Links | null;
    website: Site | null;
    flag: string;
    tags: array | null;
}

interface avatarData {
    avatar: string
}