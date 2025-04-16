<script setup lang="ts">
import { ref, watch } from 'vue';
import { onClickOutside } from '@vueuse/core';

const props = defineProps<{
  isOpen: boolean;
  selectedHashtag: string | null;
  availableHashtags: string[];
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'select', hashtag: string | null): void;
}>();

const popupRef = ref<HTMLElement | null>(null);

// Close popup when clicking outside
onClickOutside(popupRef, () => {
  emit('close');
});
</script>

<template>
  <Transition name="fade">
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div 
        ref="popupRef"
        class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all"
      >
        <div class="flex flex-col gap-4">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
              Filter by Hashtag
            </h3>
            <button
              @click="emit('close')"
              class="text-gray-400 hover:text-gray-600"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <div class="flex flex-wrap gap-2">
            <button
              @click="emit('select', null)"
              :class="[
                'px-4 py-2 rounded-full text-sm transition-colors',
                !selectedHashtag ? 'bg-purple-600 text-white' : 'bg-gray-200 hover:bg-gray-300'
              ]"
            >
              All Posts
            </button>
            <button
              v-for="tag in availableHashtags"
              :key="tag"
              @click="emit('select', tag)"
              :class="[
                'px-4 py-2 rounded-full text-sm transition-colors',
                selectedHashtag === tag ? 'bg-purple-600 text-white' : 'bg-gray-200 hover:bg-gray-300'
              ]"
            >
              #{{ tag }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style> 