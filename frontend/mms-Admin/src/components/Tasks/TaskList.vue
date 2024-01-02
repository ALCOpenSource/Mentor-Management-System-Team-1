<template>
  <div className="w-[359px] overflow-x-hidden">
    <section className="flex justify-between pb-6 overflow-y-auto ">
      <h1 className="font-semibold text-xl 2xl:text-2xl">Tasks</h1>
      <div class="flex items-center gap-2">
        <span class="cursor-pointer">
          <IconSearch color="#058B94" />
        </span>
        <span class="cursor-pointer">
          <IconFilter />
        </span>
      </div>
    </section>
    <section
      class="flex flex-col h-[80vh] task_list gap-2 overflow-y-auto overflow-x-hidden"
    >
      <div v-if="tasksStore.isLoading">
        <HollowDotsSpinner :color="'#058b94'" />
      </div>
      <TaskCard
        v-else
        v-for="task in tasksStore.tasks"
        :onClick="() => tasksStore.selectTask(task.id)"
        :key="task.id"
        :is-selected="task.id === tasksStore.selectedTask.id"
        :title="task.title"
        :description="task.details"
        :days-due="task.due_date"
      />
    </section>
  </div>
</template>

<script lang="ts">
import TaskCard from "./TaskCard.vue";
import { IconSearch } from "../Icons";
import IconFilter from "../Icons/IconFilter.vue";
import { useTasksStore } from "@/store/tasks";
import { HollowDotsSpinner } from "epic-spinners";

export default {
  setup() {
    const tasksStore = useTasksStore();

    return { tasksStore };
  },
  mounted() {
    this.tasksStore.fetchAllTasks();
  },
  components: { TaskCard, IconFilter, IconSearch, HollowDotsSpinner },
};
</script>

<style lang="scss"></style>
