<template>
  <div class="pCard w-3/5 gap-4 flex flex-col">
    <div class="flex items-center mb-2">
      <img :src="gads" alt="gads logo" />
      <div class="flex flex-col g-2 ml-6">
        <h1 class="font-normal text-lg">GADS Program 2022</h1>
        <div class="flex g-4 items-center">
          <small>50%</small>
          <v-progress-linear
            color="#058b94"
            rounded
            model-value="50"
            height="8"
          ></v-progress-linear>
        </div>
      </div>
    </div>
    <div>
      <p>June 13, 2022 -> Feb 10, 2023</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { gads } from "../../../assets/images";
</script>

<style scoped lang="scss">
.pCard {
  padding: 15px;
  border-radius: 7px;
  background-color: var(--card-light);
  cursor: pointer;

  &:hover {
    background-color: var(--card-light-hover);
  }

  p,
  small {
    color: var(--text-inactive);
  }
}
</style>
