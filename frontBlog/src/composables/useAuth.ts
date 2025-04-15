import { ref } from "vue";

export const currentUser = ref(null);

export async function fetchCurrentUser() {
  try {
    const res = await fetch("http://localhost:8000/api/user", {
      credentials: "include", // 🔐 pour que Sanctum fonctionne
    });

    if (res.ok) {
      currentUser.value = await res.json();
    } else {
      currentUser.value = null;
    }
  } catch (error) {
    console.error("Failed to fetch current user:", error);
    currentUser.value = null;
  }
}
