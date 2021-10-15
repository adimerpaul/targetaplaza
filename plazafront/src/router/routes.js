import Login from "pages/Login";
import User from "pages/User";
import Recarga from "pages/Recarga";
import Historialrecarga from "pages/Historialrecarga";
import Historialgasto from "pages/Historialgasto";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: Login },
      { path: '/user', component: User,meta: {requiresAuth: true,} },
      { path: '/recarga', component: Recarga,meta: {requiresAuth: true,} },
      { path: '/historialrecarga', component: Historialrecarga,meta: {requiresAuth: true,} },
      { path: '/historialgasto', component: Historialgasto,meta: {requiresAuth: true,} },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
