<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import PostTitle from "@/components/PostTitle.vue";
import PostStats from "@/components/PostStats.vue";
import TagBadge from "@/components/TagBadge.vue";
import CommentItem from "@/components/CommentItem.vue";

const route = useRoute();
const postId = Number(route.params.id);

const post = ref<Post | null>(null);
const isLoading = ref(true);
const error = ref<string | null>(null);

interface User {
  id: number;
  username: string;
  email: string;
  bio: string;
  avatar_url: string;
  created_at: string;
  updated_at: string;
}

interface CommentType {
  id: number;
  user: User;
  content: string;
  created_at: string;
  updated_at: string;
}

interface Post {
  id: number;
  user_id: number;
  title: string;
  content: string;
  status: string;
  visibility: string;
  created_at: string;
  updated_at: string;
  user: User;
  tags?: string[];
  likes?: number;
  comments_data?: CommentType[];
}

const currentUsername = localStorage.getItem("username") || "anonymous";

onMounted(async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/posts/${postId}`, {
      credentials: "include",
    });
    if (!response.ok) {
      throw new Error("Post not found.");
    }
    const postData = await response.json();
    post.value = postData;
  } catch (err) {
    error.value = err instanceof Error ? err.message : "An error occurred.";
  } finally {
    isLoading.value = false;
  }
});

// 🆕 Ajoute dynamiquement le commentaire à la liste
function addNewComment(comment: CommentType) {
  if (post.value) {
    const enrichedComment: CommentType = {
      ...comment,
      user: {
        id: 0,
        username: currentUsername,
        email: "",
        bio: "",
        avatar_url: "",
        created_at: "",
        updated_at: "",
      },
    };

    post.value.comments_data = [
      enrichedComment,
      ...(post.value.comments_data || []),
    ];
  }
}

const formatDate = (date: string) => {
  const d = new Date(date);
  const day = d.getDate().toString().padStart(2, "0");
  const month = (d.getMonth() + 1).toString().padStart(2, "0");
  const year = d.getFullYear();
  const hours = d.getHours().toString().padStart(2, "0");
  const minutes = d.getMinutes().toString().padStart(2, "0");

  return `${day}/${month}/${year} ${hours}:${minutes}`;
};
</script>

<template>
  <div class="max-w-3xl mx-auto px-4 pt-8 pb-16">
    <!-- Back button -->
    <RouterLink
      to="/"
      class="flex items-center text-darkviolet hover:underline mb-6"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 mr-2"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
        />
      </svg>
      Back to posts
    </RouterLink>

    <div v-if="post">
      <!-- Title -->
      <PostTitle :title="post.title" class="mb-4 text-purple-600 text-2xl" />

      <!-- Date + author -->
      <p class="text-sm text-gray-600 mb-2" v-if="post.user">
        {{ formatDate(post.created_at) }} — @{{ post.user.username }}
      </p>

      <!-- Content -->
      <p class="text-gray-800 leading-relaxed mb-4">
        {{ post.content }}
      </p>

      <!-- Stats -->
      <PostStats
        :likes="post.likes || 0"
        :comments="post.comments_data?.length || 0"
        :post-id="post.id"
        :is-detail-page="true"
        @comment-added="addNewComment"
        class="mb-4"
      />

      <!-- Tags -->
      <div class="mt-4 flex flex-wrap gap-2">
        <TagBadge v-for="tag in post.tags" :key="tag" :label="tag" />
      </div>

      <!-- Comments -->
      <div class="mt-10">
        <h2 class="text-xl font-bold text-purple-700 mb-4">
          Comments ({{ post.comments_data?.length || 0 }})
        </h2>
        <div v-if="post.comments_data && post.comments_data.length">
          <CommentItem
            v-for="comment in post.comments_data"
            :key="comment.id"
            :comment="{
              author: comment.user.username,
              created_at: comment.created_at,
              content: comment.content,
            }"
          />
        </div>
        <p v-else class="text-gray-500">No comments for this post.</p>
      </div>
    </div>

    <div v-else>
      <p class="text-red-500">{{ error }}</p>
    </div>
  </div>
</template>
