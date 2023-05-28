<template>
  <div>
    <h1 class="font-semibold text-2xl">Notifications</h1>
    <div class="flex justify-between items-center mt-3 mb-3">
      <div>
        <PlainDropdown :options="options" title="All" />
      </div>
      <div class="flex gap-6 items-center">
        <div
          class="flex items-center gap-1 cursor-pointer"
          @click="markAllAsRead"
        >
          <p class="text-base font-semibold" :class="allRead ? 'read' : ''">
            Mark all as read
          </p>
          <span><CheckMark /></span>
        </div>
        <Pagination />
      </div>
    </div>
    <div>
      <div
        class="card"
        :class="allRead || read[index].value ? 'read' : ''"
        v-for="(item, index) in getNumberToDisplay()"
        :key="item"
      >
        <div class="flex gap-5 items-center">
          <img
            src="https://i.pravatar.cc/300"
            class="w-[50px] h-auto rounded-full object-cover"
            alt=""
            srcset=""
          />
          <div class="flex flex-col">
            <h3>
              <span class="text-xl font-semibold">Lex Murphy</span>
              <span class="text-xl">
                requested approval for Gads Certificate by
              </span>
              <span class="text-xl font-semibold">Roseline Anapuna</span>
            </h3>
            <small class="text-[#B3B3B3]">Today at 9:42 AM</small>
          </div>
        </div>
        <div>
          <v-menu persistent>
            <template v-slot:activator="{ props }">
              <MoreIcon
                id="menu-activator"
                class="cursor-pointer"
                v-bind="props"
              />
            </template>
            <div class="bg-[#f7feff] rounded p-2">
              <p class="cursor-pointer" @click="markSingleAsRead(index)">
                Mark as Read
              </p>
            </div>
          </v-menu>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import PlainDropdown from "@/components/Common/PlainDropdown.vue";
import Pagination from "@/components/Common/Pagination.vue";
import { CheckMark, MoreIcon } from "@/assets/icons";

const getNumberToDisplay = () => {
  const height = window.innerHeight - window.innerHeight * 0.3;
  const cardHeight = 80;
  const numberToDisplay = Math.floor(height / cardHeight);
  return numberToDisplay;
};

const allRead = ref(false);
const read = ref<Read[]>(
  Array.from({ length: getNumberToDisplay() }, (_, index) => ({
    index,
    value: false,
  }))
);

const markAllAsRead = () => {
  allRead.value = true;
};

const markSingleAsRead = (index: number) => {
  read.value[index].value = true;
};

const options = [{ text: "Read" }, { text: "Unread" }];

interface Read {
  index: number;
  value: boolean;
}
</script>

<style scoped lang="scss">
.card {
  display: flex;
  justify-content: space-between;
  gap: 8rem;
  padding: 10px 40px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;
  margin-bottom: 10px;

  &:hover {
    background-color: var(--light-grid-background);
  }
}

.read {
  opacity: 0.6;
}
</style>
