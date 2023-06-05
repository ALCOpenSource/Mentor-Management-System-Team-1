<template>
  <div
    class="w-full bg-green-100 p-2 py-8 justify-center gap-6 flex items-center"
  >
    <section class="flex flex-col items-center">
      <h4 class="font-semibold text-base 2xl:text-lg mb-2">{{ title }}</h4>
      <div
        class="bg-white px-8 inline-flex border-2 border-green-200 rounded-md py-2 gap-2 items-center"
      >
        <p class="text-sm 2xl:text-base">{{ num }} Selected</p>
        <IconRemove />
      </div>
    </section>
    <div class="">
      <SmallPrimaryBtn title="Select" :on-click="onClick" type="button" />
    </div>
  </div>
</template>

<script setup lang="ts">
import SmallPrimaryBtn from "../Buttons/SmallPrimaryBtn.vue";
import IconRemove from "../Icons/IconRemove.vue";

type Props = {
  onClick: () => void;
  title: string;
  num: number;
};

defineProps<Props>();
</script>
