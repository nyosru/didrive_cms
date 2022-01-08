<script>
/*
// import Vue from 'vue';
// import moment from 'moment';
// Vue.prototype.$moment = moment;
*/
import axios from "axios";
/*
// import SideMenu from "./components/SideMenuComponent.vue";
// import exampleComponent from './components/ExampleComponent.vue'
*/

// import itemOnOff from "./components/didrive/ItemOnOff.vue";

import appMenu from "./components/didrive/appMenu.vue";

// import notFound from "./components/didrive/NoFound.vue";
// import pageIndex from "./components/didrive/indexPage.vue";

/*
// {{-- button show/hide config page --}}
// import ConfigButtonComponent from "./components/ConfigButtonComponent.vue";
// body config page
// import ConfigComponent from "./components/ConfigComponent.vue";

// import BoomsInformerV3 from "./components/BoomsInformerComponent.vue";
// const Home2 = { template: '<h2>Home Page</h2>' }

// import TodoItem from "./TodoItem.vue"
// let nextTodoId = 1;

// const createTodo = (text) => ({
//     text,
//     id: nextTodoId++,
// });

// const router = new VueRouter({
//   routes
// })
*/

export default {

    setup(props) {

        let token = document.head.querySelector('meta[name="csrf-token"]');

        if (token) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
        } else {
            console.error(
                "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
            );
        }

        // alert('12');

        // let token = document.head.querySelector('meta[name="csrf-token"]');

        // if (token) {
        //     axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
        // } else {
        //     console.error(
        //         "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
        //     );
        // }

        // Vue.onMounted(() => console.log("Mounted from setup!"));
        return {};
    },

    // data() {
    //     return {
    //         preloader: true,
    //         show_menu: true,
    //         // show_iframe_div: false,
    //         // show_iframe_div: true,
    //         // message: "js2 route!",
    //         // now: new Date()
    //         // now: "da da da 1 ",
    //     };
    // },

    // computed(){
    //     console.log('2222');
    // }

    // methods: {
    //     hidePreloader(e) {
    //         console.log(333);
    //         this.preloader = false;
    //     },
    // },

    components: {
        appMenu,
        // itemOnOff,
        // notFound,
        // pageIndex
    },

    // router
    // async created() {

    //     const index_var = await axios
    //         .get("/closer/api/get_index")
    //         .catch((error) => {
    //             console.log(error);
    //             // this.errored = true;
    //         })
    //         .finally(() => {
    //             // this.loading = false;
    //         });

    //     // this.content_show = this.content = booms.data;
    //     // console.log("content", this.content);
    // },
};
</script>

<style></style>
