<template>
  <div class="flex gap-7">
    <div class="flex flex-col w-[309px] gap-5">
      <div class="flex justify-between items-center">
        <h1 class="font-semibold text-2xl">Mentors</h1>
        <div class="flex items-center gap-5">
          <IconSearch color="#058B94" size="20" class="cursor-pointer" />
          <Filter class="cursor-pointer" />
        </div>
      </div>
      <div class="mentor-cards">
        <MentorCard v-for="item in 10" :key="item" />
      </div>
    </div>
    <div class="h-[77vh] w-full flex flex-col overflow-hidden">
      <Header />
      <div class="h-full flex flex-col">
        <div class="border-b border-[#ccc]">
          <v-tabs v-model="tab" color="#058b94" align-tabs="center" fixed-tabs>
            <v-tab :value="1">About</v-tab>
            <v-tab :value="2">Programs</v-tab>
            <v-tab :value="3">Tasks</v-tab>
            <v-tab :value="4">Certificates</v-tab>
          </v-tabs>
        </div>
        <div class="mt-3">
          <v-window v-model="tab">
            <v-window-item :value="1">
              <About />
            </v-window-item>
            <v-window-item :value="2">
              <Programs />
            </v-window-item>
            <v-window-item :value="3">
              <Tasks />
            </v-window-item>
            <v-window-item :value="4">
              <Certificates />
            </v-window-item>
          </v-window>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IconSearch, Filter } from "@/assets/icons";
import { MentorCard, About, Programs, Header, Tasks, Certificates } from "@/components/Mentors";

const tab = ref(null);
</script>

<style scoped lang="scss">
.mentor-cards {
  min-width: 317px;
  height: 70vh;
  overflow-y: scroll;
  padding-right: 5px;

  &::-webkit-scrollbar {
    width: 5px;
    transition: all 0.5s ease-in-out;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: #06B9C6;
    border-radius: 50px;
  }
}
</style>
