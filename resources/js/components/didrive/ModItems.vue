<template>
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title">Module: items</h3>

      <div class="card-tools">
        <span style="display: inline-block; float: right">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>

          <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button> -->
        </span>

        <span style="display: inline-block; float: right">
          <!-- <link-pages
            :itemsKolvo="items_kolvo"
            :onPage="on_page"
            :showPagesAround="5"
            :nowPage="1"
          ></link-pages> -->
        </span>

        <span style="display: inline-block; float: right">
          <link-pages
            xitemsKolvo="items_kolvo"
            :itemsKolvo="items_filtered.length ?? 0"
            :onPage="on_page"
            :showPagesAround="5"
            :nowPage="1"
          ></link-pages>
        </span>
      </div>
    </div>

    <div
      v-if="
        !items_cfg.access_only_admin ||
        (items_cfg.access_only_admin &&
          items_cfg.access_only_admin == true &&
          user_data.access == 'admin')
      "
      class="card-body"
      style="display: block"
    >
      <div class="row">
        <div class="col-12 text-center">
          <items-filters />
          <br />
          <br />
          showStatusDelete {{ showStatusDelete }}
        </div>
      </div>

      <div class="row">
        <div
          class="col-12"
          v-if="!items_cfg.no_add || (items_cfg.no_add && items_cfg.no_add != true)"
        >
          <button class="btn btn-info btn-sm float-right" @click="showForm = !showForm">
            <i class="fas fa-plus"></i> добавить
          </button>
          <items-form v-if="showForm"></items-form>
        </div>

        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <template v-for="v in items_cfg" :key="v.mod">
                  <th v-if="v.name && v.name.length">
                    {{ v.name }}
                  </th>
                </template>
              </tr>
            </thead>

            <tbody>
              <template v-for="v in data_on_page" :key="v.id">
                <items-item :item="v" :cfg="items_cfg"></items-item>
              </template>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.row -->

      <!-- /.row -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer" style="display: block">
      <!-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more -->
      <!-- examples and information about the plugin. -->
      <!-- data_on_page.length {{ data_on_page.length }} -->

      items_filtered.length {{ items_filtered.length }}

      <span style="float: right">
        <link-pages
          xxitemsKolvo="items_kolvo"
          :itemsKolvo="items_filtered.length ?? 0"
          :onPage="on_page"
          :showPagesAround="5"
          :nowPage="1"
        ></link-pages>
      </span>
    </div>

    <div class="overlay" v-if="items_loading">
      <i class="fas fa-3x fa-sync-alt fa-spin"></i>
    </div>
  </div>
</template>

<script>

import items from "./../../modules/items.ts";
import itemsItem from "./ModItemsItem.vue";
import itemsForm from "./ModItemsForm.vue";
import itemsFilters from "./ModItemsFilters.vue";
import linkPages from "./../comand/PagesComponent.vue";

import pages from "./../../modules/pages.ts";
import iuser from "./../../modules/iuser.ts";
import filterSettings from "./../../modules/filterSettings.ts";


import datas from "./../../modules/didrive_items/datas.ts";



import {
  //   // toRef
  //   // onUpdated,
  onBeforeUpdate,
  onMounted,
  //   // readonly
  //   // watch
} from "vue";

import { useRoute } from "vue-router";



export default {

  props: {
    // loop0: Number
    //     itemId: String,
    //     itemStatus: String
  },

  data() {
    // console.log("mod items data");

    // onMounted(() => {
    // console.log(2222222);
    // });
    const { user_data } = iuser();

    return {
      select_show_items_delete: false,
      //   // glob_items_cfg: {},
      //   now_module: "x1",
      //   loading_data: false,

      //   loading_module: "",
      //   datas: { 1: 2 },
      //   wer: {},
      user_data,
      showForm: false,

      //   on_page: 21,
      on_page: 21,
      //   page_now: 1,

      show_now_page: 1,
    };
  },

  setup(props) {
    console.log("mod items setup");

    //     onMounted(() => {
    //       console.log("onMounted");

    // // const { items_data, items_cfg, items_filtered, items_loading } = items();

    //       refreshFilteredData();
    //     });

    onBeforeUpdate(() => {
      console.log("mod items onBeforeUpdate");

      const route = useRoute();
      const module = route.params.module;

      const {
        getItemsAll,
        // items_cfg
        //     // items_loading_module
      } = items();

      //   // items_loading_module.value = '';
      getItemsAll(module);
    });

    const { items_data, items_cfg, items_filtered, items_loading } = items();

    const { now_page } = pages();
    let show_now_page = now_page;

    const { showStatusDelete } = filterSettings();

    let data_on_page = {};

    return {
      items_filtered,
      showStatusDelete,
      //   module,
      //   // itemStatus0
      //   datas,
      items_data,
      items_cfg,
      items_loading,
      show_now_page,
      //   // now_module
      data_on_page,
    };
  },

//   watch: {

//     // showStatusDelete: function (newMod) {
//     //   console.log("новое значение", "showStatusDelete", newMod);
//     //   this.show_data();
//     // },

//     //     now_module: function(newMod) {
//     //         console.log("новое значение для now_module", newMod);
//     //         // this.get_datar(newMod);
//     //         const {
//     //             getItemsAll
//     //             // items_loading_module
//     //         } = items();
//     //         // items_loading_module.value = '';
//     //         getItemsAll(newMod);
//     //     }
//   },

  components: {
    itemsItem,
    itemsForm,
    linkPages,
    itemsFilters,
  },

//   mounted() {
//     const route = useRoute();
//     const module = route.params.module;

//     const {
//       getItemsAll,
//       //         // items_loading_module
//     } = items();
//     getItemsAll(module);
//   },

  //   computed: {

  //     // items_kolvo() {
  //     //   const { items_filtered } = items();
  //     //   return items_filtered && items_filtered.length
  //     //     ? items_filtered.length
  //     //     : 0;
  //     // },

  //   },

  methods: {
    pagesAction(setPage) {
      //   console.log("mod items ", "method", "pagesAction", setPage);
      console.log("mod items кликнули новая страница " + setPage);
      this.show_now_page = setPage;
    },

    show_data() {

      const { items_data, items_filtered } = items();
      const { showStatusDelete } = filterSettings();

      if (items_data.value && items_data.value.length) {
        items_filtered.value = items_data.value.filter(function (e) {
          if (showStatusDelete.value === false && e.status == "delete") {
            return false;
          }
          return true;
        });

        let start = 0;
        let fin = 0;

        if (this.show_now_page == 1) {
          start = 0;
          fin = this.on_page - 1;
        } else {
          start = (this.show_now_page - 1) * this.on_page;
          fin = start + this.on_page - 1;
        }

        console.log("показываем из массива ", start, fin);

        // let result = items_data2.slice(start, fin);
        this.data_on_page = items_filtered.value.slice(start, fin);

        // return result;
      } else {
        this.data_on_page = {};
      }
    },

    //     //     // изменяем видимость маленького описания
    //     // get_datar(module) {

    //     //     if (this.loading_module != module) {
    //     //         this.loading_module = module;

    //     //         const {
    //     //             items_data,
    //     //             items_cfg,
    //     //             items_loading
    //     //             // items_loading_module ,
    //     //             // items_now_loading
    //     //         } = items();
    //     //         // const route = useRoute();

    //     //         console.log("грузим");

    //     //         items_data.value = {};
    //     //         items_cfg.value = {};
    //     //         items_loading.value = true;

    //     //         //         // console.log( 'new_status' , new_status);
    //     //         axios
    //     //             .get(
    //     //                 "/get-api/get_data_module/" + module
    //     //                 // {
    //     //                 //     show_in_cabinet: new_show_in_cabinet,
    //     //                 // }
    //     //             )
    //     //             .then(response => {
    //     //                 // console.log("get_datar", response.data);
    //     //                 // items_loading_module.value = items_now_loading.value;
    //     //                 items_data.value = response.data.data;
    //     //                 items_cfg.value = response.data.cfg;
    //     //                 items_loading.value = false;
    //     //                 // return response.data;
    //     //                 // items_loading.value = dfalse
    //     //             })
    //     //             .catch(error => {
    //     //                 console.log(error);
    //     //                 // this.errored = true;
    //     //             });
    //     //         //         this.itemStatus0 = new_status;
    //     //     }
    //     // }
  },
};
</script>

<style></style>
