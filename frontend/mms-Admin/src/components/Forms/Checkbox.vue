<template>
  <div class="flex items-center">
    <label :for="switchName" class="inline-flex items-center cursor-pointer">
      <span class="relative">
        <input
          :id="switchName"
          v-model="checked"
          type="checkbox"
          class="hidden peer"
          @change="updateChecked"
        />
        <div
          class="w-[35px] h-[20px] rounded-full shadow-inner bg-[#B3B3B3] peer-checked:dark:bg-[#058B94]"
        ></div>
        <div
          class="absolute bg-white border-2 border-[#B3B3B3] inset-y-0 left-0 w-[20px] h-[20px] rounded-full shadow peer-checked:border-[#058B94] peer-checked:right-0 peer-checked:left-auto"
        ></div>
        <span
          class="absolute text-[#FF5964] top-[-3px] left-[5px] peer-checked:hidden"
          >x</span
        >
        <span
          class="absolute hidden top-[4px] right-[5px] text-red-500 peer-checked:block"
          ><svg
            width="12"
            height="12"
            viewBox="0 0 8 5"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M3.14475 4.98822L0.923309 2.76678L1.47867 2.21142L3.14475 3.8775L6.7205 0.301758L7.27586 0.857119L3.14475 4.98822Z"
              fill="#31507F"
            />
          </svg>
        </span>
      </span>
    </label>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";

interface Props {
  id: string;
  switchName: string;
  checked: boolean;
}

const props = defineProps<Props>();

const checked = ref(props.checked);

const emit = defineEmits(["update:checked"]);

const updateChecked = () => {
  emit("update:checked", { id: props.id, checked: checked.value });
};

watch(
  () => props.checked,
  (val) => {
    checked.value = val;
  }
);
</script>

<style scoped>
input:before {
  content: "";
  position: absolute;
  width: 1.25rem;
  height: 1.25rem;
  border-radius: 50%;
  top: 0;
  left: 0;
  transform: scale(1.1);
  box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.2);
  background-color: white;
  transition: 0.2s ease-in-out;
}

input:checked {
  background-color: #7f9cf5;
}

input:checked:before {
  left: 1.25rem;
}
</style>
