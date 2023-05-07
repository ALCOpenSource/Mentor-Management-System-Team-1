<template>
  <div>
    <div v-if="generalFaqs?.length">
      <h1 class="text-xl font-semibold mb-5">General FAQ</h1>
      <v-expansion-panels multiple v-model="expanded1">
        <v-expansion-panel v-for="(item, index) in generalFaqs" :key="item?.id">
          <v-expansion-panel-title>
            <IconCircleAdd v-if="!expanded1.includes(index)" />
            <IconCircleMinus v-else />
            <p class="font-semibold ml-6">{{ item.question }}</p>
          </v-expansion-panel-title>
          <v-expansion-panel-text> {{ item.answer }} </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
    <div v-if="technicalFaqs?.length">
      <h1 class="text-xl font-semibold my-5">Technical FAQ</h1>
      <v-expansion-panels multiple v-model="expanded2">
        <v-expansion-panel
          v-for="(item, index) in technicalFaqs"
          :key="item?.id"
        >
          <v-expansion-panel-title>
            <IconCircleAdd v-if="!expanded2.includes(index)" />
            <IconCircleMinus v-else />
            <p class="font-semibold ml-6">{{ item.question }}</p>
          </v-expansion-panel-title>
          <v-expansion-panel-text> {{ item.answer }} </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IconCircleAdd, IconCircleMinus } from "@/assets/icons";
import { useFaqStore } from "@/store/settings/faq";
import { storeToRefs } from "pinia";

interface FaqProp {
  id?: number;
  question: string;
  answer: string;
  category: string;
}

const { fetchFaqs } = useFaqStore();

fetchFaqs();
const { generalFaqs, technicalFaqs } = storeToRefs(useFaqStore());

const expanded1 = ref<Number[]>([]);
const expanded2 = ref<Number[]>([]);
</script>

<style scoped></style>
