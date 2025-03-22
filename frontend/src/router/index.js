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
import userRegister from '@/views/User_dashboard/registration/register.vue'
import userUpdatePassword from '@/views/User_dashboard/registration/updatePassword.vue'
import useError from "@/views/User_dashboard/error/errors.vue"
import userHomePage from '@/views/User_dashboard/home/homePage.vue'

import registrationError from "@/views/User_dashboard/error/errors.vue"
import userWelcome from "@/views/User_dashboard/registration/welcome.vue"
import Patients from '@/views/Hospital/Patients.vue'
import Appointments from '@/views/Hospital/Appointments.vue'
import AddGuardian from '@/views/Hospital/AddGuardian.vue'
import AddBaby from '@/views/Hospital/AddBaby.vue'
import { useAuthStore } from '@/stores/auth'
import homePage from '@/views/User_dashboard/home/homePage.vue'
import userProfile from "@/views/User_dashboard/settings/profile.vue";
import vaccineRecord from '@/views/User_dashboard/home/vaccineRecordPage.vue'
import userAccount from '@/views/User_dashboard/settings/userAccount.vue'
import childrenRecordPage from '@/views/User_dashboard/home/childrenRecordPage.vue'

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
      meta: { guest: true }
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignUp,
      meta: { guest: true }
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
      path: '/user',
      name: 'userWelcome',
      component: userWelcome,
    },
    {
      path: '/user/login',
      name: 'userLogin',
      component: userLoginForm,
    },
    {
      path: '/user/register',
      name: 'userRegister',
      component: userRegister,
    },
    {
      path: '/user/updatePassword',
      name: 'userUpdatePassword',
      component: userUpdatePassword,
    },
    {
      path: '/user/home',
      name: 'userHomePage',
      component: userHomePage,
    },
    {
      path: '/user/records/vaccination',
      name: 'vaccineRecord',
      component: vaccineRecord,
    },
    {
      path: '/user/records/babies',
      name: 'childrenRecord',
      component: childrenRecordPage,
    },
    {
      path: '/user/profile',
      name: 'userProfile',
      component: userProfile,
    },
    {
      path: '/user/profile/account',
      name: 'userAccount',
      component: userAccount,
    },
    {
      path: '/user/error/:errorCode?',
      name: 'useError',
      component: useError,
    },
    {
      path: '/user/error/:errorCode?',
      name: 'registrationError',
      component: registrationError,
    },
    {
      path: '/user/home',
      name: 'userhomePage',
      component: homePage,
    },
    {
      path: '/hospital/patients',
      name: 'hospital.patients',
      component: Patients,
      meta: { auth: true }
    },
    {
      path: '/hospital/appointments',
      name: 'hospital.appointments',
      component: Appointments,
      meta: { auth: true }
    },
    {
      path: '/hospital/add-parent',
      name: 'hospital.add-parent',
      component: AddGuardian,
      meta: { auth: true }
    },
    {
      path: '/hospital/add-baby',
      name: 'hospital.add-baby',
      component: AddBaby,
      meta: { auth: true }
    },
  ],
})

/* 
  Please could you explain the reason for this code? 
  On my  end, it is making a request to api/user 
  when I try to access the user page
*/

// router.beforeEach(async (to, from) => {
//   const authStore = useAuthStore()
//   await authStore.getUser()

//   if (authStore.user && to.meta.guest) {
//     if (authStore.user.role === 'nurse') {
//       return { name: 'hospital.patients' }
//     }
//   }

//   if (!authStore.user && to.meta.auth) {
//     return { name: 'signin' }
//   }
// })

export default router
