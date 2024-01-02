<template>
  <div class="flex gap-6">
    <section class="w-full">
      <h1 class="font-semibold text-2xl">Edit Task</h1>
      <form class="mt-10 flex flex-col" @submit="toUpdateTask">
        <!-- Title -->
        <Input
          label="Title"
          placeholder="Enter a title"
          hint="The title must contain a maximum of 32 characters"
        />
        <Textarea placeholder="Enter task details" label="Details" />
        <section class="flex gap-6">
          <!-- Add Mentor Manager -->
          <ResourceSelector :on-click="toggleResourceList" />
          <!-- Add Mentor -->
          <ResourceSelector :on-click="toggleResourceList" />
        </section>
        <!-- Create Task button -->
        <PrimaryBtn title="Update Task" class="small" />
      </form>
    </section>

    <!-- Mentor or Mentor Manager selection list -->
    <ResourceList
      v-show="showResourceList"
      :onClick="addToResourceList"
      :resources="mentorManagers"
      :selectedResources="selectedResources"
    />

    <Modal
      title="Task updated successfully"
      :src="updateSuccessful"
      primary-text="Done"
      :is-modal-open="modalOpen"
      @toggle-modal="toggleModal"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import ResourceSelector from "@/components/Common/ResourceSelector.vue";
import Input from "@/components/Forms/Input.vue";
import Textarea from "@/components/Forms/Textarea.vue";
import ResourceList from "@/components/Tasks/ResourceList.vue";
import Modal from "@/components/Forms/Modal.vue";
import { updateSuccessful } from "@/assets/images";

let modalOpen = ref(false);

const toggleModal = () => (modalOpen.value = !modalOpen.value);

const toUpdateTask = (e: Event) => {
  e.preventDefault();
  toggleModal();
};

const selectedResources: number[] = [];
const mentorManagers = [
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
];
let showResourceList = ref(false);

const addToResourceList = (resourceId: number) => {
  selectedResources.push(resourceId);
};

const toggleResourceList = () => {
  showResourceList.value = !showResourceList.value;
};
</script>
