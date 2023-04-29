<template>
  <div>
    <div class="flex justify-between items-center mb-12">
      <div class="flex items-center">
        <v-avatar size="90px">
          <v-img
            :src="
              authStore.authUser?.avatar ||
              'https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png'
            "
            alt="John"
          ></v-img>
        </v-avatar>
        <div class="ml-6">
          <div class="flex items-center">
            <h1 class="mr-2 text-xl font-semibold">
              {{ authStore.authUser?.name }}
            </h1>
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
      <h1 class="text-2xl font-semibold mb-6">About</h1>
      <p class="sub-card">
        {{ authStore.authUser?.about_me }}
      </p>
      <div class="flex items-center mb-3 gap-6">
        <h1 class="text-xl font-semibold">Location:</h1>
        <p class="text-[#808080]">{{ authStore.authUser?.state }}, {{ authStore.authUser?.country }}</p>
      </div>
      <div class="flex items-center mb-3 gap-6">
        <h1 class="text-xl font-semibold">Email:</h1>
        <p class="text-[#808080]">{{ authStore.authUser?.email }}</p>
      </div>
      <div class="flex items-center mb-3 gap-6">
        <h1 class="text-xl font-semibold">Website:</h1>
        <p class="text-[#808080]">
          {{ authStore.authUser?.website }}
        </p>
      </div>
      <div class="flex items-center gap-6">
        <h1 class="text-xl font-semibold">Member since:</h1>
        <p class="text-[#808080]">{{ authStore.authUser?.member_since }}</p>
      </div>
      <h1 class="text-2xl font-semibold mb-6 mt-10">Social</h1>
      <div class="grid w-full gap-10 grid-cols-2 mb-6">
        <div class="flex items-center social-card">
          <GitHub />
          <p class="ml-3">@peculiar.umeh</p>
        </div>
        <div class="flex items-center social-card">
          <Instagram />
          <p class="ml-3">@peculiar.umeh</p>
        </div>
      </div>
      <div class="grid w-full gap-10 grid-cols-2">
        <div class="flex items-center social-card">
          <LinkedIn />
          <p class="ml-3">@peculiar.umeh</p>
        </div>
        <div class="flex items-center social-card">
          <Twitter />
          <p class="ml-3">@peculiar.umeh</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { GitHub, Twitter, Instagram, LinkedIn } from "@/assets/icons";
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";

import { useAuthStore } from "../../store/auth";

const authStore = useAuthStore();
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
