<template>
  <div>
    <div class="card">
      <div
        class="flex items-center justify-between py-[10px] px-[20px] hover:bg-green-100"
      >
        <div class="flex items-center">
          <UserAvatar v-if="user" :image-link="imgUrl" />
          <img v-if="smallUrl" :src="smallUrl" alt="John" />
          <div class="ml-5">
            <h1
              v-if="isMentorCert"
              class="font-semibold text-xl text-[#333333] uppercase"
            >
              {{ title }}
            </h1>
            <div v-if="generalCert">
              <h1 class="font-semibold text-base text-[#333333]">
                Allison Davies
              </h1>
              <h1 class="font-semibold text-base text-[#333333] uppercase">
                GADS CLOUD 2022 - COMPLETION
              </h1>
            </div>
            <div v-if="approval" class="flex flex-wrap items-center">
              <div class="flex flex-col mr-8">
                <h1
                  class="text-xl font-semibold cursor-pointer hover:underline transition-all"
                >
                  Allison Davies
                </h1>
                <small class="text-[#808080]"
                  >Program Assistant, Andela, She/her</small
                >
              </div>
              <div class="flex items-center gap-3">
                <div class="text-xs bg-[#E6FDFE] rounded py-1 px-3">
                  PROGRAM ASST.
                </div>
                <div class="text-xs bg-[#E6FDFE] rounded py-1 px-3">
                  MENTOR-GADS
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex gap-5 items-center">
          <v-icon
            v-if="!showDetails?.show || showDetails?.index !== index"
            @click="toggleShowDetails(index)"
          >
            <IconArrowDown class="cursor-pointer" />
          </v-icon>
          <v-icon v-else @click="toggleShowDetails(index)">
            <IconArrowUp class="cursor-pointer" />
          </v-icon>
        </div>
      </div>
      <v-expand-transition>
        <div
          v-if="showDetails?.show && showDetails?.index === index"
          class="bg-green-100 py-[10px] px-[20px]"
        >
          <slot></slot>
        </div>
      </v-expand-transition>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import UserAvatar from "./UserAvatar.vue";
import { IconArrowUp, IconArrowDown } from "@/assets/icons";

defineProps<Props>();

const showDetails = ref<ShowDetails>();

const toggleShowDetails = (index: number) => {
  if (showDetails.value?.show && showDetails.value?.index === index) {
    showDetails.value = { show: false, index: -1 };
  } else {
    showDetails.value = { show: true, index };
  }
};

interface ShowDetails {
  index: number;
  show: boolean;
}

interface Props {
  index: number;
  imgUrl?: string;
  user?: boolean;
  smallUrl?: string;
  isMentorCert?: boolean;
  generalCert?: boolean;
  title?: string;
  approval?: boolean;
}
</script>

<style scoped lang="scss">
.card {
  display: flex;
  flex-direction: column;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
}
</style>
