<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";

interface User {
  id: number;
  username: string;
  email: string;
  bio: string;
  avatar_url: string;
  created_at: string;
  updated_at: string;
}

const user = reactive<User>({
  id: 0,
  username: "",
  email: "",
  bio: "",
  avatar_url: "",
  created_at: "",
  updated_at: "",
});

const form = reactive({
  username: "",
  email: "",
  bio: "",
  password: "",
  confirmPassword: "",
});

const error = ref("");
const success = ref("");

onMounted(async () => {
  try {
    const token = localStorage.getItem("token");
    const res = await fetch("http://localhost:8000/api/user", {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
      },
    });

    if (!res.ok) throw new Error("Failed to fetch user");

    const data = await res.json();
    Object.assign(user, data);

    form.username = user.username;
    form.email = user.email;
    form.bio = user.bio;
  } catch (err) {
    error.value = (err as Error).message;
  }
});

async function handleSubmit() {
  const token = localStorage.getItem("token");
  if (!token) {
    error.value = "User not authenticated.";
    return;
  }

  if (form.password && form.password !== form.confirmPassword) {
    error.value = "Passwords do not match.";
    return;
  }

  try {
    const res = await fetch("http://localhost:8000/api/user", {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
      },
      body: JSON.stringify({
        username: form.username,
        email: form.email,
        bio: form.bio,
        ...(form.password ? { password: form.password } : {}),
      }),
    });

    if (!res.ok) throw new Error("Failed to update user.");

    success.value = "Profile updated successfully.";
    error.value = "";
    form.password = "";
    form.confirmPassword = "";
  } catch (err) {
    success.value = "";
    error.value = (err as Error).message;
  }
}

function resetForm() {
  form.username = user.username;
  form.email = user.email;
  form.bio = user.bio;
  form.password = "";
  form.confirmPassword = "";
}
</script>

<template>
  <div class="md:flex">
    <!-- SideNav desktop -->
    <SideNav class="hidden md:block w-20 shrink-0" />

    <!-- Contenu principal -->
    <main class="w-full px-4 pb-24 max-w-5xl mx-auto font-sans">
      <h2 class="text-3xl font-title text-center mt-8 mb-10">Edit profile</h2>

      <form
        @submit.prevent="handleSubmit"
        class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center items-start"
      >
        <!-- Avatar -->
        <!-- <label class="block font-medium mb-1" for="avatar">Avatar</label> -->

        <div
          class="flex flex-col items-center border p-4 rounded w-full max-w-xs h-[130px]"
        >
          <div
            class="w-20 h-20 bg-purple-500 text-white rounded-full flex items-center justify-center text-xl font-semibold"
          >
            {{ user.username.charAt(0).toUpperCase() || "U" }}
          </div>
          <span class="mt-3 text-sm font-semibold text-center"
            >Edit picture</span
          >
        </div>

        <!-- Bio -->
        <div class="w-full h-[130px]">
          <label class="block font-medium mb-1" for="bio">Bio</label>
          <textarea
            id="bio"
            v-model="form.bio"
            placeholder="Live, Laugh, Love"
            class="w-full h-full border rounded p-2 resize-none"
          />
        </div>

        <!-- Username -->
        <div class="w-full">
          <label class="block font-medium mb-1" for="username">Username</label>
          <input
            id="username"
            v-model="form.username"
            type="text"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Password -->
        <div class="w-full">
          <label class="block font-medium mb-1" for="password">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Email -->
        <div class="w-full">
          <label class="block font-medium mb-1" for="email">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Confirm Password -->
        <div class="w-full">
          <label class="block font-medium mb-1" for="confirmPassword"
            >Confirm password</label
          >
          <input
            id="confirmPassword"
            v-model="form.confirmPassword"
            type="password"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Buttons -->
        <div class="col-span-full flex justify-center gap-4 mt-2">
          <button
            type="submit"
            class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700"
          >
            SAVE
          </button>
          <button
            type="button"
            @click="resetForm"
            class="px-6 py-2 border border-gray-400 text-gray-700 rounded hover:bg-gray-100"
          >
            CANCEL
          </button>
        </div>

        <p
          v-if="error"
          class="text-red-500 text-center col-span-full mt-2 font-semibold"
        >
          {{ error }}
        </p>
        <p
          v-if="success"
          class="text-green-600 text-center col-span-full mt-2 font-semibold"
        >
          {{ success }}
        </p>
      </form>
    </main>

    <!-- BottomNav mobile -->
    <BottomNav class="block md:hidden fixed bottom-0 left-0 w-full" />
  </div>
</template>
