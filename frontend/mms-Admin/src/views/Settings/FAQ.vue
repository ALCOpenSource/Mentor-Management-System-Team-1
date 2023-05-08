<template>
  <div>
    <h1 class="text-xl font-semibold mb-5">General FAQ</h1>
    <v-expansion-panels multiple v-model="expanded1">
      <v-expansion-panel v-for="item in faqStore.faq?.general" :key="item">
        <v-expansion-panel-title>
          <IconCircleAdd v-if="!expanded1.includes(item - 1)" />
          <IconCircleMinus v-else />
          <p class="font-semibold ml-6">{{ item.question }}</p>
        </v-expansion-panel-title>
        <v-expansion-panel-text> {{ item.answer }} </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>
    <h1 class="text-xl font-semibold my-5">Technical FAQ</h1>
    <v-expansion-panels multiple v-model="expanded2">
      <v-expansion-panel v-for="item in faqStore.faq?.technical" :key="item">
        <v-expansion-panel-title>
          <IconCircleAdd v-if="!expanded2.includes(item - 1)" />
          <IconCircleMinus v-else />
          <p class="font-semibold ml-6">{{ item.question }}</p>
        </v-expansion-panel-title>
        <v-expansion-panel-text> {{ item.answer }} </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>

    <!-- <v-expansion-panel>
        <v-expansion-panel-title>
          <template v-slot:actions="{ expanded }">
            <v-icon><GitHub /></v-icon>
          </template>
          <h1>Heelo</h1>
          <p class="mx-4">djjd</p>
        </v-expansion-panel-title>
        <v-expansion-panel-text>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
          minim veniam, quis nostrud exercitation ullamco laboris nisi ut
          aliquip ex ea commodo consequat.
        </v-expansion-panel-text>
      </v-expansion-panel> -->
  </div>
</template>

<script setup lang="ts">
import { ref, defineComponent } from "vue";
import {useFaqStore} from "../../store/faq"
import { IconCircleAdd, IconCircleMinus } from "@/assets/icons";

const expanded1 = ref<Number[]>([]);
const expanded2 = ref<Number[]>([]);
const faqStore = useFaqStore();
</script>

<script lang="ts">

export default defineComponent({
  
  beforeRouteEnter(to, from, next) {
    const faqStore = useFaqStore();
    if (faqStore.faq) {
      // The authentication state is already loaded, so proceed to the dashboard
      next()
    } else {
      // The authentication state is not loaded yet, so wait for it before proceeding
      faqStore.setFaq().then(() => {
        next()
      })
    }
  },
})
</script>

<style scoped></style>
