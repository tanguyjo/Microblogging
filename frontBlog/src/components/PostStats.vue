<script setup lang="ts">
import { ref, onMounted } from "vue";

const props = defineProps<{
  postId: number;
  likes: number;
  comments: number;
}>();

const liked = ref(false);
const likeId = ref<number | null>(null);
const likeCount = ref(props.likes);

const showPopup = ref(false);
const commentText = ref("");

// Vérifier si l'utilisateur a liké ce post
onMounted(async () => {
  const token = localStorage.getItem("token");
  if (!token) return;

  try {
    const res = await fetch(
      `http://localhost:8000/api/posts/${props.postId}/likes`,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );
    const data = await res.json();
    const existingLike = data.find((like: any) => like.user_id); // Vérifie que le like existe
    if (existingLike) {
      liked.value = true;
      likeId.value = existingLike.id;
    }
  } catch (error) {
    console.error("Failed to fetch likes", error);
  }
});

async function toggleLike() {
  const token = localStorage.getItem("token");
  if (!token) {
    alert("You must be logged in to like posts.");
    return;
  }

  if (liked.value) {
    try {
      await fetch(`http://localhost:8000/api/likes/${likeId.value}`, {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      liked.value = false;
      likeId.value = null;
      likeCount.value--;
    } catch (error) {
      console.error("Error unliking:", error);
    }
  } else {
    try {
      const res = await fetch("http://localhost:8000/api/likes", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({ post_id: props.postId }),
      });
      const data = await res.json();
      liked.value = true;
      likeId.value = data.id;
      likeCount.value++;
    } catch (error) {
      console.error("Error liking:", error);
    }
  }
}

const emit = defineEmits(["comment-added"]);

async function submitComment() {
  const content = commentText.value.trim();
  const token = localStorage.getItem("token");

  if (!content) return;

  if (!token) {
    alert("You must be logged in to comment.");
    return;
  }

  try {
    const res = await fetch("http://localhost:8000/api/comments", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({
        post_id: props.postId,
        content,
      }),
    });

    if (!res.ok) throw new Error("Failed to send comment");

    const newComment = await res.json();
    emit("comment-added", newComment);

    commentText.value = "";
    showPopup.value = false;
  } catch (err) {
    console.error("Comment error:", err);
    alert("Failed to submit comment.");
  }
}

function cancelComment() {
  commentText.value = "";
  showPopup.value = false;
}
</script>

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
      {{ likeCount }}
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
          <button @click="cancelComment" class="px-3 py-1 text-sm text-red-500">
            Cancel
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>
