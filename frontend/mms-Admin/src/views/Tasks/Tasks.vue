<template>
  <div className="flex gap-7 overflow-hidden">
    <TaskList />
    <div className="flex flex-col gap-2 w-full">
      <div class="flex justify-end">
        <router-link :to="{ name: 'create' }">
          <PrimaryBtn title="Create New Task" />
        </router-link>
      </div>
      <TaskDetails />
    </div>
  </div>
</template>

<script lang="ts">
import { IconSearch } from "@/assets/icons";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import IconFilter from "@/components/Icons/IconFilter.vue";
import TaskCard from "@/components/Tasks/TaskCard.vue";
import TaskDetails from "@/components/Tasks/TaskDetails.vue";
import TaskList from "@/components/Tasks/TaskList.vue";
import { useTasksStore } from "@/store/tasks";

export default {
  setup() {
    const tasksStore = useTasksStore();
    return {
      tasksStore,
    };
  },
  components: { TaskDetails, PrimaryBtn, TaskList },
};
</script>

<style scoped lang="scss">
.task_list {
  padding-right: 0.5rem;
  overflow-x: hidden;

  &::-webkit-scrollbar {
    width: 5px;
  }

  &::-webkit-scrollbar-track {
    background: transparent;
  }

  &::-webkit-scrollbar-thumb {
    background: var(--scrollbar-bg);
    height: 40px;
    border-radius: 100px;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: var(--btn-primary);
    opacity: 0.2;
  }
}
</style>
