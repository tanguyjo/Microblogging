import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import PostDetailView from "@/views/PostDetailView.vue";
import LoginView from "@/views/LoginView.vue";
import SignUpView from "@/views/SignUpView.vue";
import NewPostView from "@/views/NewPostView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/posts/:id",
    name: "PostDetail",
    component: PostDetailView,
  },
  {
    path: "/login",
    name: "Login",
    component: LoginView,
  },
  {
    path: "/signup",
    name: "SignUp",
    component: SignUpView,
  },
  {
    path: "/newpost",
    name: "NewPost",
    component: NewPostView,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
