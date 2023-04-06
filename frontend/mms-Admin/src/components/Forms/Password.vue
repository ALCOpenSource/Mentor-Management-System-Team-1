<template>
  <div class="pass">
    <v-text-field :rules="[rules.required, rules.min]" :type="show ? 'text' : 'password'" hint="At least 8 characters"
      placeholder="Password" variant="solo" required 
      v-model="password"
      @input="$emit('update:password', password)"
      >
    </v-text-field>
    <img @click="show = !show" :src="show ? eyeHide : eyeShow" alt="eye" class="eye">
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import eyeShow from '../../assets/images/eye-password-hide 1.png'
import eyeHide from '../../assets/images/eye-password-show 1.png'

const show = ref(false)
const password = ref('')
const rules = {
  required: (v: string) => !!v || 'Password Required.',
  min: (v: string) => v.length >= 8 || 'Min 8 characters',
}

defineEmits(['update:password'])

</script>

<style scoped lang="scss">
.pass {
  position: relative;

  .eye {
    position: absolute;
    top: 0;
    right: 0;
    width: 20px;
    height: 20px;
    margin-top: 18px;
    margin-right: 15px;
    cursor: pointer;
  }
}
</style>