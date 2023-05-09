<template>
    <button class="upload" @click="handleClick">Upload Picture</button>
    <input ref="file" type="file" name="" class="hidden" @change="handleChange" />
</template>

<script setup lang="ts">
import { ref } from "vue";

const file = ref();

const emit = defineEmits(["upload"]);

const handleClick = (evt: any) => {
  file.value.click();
};

const handleChange = (evt: any) => {
  const reader = new FileReader();
  reader.readAsDataURL(evt.target.files[0]); 
  reader.onload = () => {
    emit("upload", evt.target.files[0], reader.result);
  };
  // Sending the file to the backend

};
</script>

<style scoped lang="scss">
.upload {
  border-radius: 7px;
  border: none;
  background-color: var(--btn-primary);
  color: #fff;
  padding: 4px 15px;
  transition: all 0.2s cubic-bezier(0.77, 0, 0.175, 1);
  font-size: 14px;

  &:hover {
    background-color: var(--btn-primary-hover);
  }
}
</style>
