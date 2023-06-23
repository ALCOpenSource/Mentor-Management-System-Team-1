<template>
  <section
    v-if="!ts.selectedTask.hasOwnProperty('title')"
    class="flex flex-col rounded-md border border-green-200 w-full h-96 items-center justify-center"
  >
    <h2 class="text-xl font-semibold">No Task Selected</h2>
    <p class="text-gray-300 text-sm">Select a task to preview</p>
  </section>
  <section
    v-else
    class="flex flex-col rounded-md border border-green-200 w-full"
  >
    <div class="flex px-4 gap-10 py-4">
      <TaskCardHeader
        :title="ts.selectedTask.title"
        :daysDue="ts.selectedTask.due_date"
      />
    </div>
    <section class="bg-green-100 px-6 py-4 flex flex-col gap-2 text-gray-300">
      <p class="leading-8 pb-4 text-sm 2xl:text-base">
        {{ ts.selectedTask.details }}
      </p>
      <TaskResource
        type="mentor-managers"
        text="Mentor Managers assigned to this tasks"
        count="20"
        unread="20"
        programId="1"
        urlName="mentor-managers-assigned-tasks"
      />
      <TaskResource
        type="mentor"
        text="Mentors assigned to this tasks"
        count="56"
        unread="90"
        programId="1"
        urlName="mentors-assigned-tasks"
      />
      <TaskResource
        type="reports"
        text="Task reports"
        count="40"
        unread="988"
        programId="1"
        urlName="tasks-reports"
      />
    </section>
    <section class="flex justify-end pr-6 gap-2 items-center py-6">
      <GhostBtn title="Delete" @click="() => onDelete(ts.selectedTask.id)">
        <IconDelete />
      </GhostBtn>
      <router-link to="edit">
        <PrimaryBtn title="Edit Task" />
      </router-link>
    </section>
  </section>
  <Modal
    :isModalOpen="isModalOpen"
    primaryText="Done"
    :src="deleteSuccess"
    title="Task Deleted Successfully"
    secondaryText="Undo"
    @toggleModal="() => toggleModal(false)"
  />
</template>

<script lang="ts">
import GhostBtn from "../Buttons/GhostBtn.vue";
import Modal from "../Forms/Modal.vue";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import TaskCardHeader from "./TaskCardHeader.vue";
import TaskResource from "./TaskResource.vue";
import { IconDelete } from "../Icons";
import { useTasksStore } from "@/store/tasks";
import { deleteSuccess } from "@/assets/images";

export default {
  setup() {
    const ts = useTasksStore();
    return { ts };
  },
  data() {
    return {
      isModalOpen: false,
    };
  },
  methods: {
    async onDelete(id: string) {
      const res = await this.ts.deleteTask(id);
      console.log("result is", res);
      //this.toggleModal(true);
      // if (res) {
      //   // open modal
      //   this.toggleModal(true);
      //   this.ts.fetchAllTasks();
      // }
    },
    toggleModal(open = false) {
      this.isModalOpen = open;
    },
  },
  components: {
    PrimaryBtn,
    IconDelete,
    GhostBtn,
    TaskResource,
    TaskCardHeader,
    Modal,
    deleteSuccess,
  },
};
</script>
