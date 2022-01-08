<template>

  <div class="pb-5">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Module: page</h3>

        <div class="card-tools">
          <span style="display: inline-block; float: right">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button> -->
          </span>

          <!-- <span style="display: inline-block; float: right">
          <link-pages />
        </span> -->
        </div>
      </div>

      <div class="card-body" style="display: block">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- <mod-page-file-editor
                v-if="!loading && dataText && dataText.length"
                :editorData="dataText"
              /> -->

              <!-- <ckeditor
                aaxstyle="width: 100%; min-height: 350px"
                aaxname="editor1"
                v-model="editorData"
                aaxxmodel-value="editorData"
                :editor="editor"
                :config="editorConfig"
                aaxx@destroy="onEditorDestroy"
                @input="updateField"
              ></ckeditor> -->

              <ckeditor
                v-model="editorData"
                :editor="editor"
                :config="editorConfig"
                @input="updateField"
              ></ckeditor>

              <!-- <tiptap /> -->

              <!-- <editor
                api-key="no-api-key"
                :init="{
                  menubar: false,
                  plugins: 'lists link image emoticons',
                  toolbar:
                    'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons',
                }"
              /> -->

              <!-- <quill-editor
                v-model:value="state.content"
                :options="state.editorOption"
                :disabled="state.disabled"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)"
                @change="onEditorChange($event)"
              /> -->
            </div>
          </div>
        </div>
      </div>

      <div
        class="card-footer"
        style="
          display: block;
          background-color: rgba(0, 0, 0, 0.7);
          position: sticky;
          bottom: 0;
        "
      >
        <span style="float: right">
          <!-- <link-pages /> -->

          <span v-if="saveDataError" class="alert alert-danger p-1 mr-2"
            >Упс .. ошибочка сохранения</span
          >
          <span v-else-if="saveDataOk" class="alert alert-success p-1 mr-2"
            >Сохранено</span
          >
          <span v-else-if="saveData" class="alert alert-warning p-1 mr-2">сохраняем</span>
          <span v-else-if="editedData" class="alert alert-light p-1 mr-2">
            Есть не сохранённые изменения
          </span>

          <button class="btn btn-success" @click="saveText">Save</button>
        </span>
      </div>

      <div class="overlay" v-if="loading">
        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
      </div>
    </div>
  </div>
</template>

<script>
// import itemsFilters from "./ModItemsFilters.vue";
// import linkPages from "../comand/PagesComponent.vue";
// import itemsItem from "./ModItemsItem.vue";
// import itemsFormAdd from "./ModItemsForm2.vue";
// import filterSettings from "./../../modules/filterSettings.ts";

import datasFile from "./../../../modules/didrive_items/datasFile.ts";

// import ModPageFileEditor from "./ModPageFileEditor.vue";

// import CKEditor from "@ckeditor/ckeditor5-vue";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

// import SummernoteEditor
// import SummernoteEditor from 'vue3-summernote-editor';

// import Tiptap from "./editorTiptap.vue";
// import Editor from "@tinymce/tinymce-vue";

import { ref, watchEffect, onUnmounted, reactive } from "vue";

import { useRoute } from "vue-router";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

// import CKEditor from "@ckeditor/ckeditor5-vue";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

//single file // Quill
// import { quillEditor, Quill } from "vue3-quill";
// import customQuillModule from "customQuillModule";
// Quill.register("modules/customQuillModule", customQuillModule);

import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  components: {
    // quillEditor,
    // editor: Editor,
    // ckeditor: CKEditor.component,
    // ModPageFileEditor,
    // Tiptap,
    //     ckeditor: CKEditor.component,
    //     // itemsItem,
    //     // itemsFormAdd,
    //     // linkPages,
    //     // itemsFilters,
    //     // SummernoteEditor,
    //     // CKEditor,
  },

  data() {
    return {
      editor: ClassicEditor,
      editorData: "<p>Rich-text editor content.</p>",
      editorConfig: {
        // The configuration of the rich-text editor.
      },
      saveData: false,
      saveDataOk: false,
      saveDataError: false,
      //   editedData: false,
    };
  },

  //   data() {
  //     //     // const { dataText } = datasFile();

  //     // const state = reactive({
  //     //   content: "<p>2333</p>",
  //     //   _content: "",
  //     //   editorOption: {
  //     //     placeholder: "core",
  //     //     modules: {
  //     //       // toolbars: [
  //     //       // custom toolbars options
  //     //       // will override the default configuration
  //     //       // ],
  //     //       // other moudle options here
  //     //       // otherMoudle: {}
  //     //     },
  //     //     // more options
  //     //   },
  //     //   disabled: false,
  //     // });

  //     // const onEditorBlur = (quill) => {
  //     //   console.log("editor blur!", quill);
  //     // };
  //     // const onEditorFocus = (quill) => {
  //     //   console.log("editor focus!", quill);
  //     // };
  //     // const onEditorReady = (quill) => {
  //     //   console.log("editor ready!", quill);
  //     // };
  //     // const onEditorChange = ({ quill, html, text }) => {
  //     //   console.log("editor change!", quill, html, text);
  //     //   state._content = html;
  //     // };

  //     // setTimeout(() => {
  //     //   state.disabled = true;
  //     // }, 2000);

  //     return {
  //     //   state,
  //     //   onEditorBlur,
  //     //   onEditorFocus,
  //     //   onEditorReady,
  //     //   onEditorChange,
  //       editor: ClassicEditor,
  //       editorConfig: {},
  //       now_module: "",
  //       saveData: false,
  //       saveDataOk: false,
  //       saveDataError: false,
  //       editedData: false,
  //       //       //   //             myValue: '55555555555',
  //       //       //   text_data: '2222'

  //       //       editor: ClassicEditor,
  //       //         // editorData: "<p>Content loading</p>",
  //       //       editorData: dataText.value,
  //       //       editorConfig: {
  //       //         // The configuration of the editor.
  //       //       },
  //     };
  //   },

  setup(props) {
    console.log("mod dataFile setup");

    const route = useRoute();
    // const { loadData } = datas();
    // const text_data = ref(".. loading ..");
    const { loading, dataText, loadData } = datasFile();

    watchEffect(() => {
      if (loading.value == true) {
        // console.log("route.params.module", route.params.module);
        loadData(route.params.module);
      }
    });

    // editor.model.document.on("change:data", () => {
    //   console.log("The data has changed!");
    // });

    // onUnmounted(() => {
    //   // const { dataText , loading } = datasFile();
    //   dataText.value = "";
    //   loading.value = true;
    // });

    // let editorData = '';

    // watchEffect(() => {
    //   editorData = dataText.value;
    // //   CKEditor.setData(dataText.value);
    // });

    // const { loading, cfg, data_filtered } = datas();
    // const { showStatusDelete } = filterSettings();

    // // const editor = ClassicEditor;
    // // const editorData = "<p>Rich-text editor content.</p>";
    // // const editorConfig = {
    // //   // The configuration of the rich-text editor.
    // // };

    let nowData = ref("");

    const editedData = ref(false);
    const saveData = ref(false);
    const saveDataOk = ref(false);
    const saveDataError = ref(false);

    function updateField() {
      //   console.log(7777, editorData.length);
      console.log(7777, dataText.value.length);
      //   nowData = editorData;
      nowData.value = dataText.value;

      //   this.editedData = true;
      editedData.value = true;
      //   this.saveData = false;
      saveData.value = false;
      //   this.saveDataOk = false;
      saveDataOk.value = false;
      //   this.saveDataError = false;
      saveDataError.value = false;

      //   this.$emit("input", String(this.editorData));
      //   this.$emit("input", this.editorData);
    }

    return {
      editedData,
      saveData,
      saveDataOk,
      saveDataError,
      updateField,
      nowData,
      editorData: dataText,
      now_module: route.params.module,
      //   text_data,
      //   editorData,
      dataText,
      loading,
      //   items_cfg: cfg,
      //   data_filtered,
      // items_loading: loading,
      //   showStatusDelete,
      //   now_module: route.params.module,

      //   editor: ClassicEditor,
      //   editorData: "<p>Rich-text editor content.</p>",
      //   editorConfig: {},
    };
  },

  methods: {
    // updateField() {
    //   console.log(7777, this.editorData.length);
    //   this.nowData = this.editorData;

    //   this.editedData = true;
    //   this.saveData = false;
    //   this.saveDataOk = false;
    //   this.saveDataError = false;

    //   //   this.$emit("input", String(this.editorData));
    //   //   this.$emit("input", this.editorData);
    // },

    saveText() {
      console.log("savePage");
      //   console.log("data", this.editorData);

      //   const route = useRoute();

      this.saveData = true;
      this.saveDataOk = false;
      this.saveDataError = false;

      axios
        .post("/api/page/save/" + this.now_module, {
          data_new: this.nowData,
          //   item_id: item_id,
          //   status: new_status,
        })
        .then((response) => {
          //   console.log(response.data);
          if (response.data.res == true) {
            this.saveData = false;
            this.saveDataOk = true;
          } else {
            this.saveDataError = true;
          }
          //   this.item.status = new_status;
          //   this.loading = false;
        })
        .catch((error) => {
          //   console.log("error", error);
          this.saveDataError = true;
          //   alert("error:" + error.message);
        });
    },
    //     //    summernoteChange(newValue) {
    //     //       console.log("summernoteChange", newValue);
    //     //    },
    //     //     summernoteImageLinkInsert(...args) {
    //     //       console.log("summernoteImageLinkInsert()", args);
    //     //    },
  },
};
</script>
