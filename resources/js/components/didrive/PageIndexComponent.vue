<template>
  <div>

showEditForm {{ showEditForm }}

    <template v-if="this.$route.params.v1 == 'v' && this.$route.params.v2 == 0">33333</template>
    <template v-else>
      <!-- <div class="alert alert-light">now_cfg: {{ now_cfg }}</div> -->
      <!-- <br /> -->
      <!-- dataModules: {{ dataModules }}    <br /> -->
      <!-- now_module: {{ now_module }}    <br /> -->

      <!-- {{ $route.params.v1 }} / -->
      <!-- {{ $route.params.v2 }} + -->
      <!-- {{ $route }} -->

      <module-items
        v-if="now_cfg && now_cfg['type'] && now_cfg['type'] == 'items'"
      />

      <module-page
        v-else-if="now_cfg && now_cfg['type'] && now_cfg['type'] == 'page_file'"
      />

      <div v-else-if="!now_cfg" class="alert alert-warning">.. Loading ..</div>

      <div v-else class="alert alert-warning">
        Что то пошло не так, ошибка №69
      </div>
    </template>
  </div>
</template>

<script>
// import axios from "axios";

// import items from "./../../modules/items.ts";
// import itemsItem from "./ModItemsItem.vue";
// import itemsForm from "./ModItemsForm.vue";

// import linkPages from "../comand/PagesComponent.vue";

import moduleItems from "./items/Body1.vue";
import modulePage from "./pageFile/body.vue";

import amodules from "./../../modules/amodules.ts";

import {
  ref,
  // toRef
  // // onUpdated,
  // // onBeforeUpdate,
  // // onMounted
  watchEffect,
} from "vue";

import { useRoute } from "vue-router";

export default {
  //   props: {
  //     // loop0: Number
  //     //     itemId: String,
  //     //     itemStatus: String
  //   },

  //   data() {
  //     console.log("index data ");

  //     return {
  //       //   dataModules,
  //       // now_module: "x1",
  //       // loading_data: false,
  //       // loading_module: "",
  //       // datas: { 1: 2 },
  //       // wer: {},
  //       // showForm: false,
  //       // on_page: 21,
  //       // page_now: 1,
  //       // show_now_page: 1
  //     };
  //   },

  setup(props) {
    // const { items_data, item_cfg, items_loading } = items();

    // const item_cfg = getCfg();

    // console.log("setup 7");

    // onMounted(() => {
    //     console.log("onMounted");
    //     // now_module = "x2";
    // });

    // onBeforeUpdate(() => {
    //     console.log("onBeforeUpdate 7");
    const route = useRoute();
    const now_module = route.params.module;
    // console.log( 'route' , this.$route);
    // now_module = this.$route.params.module;
    //     // $route.params.module
    // });

    const showEditForm = ref(( route.params.v1 == 'v' && route.params.v2 == 0 ) ? true : false);
    


    const {
      dataModules,
      // module_now,
      // getModules
    } = amodules();

    // onUpdated(() => {
    //     console.log("onUpdated 7");
    // });

    // let datas = "";
    const now_cfg = ref({});

    watchEffect(() => {
      now_cfg.value = dataModules.value[route.params.module];
    });

    return {
      now_module,
      dataModules,
      now_cfg,
      // module,
      // // itemStatus0
      // datas,
      // items_data,
      // // items_cfg
      // item_cfg,
      // items_loading
      // // now_module
      showEditForm,
    };
  },

  // watch: {
  //     now_module: function(newMod) {
  //         console.log("новое значение для now_module", newMod);
  //         // this.get_datar(newMod);

  //         const {
  //             getItemsAll
  //             // items_loading_module
  //         } = items();
  //         // items_loading_module.value = '';
  //         getItemsAll(newMod);
  //     }
  // },

  components: {
    moduleItems,
    modulePage,
    // itemsItem,
    // itemsForm,
    // linkPages
  },

  // mounted() {
  //     //     // console.log("Component mounted 7.", this.$route.params.module);

  //     console.log("Component mounted 7.");

  //     const route = useRoute();
  //     const module = route.params.module;

  //     const {
  //         getItemsAll
  //         // items_loading_module
  //     } = items();
  //     // items_loading_module.value = '';
  //     getItemsAll(module);

  //     // console.log("Component mounted 7 1.", module);
  //     // this.now_module = route.params.module;
  //     // this.get_datar(module);

  //     // console.log( 'now_module' , now_module );
  //     // console.log("t.now_module", this.now_module);
  // },

  // beforeUpdate() {
  //     console.log("beforeUpdate 7 7");

  //     const route = useRoute();
  //     const module = route.params.module;

  //     const {
  //         getItemsAll
  //         // items_loading_module
  //     } = items();
  //     // items_loading_module.value = '';
  //     getItemsAll(module);

  //     // const route = useRoute();
  //     // const module = route.params.module;
  //     // this.get_datar(module);

  //     // console.log("beforeUpdate 7 7", this.now_module);
  //     // const route = useRoute();
  //     // const module = route.params.module;
  //     // this.now_module = route.params.module;
  //     // console.log("beforeUpdate 7 7", this.now_module);
  // },

  // computed: {
  //     // wer() {
  //     //     // console.log("wer", this);
  //     //     console.log("wer");
  //     //     // `this` указывает на экземпляр vm
  //     //     // return this.$route.params.module ?? "xx";
  //     //     return this.get_datar(this.$route.params.module);
  //     // }

  //     items_kolvo() {
  //         const { items_data } = items();
  //         return items_data.value && items_data.value.length
  //             ? items_data.value.length
  //             : 0;
  //     },

  //     data_on_page() {
  //         const { items_data } = items();

  //         if (items_data.value && items_data.value.length) {
  //             // let start = this.show_now_page * this.on_page - 1;
  //             // let fin = start + this.on_page;

  //             let start = 0;
  //             let fin = 0;

  //             if (this.show_now_page == 1) {
  //                 start = 0;
  //                 fin = this.on_page - 1;
  //             } else {
  //                 start = (this.show_now_page - 1) * this.on_page;
  //                 fin = start + this.on_page - 1;
  //             }

  //             let result = items_data.value.slice(start, fin);

  //             return result;
  //         } else {
  //             return {};
  //         }
  //     }
  // },
  // methods: {
  // pagesAction(setPage) {
  //     console.log("commis", "table", "method", "pagesAction", setPage);
  //     console.log("кликнули 2 новая страница " + setPage);
  //     this.show_now_page = setPage;
  // }

  //     // изменяем видимость маленького описания
  // get_datar(module) {

  //     if (this.loading_module != module) {
  //         this.loading_module = module;

  //         const {
  //             items_data,
  //             items_cfg,
  //             items_loading
  //             // items_loading_module ,
  //             // items_now_loading
  //         } = items();
  //         // const route = useRoute();

  //         console.log("грузим");

  //         items_data.value = {};
  //         items_cfg.value = {};
  //         items_loading.value = true;

  //         //         // console.log( 'new_status' , new_status);
  //         axios
  //             .get(
  //                 "/get-api/get_data_module/" + module
  //                 // {
  //                 //     show_in_cabinet: new_show_in_cabinet,
  //                 // }
  //             )
  //             .then(response => {
  //                 // console.log("get_datar", response.data);
  //                 // items_loading_module.value = items_now_loading.value;
  //                 items_data.value = response.data.data;
  //                 items_cfg.value = response.data.cfg;
  //                 items_loading.value = false;
  //                 // return response.data;
  //                 // items_loading.value = dfalse
  //             })
  //             .catch(error => {
  //                 console.log(error);
  //                 // this.errored = true;
  //             });
  //         //         this.itemStatus0 = new_status;
  //     }
  // }
  // }
};
</script>

<style></style>
