<template>
  <div class="flex gap-5">
    <div class="w-[319px] flex flex-col gap-8">
      <div>
        <Category
          :category="category"
          is-pending
          :pending-details="pendingDetails"
          @selected="setSelected"
          @pending-selected="setPending"
        />
      </div>
      <div>
        <Recent />
      </div>
    </div>
    <div class="w-full">
      <div class="flex justify-between items-center mb-5">
        <h1 v-if="!isPending" class="text-2xl font-semibold">
          {{ category[selected].name }}
        </h1>
        <h1 v-if="isPending" class="text-2xl font-semibold">
          {{ pendingDetails.name }}
        </h1>
        <div class="flex justify-between items-center gap-5">
          <router-link :to="{ name: 'generate-certificate' }">
            <SmallPrimaryBtn
              v-if="!isPending"
              title="Generate New Certificate"
            />
          </router-link>
          <Pagination />
          <IconSearch color="#058b94" />
          <Filter />
        </div>
      </div>
      <div>
        <div v-for="(item, index) in 10" :key="item" class="mb-2">
          <Accordion
            :index="index"
            :smallUrl="smallCertificate"
            general-cert
            :title="tabData.title"
          >
            <CertDropdown
              :largeCertificate="largeCertificate"
              :is-pending="isPending"
            />
          </Accordion>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Category from "@/components/Common/Category.vue";
import Recent from "@/components/Common/Recent.vue";
import {
  category1,
  category2,
  smallCertificate,
  largeCertificate,
} from "@/assets/images";
import SmallPrimaryBtn from "@/components/Buttons/SmallPrimaryBtn.vue";
import Pagination from "@/components/Common/Pagination.vue";
import { IconSearch, Filter } from "@/assets/icons";
import CertDropdown from "@/components/Mentors/CertDropdown.vue";
import Accordion from "@/components/Common/Accordion.vue";

const selected = ref(0);
const isPending = ref(false);

const setSelected = (index: number) => {
  selected.value = index;
};
const setPending = (value: boolean) => {
  isPending.value = value;
};

// Fetch data from store according to the selected category and pending status
const tabData = {
  title: "GADS CLOUD 2022 - COMPLETION",
};

const category = [
  {
    name: "Approved Certificates",
    count: 287,
    imgUrl: category1,
  },
  {
    name: "My Generated Certificates",
    count: 160,
    imgUrl: category2,
  },
];
const pendingDetails = {
  name: "Certificates pending approval",
  count: 3,
};
</script>

<style scoped></style>
