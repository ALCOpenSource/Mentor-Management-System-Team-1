import { defineStore } from "pinia";
import axios from "axios";

interface userState {
    avatar: Avatar | null;
    user: User | null;
    users: Object | null;
    pagination: Object | null;
}

interface Avatar {
  avatar_url: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  avatar: string;
  city: string;
  state: string;
  country_name: string;
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
  tags: [] | null;
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
  id: "user",

    state: (): userState => {
        return {
            avatar: null,
            user: null,
            users: null,
            pagination: null,
        }
    },

    getters:{
        getAvatar: (state) => state.avatar,
        getUser: (state) => state.user,
        getUsers: (state) => state.users,
    },

    actions: {
        async fetchAvatar() {
            const res = await axios.get('v1/user/avatar')
            this.avatar = res.data.data
        },

        async uploadAvatar(avatarFile: File) {
            const formData = new FormData();
            formData.append('avatar', avatarFile);

            await axios.post('v1/user/avatar', formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            }).then(res=>{
              if(res.data.success) {
                this.avatar = res.data.data
                this.toaster.success('Profile photo updated successfully')
              }
            }).catch(error => {
                this.toaster.error('Unable to update profile photo')
            });
        },

        async fetchUser() {
            const res = await axios.get('v1/user')
            this.user = res.data.data
        },

        async fetchUsers() {
            const res = await axios.get('v1/user/all')
            this.users = res.data.data
            this.pagination = res.data.pagination
        },

        async updateUser(userData: userData) {
          
            try {
              const response = await axios.patch('v1/user', {
                name: userData.value.firstName + ' ' + userData.value.lastName,
                country: userData.value.country,
                city: userData.value.city,
                about_me: userData.value.about,
                website: userData.value.website,
                github_username: userData.value.github,
                linkedin_username: userData.value.linkedin,
                twitter_username: userData.value.twitter,
                instagram_username: userData.value.instagram,
              });
              if (response.data.success) {
                this.user = response.data.data;
              }
              
              return response;
            } catch (error: any) {
              this.toaster.error(error.response.data.message);
              return error.response;
            }
        }
    },
});

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
  tags: [] | null;
}
