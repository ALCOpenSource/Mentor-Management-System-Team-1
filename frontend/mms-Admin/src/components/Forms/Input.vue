<template>
    <div class="flex flex-col">
        <label v-if="label" class="text-xl mb-2 font-semibold" :for="label">{{ label }}</label>
        <v-text-field
            v-model="inputVal"
            variant="solo"
            :placeholder="placeholder"
            required
            :hint="hint"
            :rules="inputRules"
            @input="$emit('update:textInput', inputVal)"
        >
        </v-text-field>
    </div>
</template>

<script setup lang="ts">
import {ref} from 'vue'
type Props = {
    placeholder: string;
    label?: string;
    rules?: string[];
    hint?: string;
}

defineEmits(["update:textInput"])

const inputVal = ref("")
const inputRules = [
    (value: string) => Boolean(value) || `A value is required`
]

defineProps<Props>() 

</script>