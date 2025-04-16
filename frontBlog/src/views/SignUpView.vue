<template>
  <div class="min-h-screen flex items-center justify-center bg-white px-6">
    <div class="w-full max-w-sm">
      <!-- Titre -->
      <h1 class="text-6xl font-title font-bold text-black text-center">
        Welcome
      </h1>
      <p class="text-gray-500 text-center mt-1">Let's sign you up quickly</p>

      <!-- Message d'erreur -->
      <p v-if="error" class="mt-4 text-red-500 text-center">{{ error }}</p>

      <!-- Formulaire -->
      <form @submit.prevent="handleSubmit" class="mt-8 space-y-4">
        <input
          v-model="username"
          type="text"
          placeholder="Enter your username"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
          required
        />
        <input
          v-model="email"
          type="email"
          placeholder="Enter your email"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
          required
        />

        <input
          v-model="password"
          type="password"
          placeholder="Enter your password"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
          required
        />
        <input
          v-model="confirmPassword"
          type="password"
          placeholder="Confirm password"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
          required
        />

        <button
          type="submit"
          class="w-full bg-darkviolet text-white font-bold py-3 rounded-sm hover:bg-purple-700 transition"
          :disabled="isLoading"
        >
          {{ isLoading ? 'SIGNING UP...' : 'SUBMIT' }}
        </button>
      </form>

      <!-- Lien d'inscription -->
      <p class="text-sm text-black text-center mt-6">
        Already have an account?
        <RouterLink
          to="/login"
          class="text-darkviolet font-medium hover:underline"
        >
          Log in
        </RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const username = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const error = ref('');
const isLoading = ref(false);

async function handleSubmit() {
  error.value = '';
  
  // Validation des mots de passe
  if (password.value !== confirmPassword.value) {
    error.value = 'Passwords do not match';
    return;
  }

  // Validation de la longueur du mot de passe
  if (password.value.length < 6) {
    error.value = 'Password must be at least 6 characters long';
    return;
  }

  isLoading.value = true;

  try {
    const response = await fetch('http://localhost:8000/api/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        username: username.value,
        email: email.value,
        password: password.value,
      }),
    });

    const data = await response.json();

    if (!response.ok) {
      if (data.errors) {
        // Gérer les erreurs de validation spécifiques
        const errorMessages = Object.values(data.errors).flat();
        throw new Error(errorMessages.join('\n'));
      }
      throw new Error(data.message || 'Registration failed');
    }

    // Stocker le token et le nom d'utilisateur
    localStorage.setItem('token', data.token);

    // Rediriger vers la page d'accueil
    router.push('/');
  } catch (err) {
    console.error('Registration error:', err);
    error.value = err instanceof Error ? err.message : 'An error occurred during registration';
  } finally {
    isLoading.value = false;
  }
}
</script>
