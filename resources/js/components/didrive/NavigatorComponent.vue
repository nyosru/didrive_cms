<template>
  <div>

33333322222221111111111

    <!-- dataModules: {{ dataModules }} -->
    <!-- <br /> -->

<!-- route {{ this.$route }} -->
<!-- <br/> -->

    <!-- сейчас моудль {{ cfg ?? 'x' }}
    <template v-if="cfg.type == 'items'">
      <mod_items />
    </template>
    <template v-if-else="cfg.type == 'page'"> page </template> -->
  </div>
</template>

<script>
// import itemsFilters from "./ModItemsFilters.vue";
// import linkPages from "../comand/PagesComponent.vue";
// import itemsItem from "./ModItemsItem.vue";
// import itemsFormAdd from "./ModItemsForm2.vue";
// import datas from "./../../modules/didrive_items/datas.ts";
// import filterSettings from "./../../modules/filterSettings.ts";

import amodules from "./../../modules/amodules.ts";
// import modItems from "./../../components/didrive/ModItems2.vue";

// import { useRoute } from "vue-router";

import {
  // watchEffect,
  onMounted,
} from "vue";

// import { useRoute } from "vue-router";

export default {
  components: {
    // modItems,
    //     itemsItem,
    //     itemsFormAdd,
    //     linkPages,
    //     itemsFilters,
  },

  setup(props) {

    onMounted(() => {
      //   const route = useRoute();
      //   console.log("route", route);
      console.log("33333");
    });

    // console.log("mod items setup");

    // const route = useRoute();
    // const { loadData } = datas();

    // watchEffect(() => {
    //   const route = useRoute();
    //   // loadData(route.params.module);
    // console.log(222, route.params.module ?? 'xx'); //   loadData();
    //   // const route = useRoute();
    //   // route.params.module
    // });

    // const { loading, cfg, data_filtered } = datas();
    // const { showStatusDelete } = filterSettings();

    const {
      dataModules,
      // module_now,
      // getModules
    } = amodules();
    // getModules();

    // const cfg = dataModules.value[route.params.module] ?? {};

    return {
      //   cfg: module_now,
      cfg,
      dataModules,
      //   items_cfg: cfg,
      //   data_filtered,
      //   items_loading: loading,
      //   showStatusDelete,
      //   now_module: route.params.module,
    };
  },

  //   watch: {
  //     $route(to, from) {
  //       // обрабатываем изменение параметров маршрута...
  //       //   console.log("route watch", to.params.tmoffer_id, to, from);
  //       console.log("route watch", to.params.module);

  //       const { getModules, setModuleNow } = amodules();
  //       getModules();
  //       setModuleNow(to.params.module);

  //       //   const { loading, loadingData } = TmOfferInfo();
  //       //   loading.value = true;
  //       //   const route = useRoute();
  //       //   if (to.params.tmoffer_id > 0) {
  //       //     loadingData(to.params.tmoffer_id);
  //       //     //   loading.value = false;
  //       //     window.location.hash = "#tmoffer_info";
  //       //   }
  //     },
  //   },
};
</script>
