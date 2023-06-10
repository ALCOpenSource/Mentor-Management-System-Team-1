<template>
  <div class="flex gap-4">
    <ReportList />
    <router-view></router-view>
  </div>
</template>

<script setup lang="ts">
import ReportList from "@/components/Reports/ReportList.vue";
</script>

<script lang="ts">

import { defineComponent } from "vue";
import { useReportStore } from "@/store/reports";

export default defineComponent({
  
  beforeRouteEnter(to, from, next) {
    const reportStore = useReportStore();
    if (reportStore.reports) {
      // The authentication state is already loaded, so proceed to the dashboard
      next()
    } else {
      // The authentication state is not loaded yet, so wait for it before proceeding
      reportStore.loadReports().then(() => {
        next()
      })
    }
  },
})
</script>
<style></style>
