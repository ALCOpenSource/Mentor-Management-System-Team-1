<template>
  <div class="py-4 flex flex-col">
    <label v-if="label" class="text-lg 2xl:text-xl mb-2 font-semibold">{{
      label
    }}</label>
    <textarea
      rows="6"
      v-model="textAreaVal"
      required
      :placeholder="placeholder"
      @input="$emit('update:textAreaVal', textAreaVal)"
      class="p-4 text-lg input border font-light rounded-md focus:outline-[#058b94]"
    >
    </textarea>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
type Props = {
  label?: string;
  placeholder?: string;
  initialValue?: string;
};

const props = defineProps<Props>();

defineEmits(["update:textAreaVal"]);

const textAreaVal = ref(props.initialValue || "");
</script>
