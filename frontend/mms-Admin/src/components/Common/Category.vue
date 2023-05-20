<template>
  <div class="category">
    <h1 class="p-2 font-semibold text-lg">Category</h1>
    <ul>
      <li
        v-for="(item, index) in category"
        :key="item.name"
        class="list-card"
        @click="(e) => selected(e, index)"
      >
        <span class="flex items-center justify-between">
          <img :src="item.imgUrl" alt="" />
          <p class="w-2/4 font-bold text-base">{{ item.name }}</p>
          <p class="text-2xl font-bold">{{ item.count }}</p>
        </span>
      </li>
      <li v-if="isPending" class="list-card" @click="(e) => pendingSelect(e)">
        <span class="flex justify-between items-center">
          <p>{{ pendingDetails?.name }}</p>
          <p class="px-[7px] bg-[#FF5964] text-[#fff] rounded-md">
            {{ pendingDetails?.count }}
          </p>
        </span>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";

defineProps<Props>();
const emit = defineEmits(["selected", "pendingSelected"]);

const selectFnct = (e: Event) => {
  const list = document.querySelectorAll(".list-card");
  list.forEach((item) => {
    item.classList.remove("selected");
  });
  const target = e.target as HTMLElement;
  const card = target.closest(".list-card");
  if (card) {
    card.classList.add("selected");
  }
};

const selected = (e: Event, index: number) => {
  selectFnct(e);
  emit("pendingSelected", false);
  emit("selected", index);
};

const pendingSelect = (e: Event) => {
  selectFnct(e);
  emit("pendingSelected", true);
};

// Onmounted add the selected class the first li element
onMounted(() => {
  const list = document.querySelectorAll(".list-card");
  list.forEach((item) => {
    item.classList.remove("selected");
  });
  const first = list[0];
  first.classList.add("selected");
});

interface Props {
  category: {
    name: string;
    count: number;
    imgUrl: string;
  }[];
  isPending?: boolean;
  pendingDetails?: {
    name: string;
    count: number;
  };
}
</script>

<style scoped lang="scss">
.category {
  border: 1px solid var(--card-light);
  border-radius: 10px;
  background-color: var(--light-grid-background);
  padding: 5px;
  padding-bottom: 10px;

  li {
    list-style: none;
    border-radius: 5px;
    padding: 15px;
    background-color: var(--light-grid-background);
    color: var(--text-inactive);
    transition: all 0.2s ease-in-out;
    cursor: pointer;

    &:hover {
      background-color: #fff;
      color: #333;
    }

    &.selected {
      background-color: #fff;
      color: #333;
    }
  }
}
</style>
