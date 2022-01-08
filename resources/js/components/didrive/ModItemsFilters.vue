<template>

    <a href="" v-if="!showForm" class="mb-3 bg-light float-right" @click.prevent="showForm = !showForm">
      <small><i class="fas fa-filter"></i> показать фильтры</small>
    </a>


  <transition>
    <div v-if="showForm" class="mb-5">
      <a href="" class="float-right" @click.prevent="showForm = !showForm">
        <small>скрыть фильтры</small>
      </a>

      Удалённые элементы
      <select v-model="showStatusDelete">
        <option :value="false">Не показывать</option>
        <option :value="true">Показывать</option>
      </select>
    </div>
  </transition>
</template>

<script>
// import items from "./../../modules/items.ts";
// import itemsItem from "./ModItemsItem.vue";
// import itemsForm from "./ModItemsForm.vue";
// import linkPages from "../comand/PagesComponent.vue";

// import pages from "./../../modules/pages.ts";
// import iuser from "./../../modules/iuser.ts";

import filterSettings from "./../../modules/filterSettings.ts";

// import {
//   //   // toRef
//   //   // onUpdated,
//   onBeforeUpdate,
//   onMounted,
//   //   // readonly
//   //   // watch
// } from "vue";

// import { useRoute } from "vue-router";

export default {
  //   props: {
  //     // loop0: Number
  //     //     itemId: String,
  //     //     itemStatus: String
  //   },

  data: () => ({
    showForm: false,
  }),

  //   setup(props) {
  setup() {
    const { showStatusDelete } = filterSettings();

    return {
      showStatusDelete,
    };
  },
};

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

//   components: {
//     itemsItem,
//     itemsForm,
//     linkPages,
//   },

//   mounted() {
//     //     //     // console.log("Component mounted 7.", this.$route.params.module);
//     //     console.log("Component mounted 7.");

//     const route = useRoute();
//     const module = route.params.module;

//     const {
//       getItemsAll,
//       //         // items_loading_module
//     } = items();
//     //     // items_loading_module.value = '';
//     getItemsAll(module);

//     //     // console.log("Component mounted 7 1.", module);
//     //     // this.now_module = route.params.module;
//     //     // this.get_datar(module);

//     //     // console.log( 'now_module' , now_module );
//     //     // console.log("t.now_module", this.now_module);
//   },

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

//   computed: {
//     // wer() {
//     //     // console.log("wer", this);
//     //     console.log("wer");
//     //     // `this` указывает на экземпляр vm
//     //     // return this.$route.params.module ?? "xx";
//     //     return this.get_datar(this.$route.params.module);
//     // }

//     // glob_items_cfg() {

//     // axios
//     //     .get(
//     //         "/get-api/get_data_module/" + module
//     //         // {
//     //         //     show_in_cabinet: new_show_in_cabinet,
//     //         // }
//     //     )
//     //     .then(response => {

//     //         console.log("get_datar 0 cfg", response.data);
//     //         // items_loading_module.value = items_now_loading.value;
//     //         // items_data.value = response.data.data;
//     //         return response.data.cfg;
//     //         // console.log(this.glob_items_cfg);
//     //         // items_loading.value = false;
//     //         // return response.data;
//     //         // items_loading.value = dfalse

//     //     })
//     //     .catch(error => {
//     //         console.log(error);
//     //         // this.errored = true;
//     //     });

//     // },

//     items_kolvo() {
//       const { items_data } = items();
//       return items_data.value && items_data.value.length ? items_data.value.length : 0;
//     },

//     data_on_page() {
//       const { items_data } = items();

//       const { showStatusDelete } = filterSettings();

//       if (items_data.value && items_data.value.length) {
//         const items_data2 = items_data.value.filter(function (e) {
//           if (showStatusDelete.value === false && e.status == "delete") return false;

//           return true;

//           //   if (
//           //     orderLimitDaysVar.value == 0 ||
//           //     moment().subtract(orderLimitDaysVar.value, "days").isBefore(elem.dater_sort)
//           //   ) {
//           //   } else {
//           //     return false;
//           //   }
//           //   // если ничего не ищем .. то показываем всё
//           //   if (comp === "") {
//           //     return true;
//           //   }
//           //   let string =
//           //     elem.subject +
//           //     " " +
//           //     elem.company +
//           //     " " +
//           //     elem.string_text_logo2 +
//           //     " " +
//           //     elem.string_text_logo;
//           //   return string.toLowerCase().indexOf(comp.toLowerCase()) > -1;
//         });

//         let start = 0;
//         let fin = 0;

//         if (this.show_now_page == 1) {
//           start = 0;
//           fin = this.on_page - 1;
//         } else {
//           start = (this.show_now_page - 1) * this.on_page;
//           fin = start + this.on_page - 1;
//         }

//         console.log("показываем из массива ", start, fin);

//         // let result = items_data2.slice(start, fin);
//         return items_data2.slice(start, fin);

//         return result;
//       } else {
//         return {};
//       }
//     },
//   },

//   methods: {
//     pagesAction(setPage) {
//       //   console.log("mod items ", "method", "pagesAction", setPage);
//       console.log("mod items кликнули новая страница " + setPage);
//       this.show_now_page = setPage;
//     },

//     //     //     // изменяем видимость маленького описания
//     //     // get_datar(module) {

//     //     //     if (this.loading_module != module) {
//     //     //         this.loading_module = module;

//     //     //         const {
//     //     //             items_data,
//     //     //             items_cfg,
//     //     //             items_loading
//     //     //             // items_loading_module ,
//     //     //             // items_now_loading
//     //     //         } = items();
//     //     //         // const route = useRoute();

//     //     //         console.log("грузим");

//     //     //         items_data.value = {};
//     //     //         items_cfg.value = {};
//     //     //         items_loading.value = true;

//     //     //         //         // console.log( 'new_status' , new_status);
//     //     //         axios
//     //     //             .get(
//     //     //                 "/get-api/get_data_module/" + module
//     //     //                 // {
//     //     //                 //     show_in_cabinet: new_show_in_cabinet,
//     //     //                 // }
//     //     //             )
//     //     //             .then(response => {
//     //     //                 // console.log("get_datar", response.data);
//     //     //                 // items_loading_module.value = items_now_loading.value;
//     //     //                 items_data.value = response.data.data;
//     //     //                 items_cfg.value = response.data.cfg;
//     //     //                 items_loading.value = false;
//     //     //                 // return response.data;
//     //     //                 // items_loading.value = dfalse
//     //     //             })
//     //     //             .catch(error => {
//     //     //                 console.log(error);
//     //     //                 // this.errored = true;
//     //     //             });
//     //     //         //         this.itemStatus0 = new_status;
//     //     //     }
//     //     // }
//   },
// };
</script>

<style></style>
