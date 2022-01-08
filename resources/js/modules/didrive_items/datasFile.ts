import {
    ref,
    //     // reactive, toRefs, readonly,
    //     watch,
    //     // computed
} from 'vue'

import axios from "axios";

// import pages from './../pages.ts';

// import filterSettings from "./../filterSettings.ts";

// // конфиг загружаемой инфы
// const cfg = ref({})
// // данные что загрузил
const dataText = ref({})
// // отфильтрованный список
// const data_filtered = ref({})
// // загрузка идёт или нет
const loading = ref(true)
// // какой модуль сейчас загружен
// const loading_module_now = ref('')


const loadData = (module = '') => {

    if (module != '') {

        axios
            .get(
                "/get-api/get_data_module/" + module
            )
            .then(response => {
                // console.log("get_datar", response.data);
                console.log("загружено", response.data.data.length);
                // items_loading_module.value = items_now_loading.value;

                // data_filtered.value =
                dataText.value = response.data.data;
                // cfg.value = response.data.cfg;
                loading.value = false;
                // return response.data;
                // items_loading.value = dfalse
            })
            .catch(error => {
                console.log(error);
                // this.errored = true;
            });
    }

}

export default function datasFile() {
    return {
        loading,
        dataText,
        loadData,
    }
};





//     // console.log('modules items getItemsAll', 1);

//     if (loading_module_now.value != module) {

//         loading_module_now.value = module;

//         console.log('mod didrive items datas', 'loadData', 'грузим данные');

//         // ставим что первая страница
//         const { setPage } = pages();
//         setPage(1);

//         // const {
//         //     items_data,
//         //     items_cfg,
//         //     items_loading
//         //     // items_loading_module ,
//         //     // items_now_loading
//         // } = items();
//         // const route = useRoute();

//         // console.log("грузим 2");

//         data.value = {};
//         cfg.value = {};
//         loading.value = true;

//         //         // console.log( 'new_status' , new_status);
//         axios
//             .get(
//                 "/get-api/get_data_module/" + module
//             )
//             .then(response => {
//                 console.log("get_datar", response.data);
//                 // items_loading_module.value = items_now_loading.value;

//                 // data_filtered.value =
//                 data.value = response.data.data;
//                 cfg.value = response.data.cfg;
//                 loading.value = false;
//                 // return response.data;
//                 // items_loading.value = dfalse
//             })
//             .catch(error => {
//                 console.log(error);
//                 // this.errored = true;
//             });
//         //         this.itemStatus0 = new_status;

//     } else {
//         console.log('modules items getItemsAll', 'не грузим данные, уже есть');
//     }

//     // return items_data.value ?? 'x'

// }


// const { showStatusDelete } = filterSettings();
// const { now_page } = pages();

// watch([showStatusDelete, now_page, loading], (newValues, prevValues) => {

//     const { now_page, onPage, kolvo } = pages();

//     if (newValues[0] !== prevValues[0])
//         now_page.value = 1;

//     // console.log('watch', newValues, prevValues)
//     // console.log('watch', newValues[0], prevValues[0])
//     //   const { items_data, items_filtered } = items();
//     // console.log("фльтр data", data.value);

//     if (data.value && data.value.length) {

//         // const { showStatusDelete } = filterSettings();
//         // console.log("фльтру delete = ", showStatusDelete.value);

//         const items_filtered = data.value.filter(el => {

//             if (el.status == "delete" && showStatusDelete.value == false) {
//                 return false;
//             }

//             return true;
//         });

//         // console.log("отфильтровали массив по фльтру ", items_filtered);

//         let start = 0;
//         let fin = 0;



//         kolvo.value = items_filtered.length;

//         if (now_page.value == 1) {
//             start = 0;
//             fin = onPage.value - 1;
//         } else {
//             start = (now_page.value - 1) * onPage.value;
//             fin = start + onPage.value - 1;
//         }

//         // console.log("показываем из массива ", start, fin);

//         data_filtered.value = {};

//         // let result = items_data2.slice(start, fin);
//         data_filtered.value = items_filtered.slice(start, fin);

//         // return result;
//     } else {
//         data_filtered.value = {};
//     }


// });


// export default function datas() {
//     return {
//         // конфиг загружаемой инфы
//         cfg,
//         // данные что загрузил
//         data,
//         // отфильтрованный список
//         data_filtered,
//         // загрузка идёт или нет
//         loading,
//         // какой модуль сейчас загружен
//         loading_module_now,
//         // ф загрузка данных
//         //  loadData = (module, db_connection = 'out') => {
//         loadData
//     }
// }












// // import axios from "axios";

// // import filterSettings from "./filterSettings.ts";

// // // 'booms' : {},
// // // 'booms-agreements-send' : {},
// // // 'booms-no-show' : {},
// // // 'booms-follow-ups' : {},

// // let items_now_loading = ref('');

// // let items_loading_module = ref('');
// // let items_loading = ref(true);

// // const items_data = ref({});
// // const items_filtered = ref({});
// // const items_cfg = ref({});

// // const items_modules = reactive({});

// // import pages from './pages.ts';

// // // let booms = ref({});
// // // let booms_agreements_send = {}
// // // 'booms-no-show' : {},
// // // 'booms-follow-ups' : {},

// // const setBooms = (e) => {
// //     console.log('booms - setBooms', e);
// //     // obj.data = e
// //     // console.log('booms - setBooms', booms);

// // }

// // const showMeCfgPole = (pole) => {

// //     // Example use:var
// //     // let scores = { John: 2, Sarah: 3, Janet: 1 };

// //     // let filtered = Object.filter(items_cfg, ([ar_pole, val]) => ar_pole == pole);
// //     // console.log('filtered', filtered);

// //     // const dd = toRefs(items_cfg.value);
// //     console.log('items_cfg', items_cfg.value);
// //     let dd = items_cfg.value.keys().filter(
// //         (k) => {
// //             console.log(33333, items_cfg[k], k ?? 'x', v ?? 'x');
// //             return true;
// //         }
// //     );
// //     console.log('items_cfg', dd);

// //     return dd
// // }

// // const getCfgType = (k) => {

// //     const dd = toRefs(items_cfg.value);
// //     // console.log( 'items_cfg' , items_cfg.value);
// //     console.log('items_cfg', dd);
// //     return { ee: 22 }


// //     // console.log('k', k);
// //     // if( items_cfg.value[k] && items_cfg.value[k].length > 0 ){}else{ return {}; }

// //     if (typeof items_cfg.value[k] !== 'undefined') {
// //         console.log('k', k);
// //         // return items_cfg.value;
// //         // console.log(items_cfg.value);
// //         // const ee = toRefs(items_cfg.value[k])
// //         const ee = { type: 'string1' }
// //     } else {

// //         console.log('k skip');
// //         const ee = { type: 'string' }
// //     }

// //     console.log('ee', ee);

// //     return ee;

// //     const ee1 = toRefs(ee[k])
// //     return ee1

// //     let r = toRefs(items_cfg.value);
// //     return r[k].type;

// //     // return k+'111';

// //     // return toRefs(items_cfg);
// //     // const dd = readonly(items_cfg.value[k]);
// //     // return readonly(items_cfg);
// //     // return dd;
// //     // return readonly(items_cfg.value);
// // }



















// // const refreshFilteredData = () => {

// //     // data_on_page() {

// //     // const { items_data, items_filtered } = items();
// //     const { showStatusDelete } = filterSettings();

// //     if (items_data.value && items_data.value.length) {
// //         items_filtered.value = items_data.value.filter(function (e) {
// //             if (showStatusDelete.value === false && e.status == "delete") {
// //                 return false;
// //             }
// //             return true;
// //         });

// //         let start = 0;
// //         let fin = 0;

// //         if (this.show_now_page == 1) {
// //             start = 0;
// //             fin = this.on_page - 1;
// //         } else {
// //             start = (this.show_now_page - 1) * this.on_page;
// //             fin = start + this.on_page - 1;
// //         }

// //         console.log("показываем из массива ", start, fin);

// //         // let result = items_data2.slice(start, fin);
// //         return items_filtered.value.slice(start, fin);

// //         // return result;
// //     } else {
// //         return {};
// //     }
// //     // },

// // }


// // const getItems = (modules) => {
// //     return items_data ?? 'x'
// // }

// // const getItemsAll = (module, db_connection = 'out') => {

// //     // console.log('modules items getItemsAll', 1);

// //     if (items_loading_module != module) {

// //         items_loading_module = module;
// //         console.log('modules items getItemsAll', 'грузим данные');

// //         // ставим что первая страница
// //         const { setPage } = pages();
// //         setPage(1);

// //         // const {
// //         //     items_data,
// //         //     items_cfg,
// //         //     items_loading
// //         //     // items_loading_module ,
// //         //     // items_now_loading
// //         // } = items();
// //         // const route = useRoute();

// //         // console.log("грузим 2");

// //         items_data.value = {};
// //         items_cfg.value = {};
// //         items_loading.value = true;

// //         //         // console.log( 'new_status' , new_status);
// //         axios
// //             .get(
// //                 "/get-api/get_data_module/" + module
// //             )
// //             .then(response => {
// //                 console.log("get_datar", response.data);
// //                 // items_loading_module.value = items_now_loading.value;
// //                 items_data.value = response.data.data;
// //                 items_cfg.value = response.data.cfg;
// //                 items_loading.value = false;
// //                 // return response.data;
// //                 // items_loading.value = dfalse
// //             })
// //             .catch(error => {
// //                 console.log(error);
// //                 // this.errored = true;
// //             });
// //         //         this.itemStatus0 = new_status;

// //     } else {
// //         console.log('modules items getItemsAll', 'не грузим данные, уже есть');
// //     }

// //     return items_data.value ?? 'x'

// // }



// // // const hideBoomsItem = (e) => {

// // //     console.log('booms - hideItem', e);

// // //     // show_notes_tmoffer_id.value = e
// // //     // notes_start.value = true;
// // //     // notes_text.value = 6666666;
// // // }

// // export default function items() {
// //     return {
// //         // setNotesTmofferId, getNotesTmofferId, notes_text,
// //         // get_notes_text, loading_id, notes_start , color_show_head, head_title
// //         // booms,
// //         // setBooms,
// //         // getBooms,
// //         // hideBoomsItem
// //         items_now_loading,
// //         items_loading_module,
// //         items_data,
// //         getItems,
// //         getItemsAll,
// //         items_cfg,
// //         // getCfg,
// //         getCfgType,
// //         items_loading,
// //         items_modules,
// //         showMeCfgPole,
// //         items_filtered,
// //         refreshFilteredData,
// //     };

// // }


// // // // const show_notes_tmoffer_id = ref<number>(0)
// // // const show_notes_tmoffer_id = ref(0)

// // // // const notes_text = ref<string>('')
// // // // const notes_text = ref<T>('')
// // // const notes_text = ref(' ... loading - step 0 ... ')
// // // const color_show_head = ref('')
// // // const head_title = ref('')

// // // // const get_notes_text = ref('')
// // // // const loading_id = ref<number>(0);
// // // const loading_id = ref(0);

// // // const notes_start = ref(true);

// // // const getNotesTmofferId = computed(() => show_notes_tmoffer_id.value)
// // // const get_notes_text = computed(() => notes_text.value)

// // // // const getNotes = () => {

// // // // axios
// // // //         // const // booms = axios
// // // //         .get("/closer/api/get_notes/" + show_notes_tmoffer_id.value)
// // // //         .then((response) => {

// // // //             console.log('notes api', response.data);

// // // //             //     //this.content_show =
// // // //             notes_text.value = response.data.notes;

// // // //             console.log('notes api 2 ', notes_text.value);


// // // //             //     // loading = false;
// // // //             //     loading_id.value = getNotesTmofferId.value;
// // // //             //     // this.noupdate_text = true;

// // // //         })
// // // //         .catch((error) => {
// // // //             console.log('mod notes', error);
// // // //             // notes1.errored = true;
// // // //             // notes1.loading = false;
// // // //         });
// // // // }
// // // // return notes_text.value;


// // // const setNotesTmofferId = (e) => {
// // //     console.log('notes - const setNotesTmofferId', e);
// // //     show_notes_tmoffer_id.value = e
// // //     notes_start.value = true;
// // //     // notes_text.value = 6666666;
// // // }

