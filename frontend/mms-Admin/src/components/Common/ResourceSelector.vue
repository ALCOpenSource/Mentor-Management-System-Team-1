<template>
  <div
    class="bg-green-100 p-2 py-8 justify-center gap-4 flex items-center w-1/2"
  >
    <section>
      <h4 class="font-semibold">Add Mentor Manager</h4>
      <div
        class="bg-white px-8 inline-flex border-2 border-green-200 rounded-md py-2 gap-2 items-center"
      >
        <p>10 Selected</p>
        <IconRemove />
      </div>
    </section>
    <div class="">
      <PrimaryBtn title="Select" :on-click="onClick" type="button" />
    </div>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import IconRemove from "../Icons/IconRemove.vue";

type Props = {
  onClick: () => void;
};

defineProps<Props>();
</script>
