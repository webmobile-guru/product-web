import { Trans } from '@/plugins/Translation'

function load (component) {
  // '@' is aliased to src/components
  return () => import(/* webpackChunkName: "[request]" */ `@/pages/${component}.vue`)
}

export default [
  {
    path: '/:lang',
    component: {
      template: '<router-view></router-view>'
    },
    beforeEnter: Trans.routeMiddleware,
    children: [
      {
        path: '',
        name: 'Home',
        component: load('Home')
      },
      {
        path: 'notationtest',
        name: 'notationtest',
        component: load('Notationtest')
      },
      {
        path: 'notationtest2',
        name: 'notationtest2',
        component: load('Notationtest2')
      },
      /*
      {
        path: 'archive',
        name: 'archive',
        component: load('Archive')
      },
      {
        path: 'song/:item_id',
        name: 'song',
        component: load('Song')
      },
      */
      {
        path: '*',
        component: load('404')
      }
    ]
  },
  {
    // Redirect user to supported lang version.
    path: '*',
    redirect (to) {
      return Trans.getUserSupportedLang()
    }
  }
]
