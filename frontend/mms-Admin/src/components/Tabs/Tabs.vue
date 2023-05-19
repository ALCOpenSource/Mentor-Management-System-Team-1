<template>
  <div>
    <!-- <TabSwitch /> -->
    <ul class="tabs-header">
      <li
        v-for="(tab, index) in tabs"
        @click="selectTab(index)"
        :key="tab.title"
      >
        <span>Trigger</span>
        <span>{{ tab.title }}</span>
      </li>
    </ul>
    <slot></slot>
  </div>
</template>

<script lang="ts">
import TabSwitch from "./TabSwitch.vue";

type Tab = {
  title: string;
};
export default {
  created() {
    this.tabs = this.$children;
  },
  data() {
    return {
      selectedIndex: 0,
      tabs: [],
    };
  },
  methods: {
    selectTab(index: number) {
      console.log("selecting tab");

      this.selectedIndex = index;

      // loop over all the tabs
      this.tabs.forEach((tab, idx) => {
        tab.isActive = index === idx;
      });
    },
  },
  mounted() {
    this.selectTab(0);
  },
};
</script>

<style></style>
