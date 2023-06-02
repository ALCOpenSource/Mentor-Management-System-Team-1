<template>
  <div>
    <div class="flex justify-between items-center mb-12">
      <div class="flex items-center">
        <v-avatar size="80px">
          <v-img
            :src="
              userStore.avatar?.avatar_url ||
              'https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png'
            "
            alt="John"
          ></v-img>
        </v-avatar>
        <div class="ml-6">
          <div class="flex items-center">
            <h1 class="mr-2 text-xl 2xl:text-2xl font-semibold">
              {{ userStore.user?.name }}
            </h1>
            <NigerianFlag />
          </div>
          <p class="text-slate-500">{{ 
            userStore.user?.tags?.map((tag: any) => tag.name).join(", ")
          }}</p>
        </div>
      </div>
      <div>
        <router-link to="/admin/settings/general"
          ><PrimaryBtn title="Edit Profile"
        /></router-link>
      </div>
    </div>
    <div class="card p-6">
      <h1 class="text-xl 2xl:text-2xl font-semibold mb-6">About</h1>
      <p class="sub-card text-sm 2xl:text-base">
        {{ userStore.user?.about_me }}
      </p>
      <div class="flex items-center mb-3 gap-6">
        <h1 class="text-base 2xl:text-xl font-semibold">Location:</h1>
        <p class="text-[#808080] text-sm 2xl:text-base">
          {{ userStore.user?.state }}, {{ userStore.user?.country_name }}
        </p>
      </div>
      <div class="flex items-center mb-3 gap-6">
        <h1 class="text-base 2xl:text-xl font-semibold">Email:</h1>
        <p class="text-[#808080] text-sm 2xl:text-base">{{ userStore.user?.email }}</p>
      </div>
      <div class="flex items-center mb-3 gap-6">
        <h1 class="text-base 2xl:text-xl font-semibold">Website:</h1>
        <p class="text-[#808080] text-sm 2xl:text-base">
          {{ userStore.user?.website?.my_website?.url }}
        </p>
      </div>
      <div class="flex items-center gap-6">
        <h1 class="text-base 2xl:text-xl font-semibold">Member since:</h1>
        <p class="text-[#808080] text-sm 2xl:text-base">{{ userStore.user?.member_since }}</p>
      </div>
      <h1 class="text-xl 2xl:text-2xl font-semibold mb-6 mt-10">Social</h1>
      <div class="grid w-full gap-10 grid-cols-2 mb-6">
        <div class="flex items-center social-card">
          <GitHub />
          <p class="ml-3 text-base 2xl:text-xl">
            {{ userStore.user?.social_links?.github_username?.name }}
          </p>
        </div>
        <div class="flex items-center social-card">
          <Instagram />
          <p class="ml-3 text-base 2xl:text-xl">
            {{ userStore.user?.social_links?.instagram_username?.name }}
          </p>
        </div>
      </div>
      <div class="grid w-full gap-10 grid-cols-2">
        <div class="flex items-center social-card">
          <LinkedIn />
          <p class="ml-3 text-base 2xl:text-xl">
            {{ userStore.user?.social_links?.linkedin_username?.name }}
          </p>
        </div>
        <div class="flex items-center social-card">
          <Twitter />
          <p class="ml-3 text-base 2xl:text-xl">
            {{ userStore.user?.social_links?.twitter_username?.name }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { GitHub, Twitter, Instagram, LinkedIn } from "@/assets/icons";
import PrimaryBtn from "../../components/Buttons/PrimaryBtn.vue";
import { NigerianFlag } from "@/assets/icons";

import { useUserStore } from "../../store/user";

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
    padding: 8px 12px;

    &:hover {
      background-color: var(--card-light-hover);
      cursor: pointer;
    }
  }
}
</style>
