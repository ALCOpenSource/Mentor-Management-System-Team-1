<template>
  <div
    class="bg-green-200 pl-4 py-2 pr-12 2xl:pr-20 flex gap-4 items-center justify-between mb-2"
  >
    <div class="flex items-center gap-5">
      <div class="flex items-center gap-4">
        <section>
          <IconMentor v-if="type === 'mentor'" color="#058B94" size="30" />
          <IconReport v-if="type === 'reports'" color="#058B94" size="30" />
          <IconMentorManagers
            v-if="type === 'mentor-managers'"
            color="#058B94"
            size="30"
          />
        </section>
        <span class="text-[26px] 2xl:text-[32px] font-bold">{{ count }}</span>
        <span class="text-base 2xl:text-xl font-semibold">{{ text }}</span>
      </div>
      <span
        class="h-7 mb-2 text-white font-semibold text-sm flex items-center justify-center w-7 bg-red-400 rounded-full p-4"
        v-if="type === 'reports'"
      >
        {{ unread }}
      </span>
    </div>
    <div class="w-[60px]">
      <router-link
        :to="{
          name: urlName,
          params: { id: `${programId}` },
        }"
      >
        <SmallPrimaryBtn title="View" :full-width="true" />
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
import SmallPrimaryBtn from "../Buttons/SmallPrimaryBtn.vue";
import { IconMentorManagers, IconMentor, IconReport } from "../Icons";

type Props = {
  count: string;
  text: string;
  unread?: string;
  type: "mentor" | "mentor-managers" | "reports";
  urlName?: string;
  programId?: Number;
};

defineProps<Props>();
</script>
