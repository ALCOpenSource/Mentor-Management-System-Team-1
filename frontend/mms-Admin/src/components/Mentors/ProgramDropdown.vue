<template>
  <v-expansion-panels variant="accordion">
    <v-expansion-panel>
      <v-expansion-panel-title>
        <div class="flex items-center">
          <Icon />
          <div class="flex flex-col ml-5">
            <h1 class="font-semibold text-xl text-[#333333]">
              {{ tabData.title }}
            </h1>
            <div class="flex justify-between">
              <p class="flex items-center text-sm text-[#808080]">
                <IconCalendar /> <span class="ml-3">{{ tabData.date }}</span>
              </p>
              <p v-if="tabData.isProgram" class="flex items-center text-sm text-[#808080]">
                <IconTime /> <span class="ml-3">{{ tabData.time }}</span>
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
      <v-expansion-panel-text>
        <div class="px-3">
          <h1 class="text-xl font-semibold">About</h1>
          <p class="text-[#808080]">
            {{ tabData.content }}
          </p>
          <div class="report">
            <div class="flex items-center gap-2">
              <Reports width="24px" height="24px" />
              <h1 class="text-[32px] font-bold ml-3">{{ tabData.numberOfReports }}</h1>
              <h1 class="text-xl font-semibold mr-2">{{ tabData.category }} Reports</h1>
              <span
                class="rounded-full bg-red-400 text-white w-[20px] h-[20px] flex justify-center items-center"
                >3</span
              >
            </div>
            <SmallPrimaryBtn title="View" />
          </div>
          <div class="flex justify-end mt-6 mb-2">
            <SecondaryBtn :title="`Unassign from ${tabData.category}`"/>
          </div>
        </div>
      </v-expansion-panel-text>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script setup lang="ts">
import {
  IconArrowDown,
  IconArrowUp,
  IconCalendar,
  Google,
  IconTime,
  Reports,
} from "@/assets/icons";
import SmallPrimaryBtn from "../Buttons/SmallPrimaryBtn.vue";
import SecondaryBtn from "../Buttons/SecondaryBtn.vue";

const props = defineProps<Props>();

let Icon = props.tabData.mainIcon;

interface Props {
  tabData: {
    category: string;
    title: string;
    date: string;
    time?: string;
    mainIcon: any;
    content: string;
    numberOfReports: number;
    isProgram: boolean;
  };
}

</script>

<style scoped lang="scss">
.report {
  display: flex;
  gap: 20px;
  align-items: center;
  justify-content: space-between;
  padding: 5px 20px;
  background-color: var(--card-light);
  margin-top: 15px;
}
</style>
