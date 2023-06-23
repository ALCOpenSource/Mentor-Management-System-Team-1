<template>
  <div class="flex gap-6">
    <section class="w-full">
      <h1 class="font-semibold text-2xl">New Task</h1>
      <form
        class="mt-10 flex flex-col"
        ref="createForm"
        @submit.prevent="createNewTask"
      >
        <!-- Title -->
        <Input
          label="Title"
          placeholder="Enter a title"
          @update:text-input="(value: string) => (newTaskData.title = value)"
          hint="The title must contain a maximum of 32 characters"
        />
        <Textarea
          placeholder="Enter task details"
          label="Details"
          @update:text-area-val="(value: string) => (newTaskData.details = value)"
        />
        <section class="flex gap-6 mt-4 mb-8">
          <!-- Add Mentor Manager -->
          <ResourceSelector
            :on-click="toggleResourceList"
            title="Add Mentor Manager"
            :num="10"
          />
          <!-- Add Mentor -->
          <ResourceSelector
            :on-click="toggleResourceList"
            title="Add Mentor"
            :num="6"
          />
        </section>
        <!-- Create Task button -->
        <PrimaryBtn
          :title="ts.isCreatingTask ? 'Creating Task' : 'Create Task'"
          class="small"
          role="submit"
        />
      </form>
    </section>

    <!-- Mentor or Mentor Manager selection list -->
    <ResourceList
      v-if="showResourceList"
      :onClick="addToResourceList"
      :resources="mentorManagers"
      :selectedResources="selectedMentorManagers"
    />
  </div>
</template>

<script lang="ts">
const ts = useTasksStore();
import { ref } from "vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import ResourceSelector from "@/components/Common/ResourceSelector.vue";
import Input from "@/components/Forms/Input.vue";
import Textarea from "@/components/Forms/Textarea.vue";
import ResourceList from "@/components/Tasks/ResourceList.vue";
import { useTasksStore } from "@/store/tasks";

export default {
  setup() {
    const ts = useTasksStore();

    return { ts };
  },
  data() {
    return {
      newTaskData: {},
      showResourceList: false,
      mentorManagers: [
        {
          id: 1,
          name: "Kabiru Omo Isaka",
          position: "Program Assistant",
          pronouns: ["She", "her"],
          roles: ["Program Asst", "Mentor-GADS"],
        },
        {
          id: 2,
          name: "Taofekat Municipal",
          position: "Program Assistant",
          pronouns: ["She", "her"],
          roles: ["Program Asst", "Mentor-GADS"],
        },
        {
          id: 3,
          name: "Idris Kempleton",
          position: "Program Assistant",
          pronouns: ["She", "her"],
          roles: ["Program Asst", "Mentor-GADS"],
        },
        {
          id: 4,
          name: "Paul Adefejaye",
          position: "Program Assistant",
          pronouns: ["She", "her"],
          roles: ["Program Asst", "Mentor-GADS"],
        },
      ],
      selectedMentors: [],
      selectedMentorManagers: [],
    };
  },
  methods: {
    async createNewTask() {
      const taskPostData = {
        ...newTaskData,
        assignees: [...this.selectedMentorManagers, ...this.selectedMentors],
        priority: "low",
        due_date: this.spawnDate(6),
        status: "in_progress",
        start_date: new Date(Date.now()),
      };
      await this.ts.createTask(taskPostData);
      console.log("Submitting", taskPostData);
      //this.$ref.createForm.reset();
    },
    spawnDate(days: number) {
      const date = new Date();
      date.setDate(date.getDate() + days);
      return date;
    },
    toggleResourceList() {
      this.showResourceList = !this.showResourceList;
    },
    addToResourceList(resourceId: string) {
      if (1) {
        // if resource is a mentor, add to selected mentors
        this.selectedMentors.push(resourceId);
      } else {
        // else if resource is a mentor-manager, add to selected mentor managers
        this.selectedMentorManagers.push(resourceId);
      }
    },
  },
  components: { Input, Textarea, ResourceList, PrimaryBtn, ResourceSelector },
};

const newTaskData = ref({});
</script>
