<template>
    <div>
        <h1 class="font-semibold text-2xl">New Task</h1>

        <form class="mt-10">
            <!-- Title -->
            <Input label="Title" placeholder="Enter a title" hint="The title must contain a maximum of 32 characters" />
            
            <Textarea placeholder="Enter task details" label="Details"/>
        
            <!-- Add Mentor Manager -->
            <ResourceSelector />

            <!-- Add Mentor -->

            <!-- Mentor or Mentor Manager selection list -->

            <!-- Create Task button -->
            <PrimaryBtn title="Create Task"/>
        </form>
    </div>
</template>

<script setup lang="ts">
import PrimaryBtn from '@/components/Buttons/PrimaryBtn.vue';
import ResourceSelector from '@/components/Common/ResourceSelector.vue';
import Input from '@/components/Forms/Input.vue'
import Textarea from '@/components/Forms/Textarea.vue'
</script>