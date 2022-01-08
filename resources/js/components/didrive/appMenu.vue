<template>
  <nav class="mt-2">
    <!-- user_data: {{ user_data }} -->

<!-- {{ this.$route.params.module }} -->

    <ul
      class="nav nav-pills nav-sidebar flex-column"
      data-widget="treeview"
      role="menu"
      data-accordion="false"
    >
      <li class="nav-item" v-for="(v, k) in dataModules" :key="k">
        <!-- v: {{ v }} -->
        <template v-if="v.type == 'page_file'" >
        <a class="nav-link" :href="'/modules/' + k"
        :class="{ 'active': this.$route.params.module == k }"
        >
          <i class="nav-icon fas fa-caret-right"></i>
          <small style="float:right;"><sup>page</sup></small>
          <p>{{ v.name }}</p>
        </a>
        <a class="nav-link" :href="'/modules/' + k + '/v/0'"
        :class="{ 'active': this.$route.params.module == k }"
        >
          <i class="nav-icon fas fa-caret-right"></i>
          <small style="float:right;"><sup>page2</sup></small>
          <p>{{ v.name }}</p>
        </a>

        </template>
        <template v-else-if="v.type == 'page'" >
          
        <!-- <a class="nav-link" :href="'/modules/' + k"
        :class="{ 'active': this.$route.params.module == k }"
        >
          <i class="nav-icon fas fa-caret-right"></i>
          <small style="float:right;"><sup>page</sup></small>
          <p>{{ v.name }}</p>
        </a> -->

        <a class="nav-link" :href="'/modules/' + k + '/v/0'"
        :class="{ 'active': this.$route.params.module == k }"
        >
          <i class="nav-icon fas fa-caret-right"></i>
          <small style="float:right;"><sup>page</sup></small>
          <p>{{ v.name }}</p>
        </a>
        </template>
        <router-link
          v-else-if="
            k != 'users' ||
            (k == 'users' && user_data.access && user_data.access == 'admin')
          "
          :to="{ name: 'mod_start', params: { module: k } }"
          xclass="btn btn-sm btn-light text-left"
          class="nav-link"
        >
          <!-- <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-arrow-right-short"
          viewBox="0 0 16 16"
        >
          <path
            fill-rule="evenodd"
            d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"
          />
        </svg>
        {{ v.name }} -->

          <i class="nav-icon fas fa-caret-right"></i>
          <p>
            {{ v.name }}
            <!-- <span class="right badge badge-danger">New</span> -->
          </p>
        </router-link>
      </li>
    </ul>

    <!-- <pre style="font-size:10px;">{{ $router.currentRoute }}</pre> -->
  </nav>
</template>

<script>
// import axios from "axios";

// import items from "./../../modules/items.ts";
import iuser from "./../../modules/iuser.ts";
import amodules from "./../../modules/amodules.ts";

import {
  //     // toRef
  onMounted,
} from "vue";

export default {
  props: {
    // itemId: String,
    // itemStatus: String
  },

  data: () => ({
    // modules: {},
    // user: {},
    // user_data: {},
  }),

  setup(
    props
    // context
  ) {
    console.log("setup 1");

    onMounted(() => {
      console.log("appMenu", "setup", "onMounted(() => {");

      const { getUser } = iuser();
      getUser();

      const { getModules } = amodules();
      getModules();
    });

    // console.log("props", props);
    // let item_id = props.itemId;

    // console.log( 'cntx' , context.attrs);
    // const itemId = props.itemId;

    // const itemId = toRef(props, "item-id");
    // const itemId = props.item_id;

    // const itemStatus0 = props.itemStatus.value;

    // onMounted(() => {
    //     console.log(333);
    // });

    const { user_data } = iuser();
    const { dataModules } = amodules();

    return {
      dataModules,
      // itemStatus0
      // modules
      user_data,
    };
  },

  //   mounted() {
  //     console.log("appMenu Component mounted.");

  //     axios
  //       // const booms = axios
  //       .get(
  //         "/get-api/get_modules"
  //         // +
  //         //     (props.itype ? "/" + props.itype : "")
  //       )
  //       .then((response) => {
  //         this.modules = response.data;

  //         const {
  //           items_modules,
  //           // items_data,
  //           // items_cfg,
  //           // getCfg,
  //           // items_loading
  //         } = items();
  //         // const item_cfg = getCfg();
  //         items_modules.value = response.data;

  //         //this.content_show =
  //         // if (!this.itype) {
  //         // const { setBooms } = ReactiveBooms3();
  //         // setBooms(response.data);
  //         // } else {
  //         // props.content = response.data;
  //         // }
  //         // console.log("start3", getBooms());

  //         // props.loading = false;
  //       })
  //       .catch((error) => {
  //         console.log("error", error);
  //         // props.errored = true;
  //       });
  //     // .finally(() => {
  //     //     this.loading = false;
  //     // })
  //   },
  methods: {
    // // изменяем видимость маленького описания
    // status_edit(new_status) {
    //     // console.log( 'new_status' , new_status);
    //     // axios
    //     //     .post("/closer/api/booking_edit/" + booking_id, {
    //     //         show_in_cabinet: new_show_in_cabinet,
    //     //     })
    //     //     // .then((response) => {
    //     //     //     console.log(response.data);
    //     //     // })
    //     //     .catch((error) => {
    //     //         console.log(error);
    //     //         // this.errored = true;
    //     //     });
    //     this.itemStatus0 = new_status;
    // }
  },
};
</script>

<style>
.menu_left a {
  display: block;
  margin-bottom: 3px;
  /* background-color: rgba(0, 0, 0, 0.05); */
}
/* .menu_left a:hover { */
/* background-color: rgba(0, 0, 250, 0.15); */
/* } */
</style>
