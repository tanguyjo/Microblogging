<script setup lang="ts">
import { ref, reactive, computed, onMounted } from "vue";
import { useRouter } from "vue-router"; // ⬅️ nouveau
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";

const router = useRouter(); // ⬅️ initialisation

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

const canSubmit = computed(() => {
  const pwd = form.password.trim();
  const confirm = form.confirmPassword.trim();
  if (!pwd && !confirm) return true;
  return pwd && confirm && pwd === confirm;
});

onMounted(async () => {
  try {
    const res = await fetch("http://localhost:8000/api/user", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
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
  try {
    error.value = "";
    success.value = "";

    const payload = {
      username: form.username,
      email: form.email,
      bio: form.bio,
      ...(form.password ? { password: form.password } : {}),
    };

    const res = await fetch("http://localhost:8000/api/user", {
      method: "PUT",
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    if (!res.ok) throw new Error("Failed to update user");

    const updated = await res.json();
    Object.assign(user, updated);
    resetForm();

    // ✅ redirection vers le profil avec message de succès
    router.push({ name: "Profile", query: { success: "updated" } });
  } catch (err) {
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

function cancelEdit() {
  router.push({ name: "Profile" }); // ⬅️ redirection simple
}
</script>

<template>
  <div class="md:flex">
    <SideNav class="hidden md:block w-20 shrink-0" />

    <main class="w-full px-4 pb-24 max-w-5xl mx-auto font-sans">
      <h2 class="text-3xl font-title text-center mt-8 mb-10">Edit profile</h2>

      <form
        @submit.prevent="handleSubmit"
        class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start"
      >
        <!-- Avatar -->
        <div class="flex flex-col items-center w-full max-w-xs mx-auto">
          <label class="block font-medium mb-1 w-full text-left">Avatar</label>
          <div class="border p-4 rounded w-full flex flex-col items-center">
            <div
              class="w-20 aspect-square bg-darkviolet text-white rounded-full flex items-center justify-center text-3xl font-title"
            >
              {{ user.username.charAt(0).toUpperCase() || "U" }}
            </div>
            <span class="mt-3 text-sm font-semibold text-center">
              Edit picture
            </span>
          </div>
        </div>

        <!-- Bio -->
        <div class="w-full">
          <label class="block font-medium mb-1 mt-6 md:mt-0 text-left" for="bio"
            >Bio</label
          >
          <textarea
            id="bio"
            v-model="form.bio"
            placeholder="Live, Laugh, Love"
            class="w-full min-h-[110px] border rounded p-2"
          />
        </div>

        <!-- Username -->
        <div class="w-full">
          <label
            class="block font-medium mb-1 mt-6 md:mt-0 text-left"
            for="username"
            >Username</label
          >
          <input
            id="username"
            v-model="form.username"
            type="text"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Email -->
        <div class="w-full">
          <label
            class="block font-medium mb-1 mt-6 md:mt-0 text-left"
            for="email"
            >Email</label
          >
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Password -->
        <div class="w-full">
          <label
            class="block font-medium mb-1 mt-6 md:mt-0 text-left"
            for="password"
            >Password</label
          >
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Confirm Password -->
        <div class="w-full">
          <label
            class="block font-medium mb-1 mt-6 md:mt-0 text-left"
            for="confirmPassword"
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
        <div class="col-span-full flex justify-center gap-4 mt-4">
          <button
            type="submit"
            :disabled="!canSubmit"
            class="w-full font-bold py-3 transition rounded-none"
            :class="
              canSubmit
                ? 'bg-darkviolet text-white hover:bg-darkviolet'
                : 'bg-gray-400 text-white cursor-not-allowed'
            "
          >
            SAVE
          </button>

          <button
            type="button"
            @click="cancelEdit"
            class="w-full border-2 border-darkviolet text-darkviolet rounded-none font-bold py-3 transition"
          >
            CANCEL
          </button>
        </div>

        <p v-if="success" class="text-green-600 text-center col-span-full mt-2">
          {{ success }}
        </p>
        <p v-if="error" class="text-red-500 text-center col-span-full mt-2">
          {{ error }}
        </p>
      </form>
    </main>

    <BottomNav class="block md:hidden fixed bottom-0 left-0 w-full" />
  </div>
</template>
