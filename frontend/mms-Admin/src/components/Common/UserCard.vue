<template>
  <div class="card" @click="$emit('select', user)">
    <div class="flex gap-5 items-center">
      <UserAvatar :imageLink="user.avatar_url" />
      <div class="flex flex-wrap items-center">
        <div class="flex flex-col mr-8">
          <router-link
            :to="{
              name: isMentorManager ? 'mentor-manager' : 'mentor',
              params: { id: 1 },
            }"
          >
            <h1
              class="text-base 2xl:text-xl font-semibold cursor-pointer hover:underline transition-all"
            >
              {{ user.name }}
            </h1>
          </router-link>
          <small class="text-[#808080]"
            >Program Assistant, Andela, She/her</small
          >
        </div>
        <div class="flex items-center gap-3">
          <div class="text-xs bg-[#E6FDFE] rounded py-1 px-3">
            PROGRAM ASST.
          </div>
          <div class="text-xs bg-[#E6FDFE] rounded py-1 px-3">MENTOR-GADS</div>
        </div>
      </div>
    </div>
    <div class="flex flex-wrap items-center justify-end gap-6 mr-0">
      <!-- Handle routing to a specified chat -->
      <router-link to="/admin/messages"
        ><Comment class="cursor-pointer" v-if="showComment"
      /></router-link>
      <IconDelete
        color="#058B94"
        class="cursor-pointer"
        v-if="showDelete"
        @click="$emit('delete')"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { Comment } from "@/assets/icons";
import { IconDelete } from "../Icons";
import UserAvatar from "./UserAvatar.vue";

defineProps({
  showComment: {
    type: Boolean,
    default: false,
  },
  showDelete: {
    type: Boolean,
    default: false,
  },
  isMentor: {
    type: Boolean,
    default: false,
  },
  isMentorManager: {
    type: Boolean,
    default: false,
  },
  user: {
    type: Object,
    default: null,
  },
});

defineEmits(["delete", "select"]);
</script>

<style scoped lang="scss">
.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8rem;
  padding: 10px 40px;
  background-color: white;
  border-radius: 7px;
  border: 1px solid var(--border);
  width: 100%;

  &:hover {
    background-color: var(--light-grid-background);
  }

  &.selected {
    background-color: var(--light-grid-background);
    border: none !important;
  }
}
</style>
