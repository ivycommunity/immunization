import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SignIn from '@/views/SignIn.vue'
import SignUp from '@/views/SignUp.vue'

import AboutUsView from '../views/AboutUsView.vue'
import ContactUsView from '@/views/contactUsView.vue'
import VaccinationDetails from '@/views/vaccinationDetails.vue'
import ClinicsView from '@/views/clinicsView.vue'
import FAQView from '@/views/FAQView.vue'
import userLoginForm from "@/views/User_dashboard/registration/login.vue"
import registrationError from "@/views/User_dashboard/registration/error.vue"
import userWelcome from "@/views/User_dashboard/registration/welcome.vue"

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/signin',
      name: 'signin',
      component: SignIn,
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignUp,
    },
    {
      path: '/about-us',
      name: 'about-us',
      component: AboutUsView,
    },
    {
      path: '/contact-us',
      name: 'contact-us',
      component: ContactUsView,
    },
    {
      path: '/vaccinations',
      name: 'vaccinations',
      component: VaccinationDetails,
    },
    {
      path: '/clinics',
      name: 'Clinics near you',
      component: ClinicsView,
    },
    {
      path: '/questions',
      name: 'Questions',
      component: FAQView,
    },
    {
      path: '/user/welcome',
      name: 'userWelcome',
      component: userWelcome,
    },
    {
      path: '/user/login',
      name: 'userLogin',
      component: userLoginForm,
    },
    {
      path: '/user/registrationError',
      name: 'registrationError',
      component: registrationError,
    },
  ],
})

export default router
