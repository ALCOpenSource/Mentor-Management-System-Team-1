<template>
  <div class="w-5/12">
    <div
      class="py-2 px-2 flex justify-between rounded-md bg-green-400 text-white"
    >
      <router-link to="/admin/reports/programs">
        <button
          class="w-full p-2 text-xl px-4 rounded-md"
          :class="{ active: isActive('/admin/reports/programs') }"
        >
          Program Reports
        </button>
      </router-link>

      <router-link to="/admin/reports/tasks">
        <button
          class="w-full text-xl flex p-2 px-4 rounded-md"
          :class="{ active: isActive('/admin/reports/tasks') }"
        >
          Tasks Reports
        </button>
      </router-link>
    </div>
    <div class="mt-8 overflow-y-scroll pr-4 h-[70vh] fancy-scroll pb-2">
      <section class="flex justify-between mb-3">
        <button class="flex items-center gap-2">
          <span>All Reports</span>
          <IconCaret />
        </button>
        <IconSearch color="#058B94" />
      </section>
      <ReportCard
        path="/admin/reports/programs/"
        v-show="isActive('/admin/reports/programs')"
        v-for="report in reports"
        :title="report.title"
        :author="report.author"
        :id="report.id"
        :key="report.id"
      >
        <IconReportAlt color="#058B94" :size="40" />
      </ReportCard>

      <ReportCard
        path="/admin/reports/tasks/"
        v-show="isActive('/admin/reports/tasks')"
        v-for="report in reportStore.reports.data"
        :title="report.details"
        :author="report.created_by"
        :date="convertedDate(report.created_at)"
        :id="report.id"
        :key="report.id"
      >
        <IconTask color="#058B94" size="40" />
      </ReportCard>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import { IconSearch, IconCaret } from "../Icons";
import ReportCard from "@/components/Reports/ReportCard.vue";
import IconReportAlt from "../Icons/IconReportAlt.vue";
import IconTask from "../Icons/IconTask.vue";
import { useReportStore } from "@/store/reports";

const isActive = ref<Boolean>(false);
const route = useRoute();
const reportStore = useReportStore();

watch(() => {
  isActive.value = (path: string) => route.path.startsWith(path);
});

const reports = [
  {
    title: "Room Library article write on them for",
    author: "Alison Davis",
    id: 1,
  },
  {
    title: "Dabire the final evidence is set",
    author: "Periwinkle Morpheus",
    id: 2,
  },
  {
    title: "Authorize and find a melee",
    author: "Alison Davis",
    id: 3,
  },
  {
    title: "Zinc is not the real business",
    author: "Peter Clarke",
    id: 4,
  },
];

const  convertedDate = (originalDate: any) => {
    const options = { day: 'numeric', month: 'short', year: 'numeric' };

    return new Date(originalDate).toLocaleDateString('en-US', options);
}
</script>

<style scoped lang="scss">
.active {
  color: #058b94;
  background-color: #fff;
  font-weight: bold;
  transition: all 200ms ease-in;
}
</style>
