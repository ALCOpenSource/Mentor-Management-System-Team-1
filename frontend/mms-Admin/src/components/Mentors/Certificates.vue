<template>
  <div class="programs">
    <div class="archive-card">
      <div class="mb-3" v-for="(n, index) in 10" :key="n">
        <Accordion
          :index="index"
          :smallUrl="smallCertificate"
          isMentorCert
          :title="tabData.title"
        >
          <CertDropdown :largeCertificate="largeCertificate" />
        </Accordion>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import CertDropdown from "./CertDropdown.vue";
import Accordion from "../Common/Accordion.vue";
import { smallCertificate, largeCertificate } from "@/assets/images";

const tabData = {
  title: "GADS CLOUD 2022 - COMPLETION",
};
</script>

<style scoped lang="scss">
.archive-card {
  height: 56vh;
  overflow-y: scroll;
  padding-right: 0.5rem;
  padding-bottom: 3rem;

  &::-webkit-scrollbar {
    width: 5px;
    transition: all 0.5s ease-in-out;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: #06b9c6;
    border-radius: 50px;
  }
}
</style>
