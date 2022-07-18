<script setup>
import autosize from 'autosize'
import { nextTick, onMounted, ref } from 'vue'
import Icon from '@/Components/Icon.vue'

const props = defineProps(['onInput'])

const emit = defineEmits(['up', 'down'])

const creating = ref(false)
const name = ref('')

const nameInput = ref(null)

onMounted(() => autosize(nameInput.value))

const create = async (event) => {
  if (event.target.value.trim() === '' || creating.value) {
    return
  }

  creating.value = true

  await props.onInput({ name: name.value })

  name.value = ''
  creating.value = false

  nextTick(() => {
    autosize.update(nameInput.value)
    nameInput.value.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
  })
}

const up = () => {
  if (nameInput.value.selectionStart === 0 && nameInput.value.selectionStart === 0) {
    emit('up')
  }
}

const down = () => {
  if (nameInput.value.selectionStart === nameInput.value.value.length && nameInput.value.selectionStart === nameInput.value.value.length) {
    emit('down')
  }
}

defineExpose({ focus: () => nameInput.value.focus() })
</script>

<template>
  <form
    class="py-1 md:py-2 border-b border-gray-200 dark:border-gray-700 flex"
    @submit.prevent="create"
  >
    <div class="border border-transparent flex-shrink-0">
      <div class="relative h-10 w-10 md:h-8 md:w-8 flex items-center justify-center">
        <div
          v-show="creating"
          class="absolute inset-0 border border-transparent flex items-center justify-center"
        >
          <Icon
            name="medium/spinner"
            class="h-10 w-10 md:h-8 md:w-8 animate-spin text-gray-400"
          />
        </div>
        <Icon
          name="small/bullet"
          class="h-5 w-5 text-gray-200 dark:text-gray-700"
        />
      </div>
    </div>

    <div class="flex-1">
      <textarea
        ref="nameInput"
        v-model="name"
        :disabled="creating"
        class="w-full p-2 md:p-1 text-gray-900 dark:text-gray-100 overflow-hidden bg-transparent border-none disabled:opacity-50 placeholder-gray-300 dark:placeholder-gray-600 focus:ring-0"
        style="resize: none; height: 1em;"
        rows="1"
        maxlength="255"
        placeholder="Unburden your mind..."
        @keydown.up="up"
        @keydown.down="down"
        @keydown.enter.exact.prevent="create"
        @blur="create"
      />
    </div>
  </form>
</template>
