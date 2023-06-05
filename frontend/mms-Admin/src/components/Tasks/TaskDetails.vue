<template>
  <section class="flex flex-col rounded-md border border-green-200 w-full">
    <div class="flex px-4 gap-10 py-4">
      <TaskCardHeader :title="task.title" :daysDue="task.daysDue" />
    </div>
    <section class="bg-green-100 px-6 py-4 flex flex-col gap-2 text-gray-300">
      <p class="leading-8 pb-4 text-sm 2xl:text-base">{{ task.description }}</p>
      <TaskResource
        type="mentor-managers"
        text="Mentor Managers assigned to this program"
        count="20"
        unread="20"
      />
      <TaskResource
        type="mentor"
        text="Mentors assigned to this program"
        count="56"
        unread="90"
      />
      <TaskResource
        type="reports"
        text="Task reports"
        count="40"
        unread="988"
      />
    </section>
    <section class="flex justify-end pr-6 gap-2 items-center py-6">
      <GhostBtn title="Delete">
        <IconDelete />
      </GhostBtn>
      <router-link to="edit">
        <PrimaryBtn title="Edit Task" />
      </router-link>
    </section>
  </section>
</template>

<script setup lang="ts">
import GhostBtn from "../Buttons/GhostBtn.vue";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import TaskCardHeader from "./TaskCardHeader.vue";
import TaskResource from "./TaskResource.vue";
import { IconDelete } from "../Icons";

type Props = {
  task: {
    id: number;
    title: string;
    description: string;
    daysDue: number;
  };
};

defineProps<Props>();
</script>
