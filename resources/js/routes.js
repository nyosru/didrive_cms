export default {
 const routes = [
    {
        path: "/closer",
        name: "closer-index",
        //   component: Home
        // component: () => import(/* webpackChunkName: "about" */ './pages/IndexComponent.vue' )
        // component: About1,
        component: PageIndex
    },
    // {
    //     path: "/closer/routers",
    //     name: "closer-routes",
    //     //   component: Home
    //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    //     component: About1,
    // },
    // {
    //     path: "/closer/routers/list",
    //     name: "closer-routes-list",
    //     // route level code-splitting
    //     // this generates a separate chunk (about.[hash].js) for this route
    //     // which is lazy-loaded when the route is visited.
    //     //   component: () => import(/* webpackChunkName: "about" */ './views/AboutList.vue')
    //     component: About2,
    // },

    // {
    //     path: "/closer/comission",
    //     name: "comission",
    //     //   component: Home
    //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    //     component: comission,
    // },

    // {
    //     path: "/closer/opportunities",
    //     name: "opportunities",
    //     //   component: Home
    //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    //     component: opportunities,
    // },

    // {
    //     path: "/closer/calls",
    //     name: "calls",
    //     //   component: Home
    //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    //     component: calls,
    // },

    // {
    //     path: "comission",
    //     name: "comission",
    //     //   component: Home
    //     // component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    //     component: comission,
    // },

    { path: '/:pathMatch(.*)*', component: NotFound },

];

// return routes;
}
