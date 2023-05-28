<template>
  <div>
    <div class="flex items-center px-4 gap-6 py-2">
      <span><Google size="50" /></span>
      <section class="flex flex-col">
        <h3 class="font-semibold text-xl">Google Africa Scholarship Program</h3>
        <div class="flex gap-8">
          <div class="flex gap-2 items-center">
            <IconCalendar />
            <span class="text-gray-300 mt-1 text-[12px]"> Dec 12, 2022 </span>
          </div>
          <div class="flex gap-2 items-center">
            <IconTime />
            <span class="text-gray-300 mt-1 text-[12px]"> 8:00 pm </span>
          </div>
        </div>
      </section>
    </div>
    <section class="bg-green-100 px-6 py-4 flex flex-col gap-2">
      <h1 class="font-semibold text-xl">About:</h1>
      <p class="pb-2 text-gray-300">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi.
        Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla,
        mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis
        tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non
        suscipit magna interdum eu. Curabitur pellentesque nibh nibh, at maximus
        ante fermentum sit amet. Pellentesque
      </p>
      <ProgramResource
        type="mentor-managers"
        text="Mentor Managers assigned to this program"
        count="12"
        :programId="id"
        urlName="mentor-managers-assigned"
      />
      <ProgramResource
        type="mentor"
        text="Mentors assigned to this program"
        count="56"
        :programId="id"
        urlName="mentors-assigned"
      />
      <ProgramResource
        type="reports"
        text="Program reports"
        count="40"
        unread="88"
        :programId="id"
        urlName="program-reports"
      />
    </section>
    <div class="flex items-center justify-end my-5 mb-8 pr-6 gap-2">
      <GhostBtn
        title="Delete/Archive Program"
        :underline="true"
        @click="handleModalDecider('delete/archive')"
      >
        <DeleteArchive class="mt-1" />
      </GhostBtn>
      <router-link :to="{ name: 'edit-program', params: { id: `${id}` } }">
        <PrimaryBtn title="Edit Program" />
      </router-link>
    </div>
  </div>
  <Modal
    :title="modalData.title"
    :isModalOpen="isModalOpen"
    :src="modalData.src"
    :centerTitle="modalData.centerTitle"
    :primaryText="modalData.primaryText"
    :secondaryText="modalData.secondaryText"
    @toggleModal="handleArchive"
    @closeModal="handleDelete"
  />
</template>

<script setup lang="ts">
import { onMounted, watch, ref } from "vue";
import { Google, IconCalendar, IconTime, DeleteArchive } from "@/assets/icons";
import ProgramResource from "./ProgramResource.vue";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import GhostBtn from "../Buttons/GhostBtn.vue";
import { deleteSuccess } from "@/assets/images";
import Modal from "../Forms/Modal.vue";

let props = defineProps<Props>();

const isModalOpen = ref(false);
const modalData = ref<ModalData>({
  title: "",
  src: "",
  cardText: "",
  primaryText: "",
  secondaryText: "",
  email: false,
  centerTitle: "",
});
const modalDecider = ref("");

const openModal = () => {
  isModalOpen.value = true;
};
const handleDelete = () => {
  // Handle the Form submission
  switch (modalDecider.value) {
    case "delete/archive":
      // Switch to delete modal
      handleModalDecider("delete");
      break;
    case "archive":
      // Undo the archive, then close the modal
      isModalOpen.value = false;
      break;
    case "delete":
      // Undo the delete, then close the modal
      isModalOpen.value = false;
      break;
  }
};

const handleArchive = () => {
  // Handle the Form submission
  switch (modalDecider.value) {
    case "delete/archive":
      // Switch to archive modal
      handleModalDecider("archive");
      break;
    case "archive":
      // Archive the mentor, then close the modal
      isModalOpen.value = false;
      break;
    case "delete":
      // Delete the mentor, then close the modal
      isModalOpen.value = false;
      break;
  }
};

const handleModalDecider = (value: string) => {
  modalDecider.value = value;
  switch (value) {
    case "delete/archive":
      modalData.value = {
        centerTitle: "Choose to Delete or Archive Program",
        primaryText: "Archive",
        secondaryText: "Delete",
      };
      openModal();
      break;
    case "delete":
      modalData.value = {
        title: "Program Deleted Successfully",
        src: deleteSuccess,
        primaryText: "Done",
        secondaryText: "Undo",
      };
      openModal();
      break;
    case "archive":
      modalData.value = {
        title: "Program Archived Successfully",
        src: deleteSuccess,
        primaryText: "Done",
        secondaryText: "Undo",
      };
      openModal();
      break;
  }
};

watch(
  () => props.id,
  (id) => {
    // fetch program details from backend using id
  }
);
onMounted(() => {
  // fetch program details from backend using id
});

interface Props {
  id: Number;
}
interface ModalData {
  title?: string;
  src?: string;
  cardText?: string;
  primaryText: string;
  secondaryText?: string;
  email?: boolean;
  centerTitle?: string;
}
</script>

<style scoped></style>
