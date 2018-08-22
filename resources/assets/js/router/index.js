import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'

Vue.use(Router)

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next()
    return
  }
    next('/')
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/login')
}

export default new Router({
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: require('../components/login'),
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/',
      name: 'Home',
      component: require('../components/home'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/sidebar',
      name: 'SideBar',
      component: require('../components/sidebar'),
    },
    {
      path: '/patients/patient',
      name: 'Patient',
      component: require('../components/patients/patient'),
      beforeEnter: ifAuthenticated,
    },
    // Lab Configurations
    {
      path: '/labconfiguration/healthunit',
      name: 'HealthUnit',
      component: require('../components/labconfiguration/healthunit'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/labconfiguration/organization',
      name: 'Organization',
      component: require('../components/labconfiguration/organization'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/labconfiguration/interfacedequipment',
      name: 'InterfacedEquipment',
      component: require('../components/labconfiguration/interfacedequipment'),
      beforeEnter: ifAuthenticated,
    },
    // Test Catalog
    {
      path: '/testcatalog/testtypecategory',
      name: 'LabSection',
      component: require('../components/testcatalog/testtypecategory'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/drug',
      name: 'Antibiotic',
      component: require('../components/testcatalog/antibiotic'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/specimentype',
      name: 'SpecimenType',
      component: require('../components/testcatalog/specimentype'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype',
      name: 'TestType',
      component: require('../components/testcatalog/testtype/index'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/testcatalog/testtype/:id',
      name: 'Measure',
      component: require('../components/testcatalog/testtype/measure'),
      beforeEnter: ifAuthenticated,
    },
    // Access Control
    {
      path: '/accesscontrol/useraccounts',
      name: 'UserAccount',
      component: require('../components/accesscontrol/useraccounts'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/permissions',
      name: 'Permission',
      component: require('../components/accesscontrol/permissions'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/role',
      name: 'Role',
      component: require('../components/accesscontrol/role'),
      beforeEnter: ifAuthenticated,
    },
    {
      path: '/accesscontrol/roleusers',
      name: 'RoleUser',
      component: require('../components/accesscontrol/roleusers'),
      beforeEnter: ifAuthenticated,
    },
    //Routine and Reference Testing
    {
      path: '/test/index',
      name: 'Test',
      component: require('../components/test/index'),
      beforeEnter: ifAuthenticated,
    },
    //Quality Control
    {
      path: '/qualitycontrol/lot',
      name: 'Lot',
      component: require('../components/qualitycontrol/lot'),
      beforeEnter: ifAuthenticated,
    },
    // General Stats
    {
      path: '/stats/',
      name: 'Stats',
      component: require('../components/statistics/system/index'),
      beforeEnter: ifAuthenticated,
    },
    //All Users Stats
    {
      path: '/stats/users',
      name: 'user_stats',
      component: require('../components/statistics/users/index'),
      beforeEnter: ifAuthenticated,
    },
    //Single User Stats
    {
      path: '/stats/users/:id',
      name: 'single_user_stats',
      component: require('../components/statistics/users/single'),
      beforeEnter: ifAuthenticated,
    },
    //All Tests Stats
    {
      path: '/stats/tests',
      name: 'tests_stats',
      component: require('../components/statistics/tests/index'),
    },
    //Search Tests Stats
    {
      path: '/stats/tests/search',
      name: 'tests_stats_search',
      component: require('../components/statistics/tests/search'),
    },
    {
      path: '/qualitycontrol/controltest',
      name: 'ControlTest',
      component: require('../components/qualitycontrol/controltest'),
      beforeEnter: ifAuthenticated,
    },
  ],
})
