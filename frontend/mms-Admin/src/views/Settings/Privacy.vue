<template>
  <div>
    <v-row
      v-for="item in privacy"
      :key="item.id"
      no-gutters
      class="my-4"
      align="center"
    >
      <v-col cols="6"
        ><p class="font-semibold text-sm 2xl:text-base">
          {{ item.name }}
        </p></v-col
      >
      <v-col cols="1" class="font-semibold mr-4">
        <Checkbox
          :id="item.id"
          :switch-name="item.switchName"
          :checked="item.checked"
          @update:checked="toggleChecked"
        />
      </v-col>
    </v-row>
    <v-row class="mt-10" align-content="center" justify="start">
      <v-col cols="8">
        <PrimaryBtn title="Save Changes" @click="handleSubmit" />
      </v-col>
    </v-row>
    <Modal
      title="Settings Saved Successfully"
      :src="profileSuccess"
      :is-modal-open="isModalOpen"
      primary-text="Done"
      @toggle-modal="toggleModal"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Checkbox from "../../components/Forms/Checkbox.vue";
import Modal from "../../components/Forms/Modal.vue";
import { profileSuccess } from "../../assets/images";
import PrimaryBtn from "@/components/Buttons/PrimaryBtn.vue";
import { usePrivacyStore } from "@/store/settings/privacy";
import { storeToRefs } from "pinia";

const isModalOpen = ref(false);

const store = usePrivacyStore();
const { fetchPrivacy, updatePrivacy } = usePrivacyStore();
fetchPrivacy();

const {
  show_contact_info,
  show_github,
  show_instagram,
  show_linkedin,
  show_twitter,
  show_modal,
} = storeToRefs(usePrivacyStore());

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleSubmit = async () => {
  await updatePrivacy();
  if (show_modal) toggleModal();
};

// Should come from the backend
const privacy = ref([
  {
    name: "Show contact info",
    switchName: "show_contact_info",
    id: "1",
    checked: show_contact_info,
  },
  {
    name: "Show GitHub",
    switchName: "show_github",
    id: "2",
    checked: show_github,
  },
  {
    name: "Show Instagram",
    switchName: "show_instagram",
    id: "3",
    checked: show_instagram,
  },
  {
    name: "Show Linkdein",
    switchName: "show_linkedin",
    id: "4",
    checked: show_linkedin,
  },
  {
    name: "Show Twitter",
    switchName: "show_twitter",
    id: "5",
    checked: show_twitter,
  },
]);

const toggleChecked = async ({ id, checked }) => {
  const index = privacy.value.findIndex((item) => item.id === id);
  privacy.value[index].checked = !privacy.value[index].checked;

  if (privacy.value[index].switchName === "show_contact_info")
    store.$patch({ show_contact_info: checked });

  if (privacy.value[index].switchName === "show_github")
    store.$patch({ show_github: checked });

  if (privacy.value[index].switchName === "show_instagram")
    store.$patch({ show_instagram: checked });

  if (privacy.value[index].switchName === "show_linkedin")
    store.$patch({ show_linkedin: checked });

  if (privacy.value[index].switchName === "show_twitter")
    store.$patch({ show_twitter: checked });
};
</script>

<style scoped></style>
