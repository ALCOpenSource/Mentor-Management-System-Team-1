<template>
  <div class="border border-gray-200 w-full rounded-md">
    <section>
      <!-- REPORT HEADER -->
      <div class="flex justify-between items-center p-4">
        <div class="flex gap-8">
          <IconTask size="50" color="#058B94" />
          <div>
            <h3 class="text-lg 2xl:text-xl font-semibold">
              Room library article write fluent api the easy way
            </h3>
            <p class="text-xs text-gray-300">
              <span class="font-[500]">By Allison Davies - </span> 19th - 25th
              Oct 22
            </p>
          </div>
        </div>
        <router-link :to="{ name: 'reports' }">
          <Close class="cursor-pointer" />
        </router-link>
      </div>

      <!-- REPORT BODY -->
      <div class="bg-green-100 p-4">
        <div class="flex flex-col gap-8">
          <section>
            <h2 class="text-lg 2xl:text-xl font-semibold">Major Achievement</h2>
            <p class="text-gray-400 text-sm 2xl:text-base">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et
              massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien
              fringilla, mattis ligula consectetur, ultrices mauris. Maecenas
              vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum
              auctor ornare leo, non suscipit magna interdum eu. Curabitur
              pellentesque nibh nibh, at maximus ante fermentum sit amet.
              Pellentesque commodo lacus at sodales sodales. Quisque sagittis
              orci ut diam condimentum, vel euismod erat placerat.
            </p>
          </section>
          <section>
            <h2 class="text-lg 2xl:text-xl font-semibold mb-2">
              Major Achievement
            </h2>
            <p class="text-gray-400 text-sm 2xl:text-base">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et
              massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien
              fringilla, mattis ligula consectetur, ultrices mauris. Maecenas
              vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum
              auctor ornare leo, non suscipit magna interdum eu. Curabitur
              pellentesque nibh nibh, at maximus ante fermentum sit amet.
              Pellentesque commodo lacus at sodales sodales. Quisque sagittis
              orci ut diam condimentum, vel euismod erat placerat.
            </p>
          </section>
          <section>
            <h2 class="text-lg 2xl:text-xl font-semibold mb-2">
              Major Achievement
            </h2>
            <p class="text-gray-400 text-sm 2xl:text-base">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et
              massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien
              fringilla, mattis ligula consectetur, ultrices mauris. Maecenas
              vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum
              auctor ornare leo, non suscipit magna interdum eu. Curabitur
              pellentesque nibh nibh, at maximus ante fermentum sit amet.
              Pellentesque commodo lacus at sodales sodales. Quisque sagittis
              orci ut diam condimentum, vel euismod erat placerat.
            </p>
          </section>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex justify-between mt-10">
          <SecondaryBtn title="Share" />
          <PrimaryBtn title="Download" />
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import SecondaryBtn from "../Buttons/SecondaryBtn.vue";
import { IconTask } from "../Icons";
import { Close } from "@/assets/icons";
</script>

<style></style>
