import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LayoutView from '@/views/LayoutView.vue';
import UserList from '@/components/user/List.vue'
import UserUpdate from '@/views/users/UpdateUser.vue'
import UserCreate from '@/views/users/CreateUser.vue'
import TeacherCreate from '@/views/teachers/CreateTeacher.vue'
import TeacherUpdate from '@/views/teachers/UpdateTeacher.vue'
import LoginView from "@/views/auth/LoginView.vue";
import CategoryList from "@/components/category/List.vue"
import Profile from '@/components/profile/Profile.vue';
import TeacherList from '@/components/teacher/List.vue';
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
          path: '/users',
          name: 'users',
          component: UserList
        },
        {
          path: '/user/:id/update',
          name: 'userUpdate',
          component: UserUpdate
        },
        {
          path: '/user/Create',
          name: 'userCreate',
          component: UserCreate
        },
        {
          path: '/categories',
          name: 'categories',
          component: CategoryList
        },
        {
          path: '/profile',
          name: 'profile',
          component: Profile
        },
        {
          path: '/teachers',
          name: 'teachers',
          component: TeacherList
        },
        {
          path: '/teacher/:id/update',
          name: 'teacherUpdate',
          component: TeacherUpdate
        },
        {
          path: '/teacher/create',
          name: 'teacherCreate',
          component: TeacherCreate
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
