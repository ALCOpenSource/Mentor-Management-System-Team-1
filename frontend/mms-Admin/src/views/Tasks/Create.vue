<template>
  <div class="flex gap-6">
    <section class="w-full">
      <h1 class="font-semibold text-2xl">New Task</h1>
      <form class="mt-10 flex flex-col">
        <!-- Title -->
        <Input
          label="Title"
          placeholder="Enter a title"
          hint="The title must contain a maximum of 32 characters"
        />
        <Textarea placeholder="Enter task details" label="Details" />
        <section class="flex gap-6 mb-4">
          <!-- Add Mentor Manager -->
          <ResourceSelector :on-click="toggleResourceList" />
          <!-- Add Mentor -->
          <ResourceSelector :on-click="toggleResourceList" />
        </section>
        <!-- Create Task button -->
        <PrimaryBtn title="Create Task" class="small" />
      </form>
    </section>

    <!-- Mentor or Mentor Manager selection list -->
    <ResourceList
      v-if="showResourceList"
      :onClick="addToResourceList"
      :resources="mentorManagers"
      :selectedResources="selectedResources"
    />
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import ResourceSelector from "@/components/Common/ResourceSelector.vue";
import Input from "@/components/Forms/Input.vue";
import Textarea from "@/components/Forms/Textarea.vue";
import ResourceList from "@/components/Tasks/ResourceList.vue";
import type { ResourceType } from "@/typings/components";

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
let showResourceList = true;

const addToResourceList = (resourceId: number) => {
  console.log(`add resource of ${resourceId} to list`);
  selectedResources.push(resourceId);
  console.log("Selected resource IDs", selectedResources);
};

const toggleResourceList = () => {
  console.log("Toggle Resource", showResourceList);
  showResourceList = !showResourceList;
};
</script>
