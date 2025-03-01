import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SignIn from '@/views/SignIn.vue'
import SignUp from '@/views/SignUp.vue'

import AboutUsView from '../views/AboutUsView.vue'
import ContactUsView from '@/views/contactUsView.vue'
import VaccinationDetails from '@/views/vaccinationDetails.vue'
import ClinicsView from '@/views/clinicsView.vue'
import FAQView from '@/views/FAQView.vue'
import Home from '@/views/Hospital/Patients.vue'
import Appointments from '@/views/Hospital/Appointments.vue'
import AddGuardian from '@/views/Hospital/AddGuardian.vue'
import AddBaby from '@/views/Hospital/AddBaby.vue'

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
      path: '/hospital/patients',
      name: 'hospital.patients',
      component: Home,
    },
    {
      path: '/hospital/appointments',
      name: 'hospital.appointments',
      component: Appointments,
    },
    {
      path: '/hospital/add-parent',
      name: 'hospital.add-parent',
      component: AddGuardian,
    },
    {
      path: '/hospital/add-baby',
      name: 'hospital.add-baby',
      component: AddBaby,
    },
  ],
})

export default router
