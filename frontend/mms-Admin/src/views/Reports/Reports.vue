<template>
  <div>
    <h1>Reports</h1>
    <!-- <tabs>
      <tab title="Tab 1">Hi 1</tab>
      <tab title="Tab 2">Let's have fun 2</tab>
      <tab title="Tab 3">Find the special ones 3</tab>
      <tab title="Tab 4">Hunters prey 4</tab>
    </tabs> -->
    <ReportsTab />
  </div>
</template>

<script setup lang="ts">
import Tabs from "@/components/Tabs/Tabs.vue";
import Tab from "@/components/Tabs/Tab.vue";
import ReportTabs from "@/components/Reports/ReportTabs.vue";
</script>

<style scoped></style>
