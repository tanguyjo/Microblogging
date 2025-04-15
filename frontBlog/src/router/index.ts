import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import PostDetailView from "@/views/PostDetailView.vue";
import LoginView from "@/views/LoginView.vue";
import SignUpView from "@/views/SignUpView.vue";
import NewPostView from "@/views/NewPostView.vue";
import ProfileView from "@/views/ProfileView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
    meta: { requiresAuth: true }
  },
  {
    path: "/posts/:id",
    name: "PostDetail",
    component: PostDetailView,
    meta: { requiresAuth: true }
  },
  {
    path: "/login",
    name: "Login",
    component: LoginView,
    meta: { requiresAuth: false }
  },
  {
    path: "/signup",
    name: "SignUp",
    component: SignUpView,
    meta: { requiresAuth: false }
  },
  {
    path: "/newpost",
    name: "NewPost",
    component: NewPostView,
    meta: { requiresAuth: true }
  },
  {
    path: "/profile",
    name: "Profile",
    component: ProfileView,
    meta: { requiresAuth: true }
  },
  {
    path: "/profile/:username",
    name: "UserProfile",
    component: ProfileView,
    meta: { requiresAuth: true }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !token) {
    // Rediriger vers la page de login si l'utilisateur n'est pas connecté
    next({ name: 'Login' }); 
  } else if (token && (to.name === 'Login' || to.name === 'SignUp')) {
    // Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
    next({ name: 'home' });
  } else {
    next();
  }
}); 

export default router;
