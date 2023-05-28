<template>
  <section
    class="outline outline-2 rounded-md outline-gray-100 p-4 gap-4 flex items-center"
  >
    <img
      class="resource_avatar"
      src="https://picsum.photos/200"
      alt=""
      srcset=""
    />
    <div class="flex flex-col">
      <span class="font-bold text-lg">Kabiru Omo Isaka</span>
      <!-- concatenate bio info -->
      <span class="text-gray-300 mb-1">Program Assistant, Andela, She/Her</span>
      <section class="flex gap-4">
        <span class="px-2 py-1 bg-green-200">PROGRAM ASST.</span>
        <span class="px-2 py-1 bg-green-200">MENTO-GADS</span>
      </section>
    </div>
    <div>I</div>
  </section>
</template>

<script setup lang="ts"></script>

<style scoped>
.resource_avatar {
  border-radius: 50%;
  height: auto;
  width: 60px;
}
</style>
