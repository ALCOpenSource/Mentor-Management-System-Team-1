<template>
  <div class="bg-green-200 p-2 py-8 justify-center gap-4 flex items-center">
    <section>
      <h4 class="font-semibold">Add Mentor Manager</h4>
      <div
        class="bg-white px-8 inline-flex border border-green-200 rounded-md py-2 gap-2 items-center"
      >
        <p>10 Selected</p>
        <IconRemove />
      </div>
    </section>
    <div class="">
      <PrimaryBtn title="Select" />
    </div>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import IconRemove from "../Icons/IconRemove.vue";
</script>
