<template>
  <div class="border border-gray-200 w-full rounded-md">
    <section>
      <!-- REPORT HEADER -->
      <div class="flex gap-8 p-4">
        <IconTask size="50" color="#058B94" />
        <div>
          <h3 class="text-2xl font-bold">
            Room library article write fluent api the easy way
          </h3>
          <div class="flex gap-4">
            <p>By Alison Davis -</p>
            <p>19th - 25th Oct 22</p>
          </div>
        </div>
      </div>

      <!-- REPORT BODY -->
      <div class="bg-green-100 p-4">
        <div class="flex flex-col gap-16">
          <section>
            <h2 class="text-xl font-bold mb-2">Major Achievement</h2>
            <p class="text-gray-400">
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
            <h2 class="text-xl font-bold mb-2">Major Achievement</h2>
            <p class="text-gray-400">
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
            <h2 class="text-xl font-bold mb-2">Major Achievement</h2>
            <p class="text-gray-400">
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
          <OutlineBtn title="Share" />
          <PrimaryBtn title="Download" />
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import OutlineBtn from "../Buttons/OutlineBtn.vue";
import PrimaryBtn from "../Buttons/PrimaryBtn.vue";
import { IconTask } from "../Icons";
</script>

<style></style>
