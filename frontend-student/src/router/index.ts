import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import StudentInfo from '../views/student/StudentInfo.vue'
import LayoutView from '@/views/LayoutView.vue';
import LoginView from "@/views/auth/LoginView.vue";
import PAGE_ROUTE, { publicPath } from "@/const/pageRoute";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "layout",
      component: LayoutView,
      children: [
        {
          path: "/",
          name: "home",
          component: HomeView,
        },
        {
          path: "/student",
          name: "student",
          component: StudentInfo,
        },
      ]
    },
    {
      path: PAGE_ROUTE.LOGIN,
      name: "login",
      component: LoginView,
    },
    
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
