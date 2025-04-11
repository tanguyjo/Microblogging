<template>
  <div class="flex items-center gap-4 text-sm text-darkviolet relative">
    <!-- Like Button -->
    <button
      @click="toggleLike"
      class="flex items-center gap-1 bg-transparent focus:outline-none border-none p-0"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        :fill="liked ? 'currentColor' : 'none'"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-5 h-5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.687 3.75 5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"
        />
      </svg>
      {{ likes }}
    </button>

    <!-- Comment Button -->
    <button
      @click="showPopup = true"
      class="flex items-center gap-1 bg-transparent focus:outline-none border-none p-0"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25-9 3.694-9 8.25c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z"
        />
      </svg>
      {{ comments }}
    </button>

    <!-- Comment Popup -->
    <transition name="fade-scale">
      <div
        v-if="showPopup"
        class="absolute z-10 w-96 bg-white p-4 border rounded shadow-md mt-2 right-0 animate-popup"
      >
        <textarea
          v-model="commentText"
          class="w-full p-2 border rounded mb-2"
          placeholder="Write a comment..."
        />
        <div class="flex justify-end gap-2">
          <button
            @click="submitComment"
            class="px-3 py-1 bg-darkviolet text-white rounded text-sm"
          >
            Comment
          </button>
          <button
            @click="cancelComment"
            class="px-3 py-1 text-sm text-red-500 bg-transparent border-none focus:outline-none"
          >
            Cancel
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

defineProps<{ likes: number; comments: number }>();

const liked = ref(false);
const showPopup = ref(false);
const commentText = ref("");

function toggleLike() {
  liked.value = !liked.value;
}

function submitComment() {
  if (commentText.value.trim()) {
    console.log("Comment submitted:", commentText.value);
    commentText.value = "";
    showPopup.value = false;
  }
}

function cancelComment() {
  commentText.value = "";
  showPopup.value = false;
}
</script>

<style scoped>
.fade-scale-enter-active {
  transition: all 0.2s ease-out;
}
.fade-scale-leave-active {
  transition: all 0.15s ease-in;
}
.fade-scale-enter-from {
  opacity: 0;
  transform: scale(0.95);
}
.fade-scale-enter-to {
  opacity: 1;
  transform: scale(1);
}
.fade-scale-leave-from {
  opacity: 1;
  transform: scale(1);
}
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
