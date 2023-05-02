<template>
    <div class="py-4 flex flex-col">
        <label v-if="label" class="text-xl mb-2 font-semibold">{{ label }}</label>
        <textarea 
            rows="10" 
            required 
            :placeholder="placeholder" 
            class=" p-4 outline-0 border font-light border-red-400 rounded-md focus:border-green-200">
        </textarea>
    </div>
</template>

<script setup lang="ts">
type Props = {
    label?: string
    placeholder?: string
}

defineProps<Props>()
</script>