<script setup>
import autosize from 'autosize'
import { computed, onMounted, ref, watch } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import dayjs from 'dayjs'
import Icon from '@/Components/Icon.vue'

const props = defineProps([
  'bullet',
  'type',
  'props',
  'fade',
  'enableMigrateForward',
  'draggable',
  'onInput',
  'onMigrate',
  'onMigrateTo',
  'onMigrateToDailyLog',
  'onDelete',
])

const emit = defineEmits(['up', 'down'])

const dirty = ref(false)
const processing = ref(false)
const name = ref(props.bullet.name)
const state = ref(props.bullet.state)
const menu = ref(false)
const showingMigration = ref(false)

const complete = computed({
  get() {
    return state.value === 'complete'
  },
  set(newValue) {
    state.value = newValue ? 'complete' : 'incomplete'
  }
})

const mine = computed(() => props.bullet.user_id === usePage().props.value.user.id)

watch(state, async (state) => {
  processing.value = true
  await props.onInput({ id: props.bullet.id, state })
  processing.value = false
})

watch(name, () => dirty.value = true)

const nameInput = ref(null)

onMounted(() => autosize(nameInput.value))

const save = async () => {
  if (!dirty.value) {
    return
  }

  processing.value = true

  await props.onInput({ id: props.bullet.id, name: name.value })

  processing.value = false
  dirty.value = false
}

const toggleInDailyLog = async () => {
  if (props.bullet.collection_id === null) {
    return
  }

  processing.value = true

  await props.onInput({ id: props.bullet.id, date: props.bullet.date ? null : dayjs().startOf('day').format('YYYY-MM-DD') })

  processing.value = false
}

const migrate = async () => {
  processing.value = true

  await props.onMigrate(props.bullet)

  processing.value = false
}

const migrateTo = async (collection) => {
  processing.value = true

  await props.onMigrateTo(props.bullet, collection)

  processing.value = false
}

const migrateToDailyLog = async () => {
  processing.value = true

  await props.onMigrateToDailyLog(props.bullet)

  processing.value = false
}

const destroy = async () => {
  processing.value = true

  await props.onDelete(props.bullet)

  processing.value = false
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
  <div>
    <div class="bullet-body py-1 md:py-2 flex">
      <div
        class="relative shrink-0"
        :class="$slots.tags ? 'mt-3 lg:mt-0' : ''"
      >
        <template v-if="type === 'bullet'">
          <div
            class="border border-transparent"
            :class="fade"
          >
            <button
              class="relative h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-2xl disabled:opacity-50"
              :class="[
                complete ? 'text-gray-500 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100',
                processing ? 'cursor-default' : 'hover:border-gray-200 dark:hover:border-gray-600 hover:shadow focus:outline-none focus:border-gray-200 dark:focus:border-gray-600 focus:shadow-inner'
              ]"
              :disabled="processing"
              @click="menu = true"
            >
              <div
                v-show="processing"
                class="absolute inset-0 border border-transparent flex items-center justify-center"
              >
                <Icon
                  name="medium/spinner"
                  class="h-10 w-10 md:h-8 md:w-8 animate-spin text-gray-400"
                />
              </div>
              <Icon
                v-show="state === 'incomplete'"
                name="small/bullet"
                class="h-6 w-6 md:h-5 md:w-5"
              />
              <Icon
                v-show="state === 'complete'"
                name="small/x"
                class="h-6 w-6 md:h-5 md:w-5"
              />
            </button>
          </div>

          <div
            v-show="menu"
            class="fixed inset-0 z-40"
            @click="menu = false; showingMigration = false"
          />

          <Transition
            enter-active-class="transition ease-out duration-200"
            enter-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <div
              v-show="menu"
              class="absolute top-0 left-0 -ml-2 rounded-2xl text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-500 bg-white dark:bg-gray-700 shadow-xl z-50 overflow-hidden"
              @blur="menu = false; showingMigration = false"
              @xclick="menu = false; showingMigration = false"
            >
              <div class="px-2 flex items-center text-2xl">
                <button
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none"
                  @click="menu = false; showingMigration = false"
                >
                  <Icon
                    v-if="state === 'complete'"
                    name="small/x"
                    class="h-6 w-6 md:h-5"
                  />
                  <Icon
                    v-if="state === 'incomplete'"
                    name="small/bullet"
                    class="h-6 w-6 md:h-5"
                  />
                </button>

                <button
                  v-if="state !== 'incomplete'"
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none"
                  title="Mark as incomplete"
                  @click="state = 'incomplete'; menu = false"
                >
                  <Icon
                    name="small/bullet"
                    class="w-6 h-6 md:w-5 md:h-5"
                  />
                </button>

                <button
                  v-else-if="state !== 'complete'"
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none"
                  title="Mark as complete"
                  @click="state = 'complete'; menu = false"
                >
                  <Icon
                    name="small/x"
                    class="w-6 h-6 md:w-5 md:h-5"
                  />
                </button>

                <button
                  v-if="enableMigrateForward && bullet.date && dayjs(bullet.date).isBefore(dayjs().startOf('day'))"
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none"
                  title="Migrate forward"
                  @click="migrate(); menu = false"
                >
                  <Icon
                    name="small/chevron-up"
                    class="h-6 w-6 md:h-5 md:w-5"
                  />
                </button>

                <button
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none"
                  title="Migrate to collection"
                  @click="showingMigration = ! showingMigration"
                >
                  <Icon
                    name="small/chevron-right"
                    class="h-6 w-6 md:h-5 md:w-5"
                  />
                </button>

                <button
                  v-if="bullet.collection_id !== null"
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center"
                  :class="[
                    bullet.date && mine ? 'text-pink-600' : '',
                    mine ? 'hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none' : 'text-gray-600 cursor-pointer',
                  ]"
                  :disabled="! mine"
                  :title="mine ? (bullet.date ? 'Hide in daily log' : 'Show in daily log') : 'Unable to show in daily log'"
                  @click="toggleInDailyLog(); menu = false"
                >
                  <Icon
                    name="medium/calendar"
                    class="h-6 w-6 md:h-5 md:w-5"
                  />
                </button>

                <button
                  class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-800 focus:bg-gray-100 dark:focus:bg-gray-800 focus:outline-none"
                  title="Delete"
                  @click="destroy(); menu = false"
                >
                  <Icon
                    name="small/trash"
                    class="h-6 w-6 md:w-5 md:h-5"
                  />
                </button>
              </div>

              <div
                v-if="showingMigration"
                class="pb-1 border-t border-gray-200 dark:border-gray-600"
              >
                <div
                  v-if="$page.props.collections.length === 0"
                  class="px-4 py-1 leading-loose text-gray-500 whitespace-nowrap"
                >
                  No collections available
                </div>
                <button
                  v-if="bullet.collection_id !== null"
                  class="block w-full text-left px-4 py-1 leading-loose font-medium whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-800"
                  @click="migrateToDailyLog(); menu = false"
                >
                  <Icon
                    name="small/chevron-right"
                    class="w-5 h-5"
                  />
                  Daily Log
                </button>
                <template v-for="collection in $page.props.collections">
                  <button
                    v-if="collection.id !== bullet.collection_id"
                    :key="collection.id"
                    class="block w-full text-left px-4 py-1 leading-loose font-medium whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-800"
                    @click="migrateTo(collection); menu = false"
                  >
                    <Icon
                      name="small/chevron-right"
                      class="w-5 h-5"
                    />
                    {{ collection.name }}
                  </button>
                </template>
                <template v-for="collection in $page.props.sharedCollections">
                  <button
                    v-if="collection.id !== bullet.collection_id"
                    :key="collection.id"
                    class="block w-full text-left px-4 py-1 leading-loose font-medium whitespace-nowrap hover:bg-gray-100 dark:hover:bg-gray-800"
                    @click="migrateTo(collection); menu = false"
                  >
                    <Icon
                      name="small/chevron-right"
                      class="w-5 h-5"
                    />
                    {{ collection.name }}
                  </button>
                </template>
              </div>
            </div>
          </Transition>
        </template>

        <template v-else-if="type === 'checklist'">
          <div class="border border-transparent">
            <div class="relative h-10 w-10 md:h-8 md:w-8 flex items-center justify-center">
              <div
                v-show="processing"
                class="absolute inset-0 border border-transparent flex items-center justify-center"
              >
                <Icon
                  name="medium/spinner"
                  class="h-10 w-10 md:h-8 md:w-8 animate-spin text-gray-400"
                />
              </div>
              <input
                v-model="complete"
                type="checkbox"
                class="relative h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-900"
                :class="{ 'opacity-0': processing }"
                :disabled="processing"
              >
            </div>
          </div>
        </template>
      </div>

      <div class="flex-1 flex flex-col flex-col-reverse lg:flex-row">
        <div class="lg:flex-1">
          <textarea
            ref="nameInput"
            v-model="name"
            :disabled="processing"
            class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 focus:ring-0"
            :class="[
              fade,
              complete ? 'text-gray-500 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100'
            ]"
            style="resize: none;"
            rows="1"
            maxlength="255"
            spellcheck="false"
            @keydown.up="up"
            @keydown.down="down"
            @blur="$event.target.value.trim() !== '' ? save() : destroy()"
          />
        </div>
        <div
          v-if="$slots.tags"
          class="mt-1 -mb-1 md:mb-0 lg:mb-0 ml-2 md:ml-1 lg:shrink-0"
        >
          <slot name="tags" />
        </div>
      </div>

      <div class="shrink-0">
        <div class="flex items-center">
          <slot name="status" />

          <button
            v-if="draggable"
            class="drag-handle p-2"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4 text-gray-400 dark:text-gray-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 8h16M4 16h16"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div
      class="border-b border-gray-200 dark:border-gray-700"
      :class="fade"
    />
  </div>
</template>
