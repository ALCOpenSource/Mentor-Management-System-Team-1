<template>
  <v-expansion-panels variant="accordion">
    <v-expansion-panel>
      <v-expansion-panel-title>
        <div class="flex items-center">
          <img :src="smallCertificate" alt="" />
          <div class="flex flex-col ml-5">
            <h1 class="font-semibold text-xl text-[#333333] uppercase">
              {{ tabData.title }}
            </h1>
          </div>
        </div>
        <template v-slot:actions="{ expanded }">
          <v-icon v-if="!expanded"><IconArrowDown /></v-icon>
          <v-icon v-else><IconArrowUp /></v-icon>
        </template>
      </v-expansion-panel-title>
      <v-expansion-panel-text>
        <div class="cert flex flex-col items-center pb-3">
          <img :src="largeCertificate" alt="" />
          <div class="flex gap-5 items-center">
            <div class="flex gap-2 items-center">
              <h1>Download as</h1>
              <div class="select-container">
                <select name="saveas" id="" v-model="select">
                  <option value="pdf">PDF</option>
                  <option value="png">PNG</option>
                  <option value="jpg">JPG</option>
                </select>
                <Dropdown class="dropdown" />
              </div>
            </div>
            <a href="/cert.png" download>
              <PrimaryBtn title="Download" />
            </a>
          </div>
        </div>
      </v-expansion-panel-text>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IconArrowDown, IconArrowUp, Dropdown } from "@/assets/icons";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import { smallCertificate, largeCertificate } from "@/assets/images";
import cert from "@/assets/images/cert.png";

const props = defineProps<Props>();

const select = ref("pdf");

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
.cert {
  img {
    width: 441px;
    height: 336px;
    margin-bottom: 20px;
  }

  select {
    border: 1px solid var(--border);
    padding: 3px 25px 2px 20px;
    border-radius: 5px;
    outline: none;

    &:focus {
      border: 1px solid #058b94;
    }
  }

  .select-container {
    position: relative;

    .dropdown {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
    }
  }
}
</style>
