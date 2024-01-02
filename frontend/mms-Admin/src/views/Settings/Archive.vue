<template>
  <div class="archive-card">
    <div v-for="item in 10" :key="item" class="mb-3">
      <v-expansion-panels variant="inset">
        <v-expansion-panel>
          <v-expansion-panel-title>
            <div class="flex items-center">
              <Google size="47" />
              <div class="flex flex-col ml-2">
                <h1 class="font-semibold text-lg 2xl:text-xl text-[#333333]">
                  Google Africa Scholarship Program
                </h1>
                <div class="flex justify-between">
                  <p class="flex items-center text-xs text-[#808080]">
                    <IconCalendar /> <span class="ml-3">Dec 12, 2022</span>
                  </p>
                  <p class="flex items-center text-xs text-[#808080]">
                    <IconTime /> <span class="ml-3">8:00 pm</span>
                  </p>
                  <p></p>
                </div>
              </div>
            </div>
            <template v-slot:actions="{ expanded }">
              <v-icon v-if="!expanded"><IconArrowDown /></v-icon>
              <v-icon v-else><IconArrowUp /></v-icon>
            </template>
          </v-expansion-panel-title>
          <v-expansion-panel-text> Some content </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import {
  IconArrowDown,
  IconArrowUp,
  Google,
  IconCalendar,
  IconTime,
} from "@/assets/icons";

const expanded1 = ref<Number[]>([]);
</script>

<style scoped lang="scss"></style>
