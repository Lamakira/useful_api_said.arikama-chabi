import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from "@/views/auth/LoginView.vue";
import SideBar from "@/components/SideBar.vue";
import RegisterView from "@/views/auth/RegisterView.vue";
import DashboardView from "@/views/DashboardView.vue";
import {useAuthStore} from "@/stores/authStore.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/auth/login',
      name: 'login',
      component: LoginView,
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: '/auth/register',
      name: 'register',
      component: RegisterView,
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: '/sidebar',
      name: 'sidebar',
      component: SideBar,
     /* meta: {
        requiresGuest: true,
      },*/
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      meta: {
        requiresAuth: true,
      },
    },
   /* {
      path: '/:catchAll(.*)',
      name: 'NotFound',
      component: NotFound,
    },*/
  ],
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  const requiresAuth = to.meta.requiresAuth

  if (to.meta.requiresGuest && auth.isAuthenticated) {
    return next('/')
  }

  if (requiresAuth && !auth.isAuthenticated) {
    return next('/auth/login')
  }
  next()
})

export default router
