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
        ><p class="font-semibold">{{ item.name }}</p></v-col
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
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

import Checkbox from "../../components/Forms/Checkbox.vue";

// Should come from the backend
const privacy = ref([
  {
    name: "Show contact info",
    switchName: "switch1",
    id: "1",
    checked: false,
  },
  {
    name: "Show GitHub",
    switchName: "switch2",
    id: "2",
    checked: true,
  },
  {
    name: "Show Instagram",
    switchName: "switch3",
    id: "3",
    checked: false,
  },
  {
    name: "Show Linkdein",
    switchName: "switch4",
    id: "4",
    checked: true,
  },
  {
    name: "Show Twitter",
    switchName: "switch5",
    id: "5",
    checked: false,
  },
]);

const toggleChecked = (id: String) => {
  const index = privacy.value.findIndex((item) => item.id === id);
  privacy.value[index].checked = !privacy.value[index].checked;
};
</script>

<style scoped></style>
