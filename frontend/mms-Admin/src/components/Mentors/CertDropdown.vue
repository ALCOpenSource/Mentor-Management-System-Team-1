<template>
  <div class="cert w-2/4 mx-auto flex flex-col items-end pb-3">
    <img :src="largeCertificate" alt="" />
    <div v-if="!isPending" class="flex gap-5 items-center">
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
    <div v-if="isPending" class="flex gap-5 items-center">
      <SecondaryBtn title="Decline" />
      <PrimaryBtn title="Approve" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import SecondaryBtn from "../Buttons/SecondaryBtn.vue";
import { Dropdown } from "@/assets/icons";

const props = defineProps<Props>();

const select = ref("pdf");

interface Props {
  largeCertificate: string;
  isPending?: boolean;
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
