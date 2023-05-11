<template>
  <div class="flex justify-between items-center">
        <div class="flex items-center">
          <v-avatar size="90px">
            <v-img
              src="https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png"
              lazy-src="https://www.caribbeangamezone.com/wp-content/uploads/2018/03/avatar-placeholder.png"
              alt="John"
            ></v-img>
          </v-avatar>
          <div class="ml-6">
            <div class="flex items-center">
              <h1 class="mr-2 text-xl font-semibold">Allison Davies</h1>
              <NigerianFlag />
            </div>
            <p class="text-[#808080] flex gap-2 items-center">
              Mentor
              <span>
                <Edit class="cursor-pointer" />
              </span>
            </p>
          </div>
        </div>
        <div class="flex gap-4">
          <!-- Handle routing to specified chat -->
          <router-link to="/admin/messages">
            <PrimaryBtn title="Send Message" />
          </router-link>
          <router-link 
            :to="isMentorManager ? '/admin/mentor-managers' : '/admin/mentors'"
          >
            <SecondaryBtn title="Close" />
          </router-link>
        </div>
      </div>
</template>

<script setup lang="ts">
import { NigerianFlag, Edit } from '@/assets/icons';
import PrimaryBtn from '@/components/Buttons/PrimaryBtn.vue';
import SecondaryBtn from '@/components/Buttons/SecondaryBtn.vue';

defineProps({
  isMentor: {
    type: Boolean,
    default: false,
  },
  isMentorManager: {
    type: Boolean,
    default: false,
  },
})
</script>

<style scoped>

</style>