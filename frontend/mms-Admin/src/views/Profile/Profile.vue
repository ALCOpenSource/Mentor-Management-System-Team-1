<template>
  <div>
    <div class="flex justify-between items-center mb-12">
      <div class="flex items-center">
        <v-avatar size="90px">
          <v-img
            :src="userStore.avatar?.avatar_url"
            alt="John"
          ></v-img>
        </v-avatar>
        <div class="ml-6">
          <div class="flex items-center">
            <h1 class="mr-2 text-xl font-semibold">{{ userStore.user?.name }}</h1>
            <svg
              width="30"
              height="30"
              viewBox="0 0 30 30"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <g clip-path="url(#clip0_7931_4687)">
                <path
                  d="M3.33333 4.16699C2.44928 4.16699 1.60143 4.51818 0.976311 5.1433C0.35119 5.76842 0 6.61627 0 7.50033L0 22.5003C0 23.3844 0.35119 24.2322 0.976311 24.8573C1.60143 25.4825 2.44928 25.8337 3.33333 25.8337H10V4.16699H3.33333Z"
                  fill="#009A49"
                />
                <path d="M10 4.16699H20V25.8337H10V4.16699Z" fill="#EEEEEE" />
                <path
                  d="M26.6667 4.16699H20V25.8337H26.6667C27.5507 25.8337 28.3986 25.4825 29.0237 24.8573C29.6488 24.2322 30 23.3844 30 22.5003V7.50033C30 6.61627 29.6488 5.76842 29.0237 5.1433C28.3986 4.51818 27.5507 4.16699 26.6667 4.16699V4.16699Z"
                  fill="#009A49"
                />
              </g>
              <defs>
                <clipPath id="clip0_7931_4687">
                  <rect width="30" height="30" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </div>
          <p class="text-slate-500">Admin</p>
        </div>
      </div>
      <div>
        <router-link to="/admin/settings/general"
          ><PrimaryBtn title="Edit Profile"
        /></router-link>
      </div>
    </div>
    <div class="card p-6">
      <h1 class="text-xl font-semibold mb-6">About</h1>
      <p class="sub-card">
        {{ userStore.user?.about_me }}
      </p>
      <div class="grid w-2/4 grid-cols-2 mb-6">
        <div class="flex items-center cursor-pointer">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M25 6.25H5C4.30964 6.25 3.75 6.80964 3.75 7.5V22.5C3.75 23.1904 4.30964 23.75 5 23.75H25C25.6904 23.75 26.25 23.1904 26.25 22.5V7.5C26.25 6.80964 25.6904 6.25 25 6.25Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M25 6.875L15 16.25L5 6.875"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">{{ userStore.user?.email }}</p>
        </div>
        <div class="flex items-center">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M7.54049 19.1091L15 27.5L22.4595 19.1091C28.1807 12.6735 23.6116 2.5 15 2.5C6.38835 2.5 1.81923 12.6735 7.54049 19.1091Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M15 16.25C17.0711 16.25 18.75 14.5711 18.75 12.5C18.75 10.4289 17.0711 8.75 15 8.75C12.9289 8.75 11.25 10.4289 11.25 12.5C11.25 14.5711 12.9289 16.25 15 16.25Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">{{ userStore.user?.state }}, {{ userStore.user?.country }}</p>
        </div>
      </div>
      <div class="grid w-2/4 grid-cols-2">
        <div class="flex items-center cursor-pointer">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M3.75 15H27.5"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M15 2.75195C18.093 5.9083 20 10.2312 20 14.9995C20 19.7677 18.093 24.0906 15 27.2468"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M15 2.75195C11.907 5.9083 10 10.2312 10 14.9995C10 19.7677 11.907 24.0906 15 27.2468"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">{{ userStore.user?.website }}</p>
        </div>
        <div class="flex items-center">
          <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M3.75 7.5C3.75 6.11929 4.86929 5 6.25 5H23.75C25.1307 5 26.25 6.11929 26.25 7.5V25C26.25 26.3807 25.1307 27.5 23.75 27.5H6.25C4.86929 27.5 3.75 26.3807 3.75 25V7.5Z"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M3.75 12.5H26.25"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M20 2.5V7.5"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M10 2.5V7.5"
              stroke="#058B94"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <p class="ml-1 text-slate-500">Member since {{ userStore.user?.member_since }}</p>
        </div>
      </div>
      <h1 class="text-xl font-semibold mb-6 mt-10">Social</h1>
      <div class="grid w-2/4 gap-16 grid-cols-2 mb-6">
        <div class="flex items-center social-card">
          <GitHub />
          <p class="ml-3">{{ userStore.user?.social_links?.github_username.name }}</p>
        </div>
        <div class="flex items-center social-card">
          <Instagram />
          <p class="ml-3">{{ userStore.user?.social_links?.instagram_username.name }}</p>
        </div>
      </div>
      <div class="grid w-2/4 gap-16 grid-cols-2">
        <div class="flex items-center social-card">
          <LinkedIn />
          <p class="ml-3">{{ userStore.user?.social_links?.linkedin_username.name }}</p>
        </div>
        <div class="flex items-center social-card">
          <Twitter />
          <p class="ml-3">{{ userStore.user?.social_links.twitter_username.name }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { GitHub, Twitter, Instagram, LinkedIn } from "@/assets/icons";
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";

import {useUserStore} from "../../store/user"

const userStore = useUserStore();
</script>

<style scoped lang="scss">
.card {
  border: 1.7px solid var(--border);
  border-radius: 10px;
  box-shadow: 0px 5px 5px rgba(241, 241, 241, 0.25);
  margin-bottom: 3rem;

  .sub-card {
    padding: 14px;
    border: 1px solid var(--card-light);
    background-color: var(--light-grid-background);
    color: #4d4d4d;
    margin-bottom: 2.5rem;
  }

  .social-card {
    color: #4d4d4d;
    font-weight: 600;
    border-radius: 5px;
    background-color: var(--card-light);
    font-size: 20px;
    padding: 8px 12px;

    &:hover {
      background-color: var(--card-light-hover);
      cursor: pointer;
    }
  }
}
</style>
