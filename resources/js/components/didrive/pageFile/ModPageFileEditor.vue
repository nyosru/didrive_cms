<template>
  <ckeditor
    xstyle="width: 100%; min-height: 350px"
    xname="editor1"
    xv-model="editorData"
    :model-value="editorData"
    :editor="editor"
    :config="editorConfig"
    @destroy="onEditorDestroy"
  ></ckeditor>
</template>

<script>
import { onUnmounted } from "vue";


import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  props: {
    editorData: { type: String },
  },

  components: {
    ckeditor: CKEditor.component,
  },

  data() {
    // const imageConfig = {
    //   toolbar: [
    //     "imageStyle:inline",
    //     "imageStyle:wrapText",
    //     "imageStyle:breakText",
    //     "|",
    //     "toggleImageCaption",
    //     "imageTextAlternative",
    //   ],
    // };

    return {
    //   imageConfig,
      //   //             myValue: '55555555555',
      //   text_data: '2222'

      editor: ClassicEditor,
      // editorData: "<p>Content loading</p>",
      //   editorData: html,
      editorConfig: {
        // The configuration of the editor.
        // image: {
        //   insert: {
        //     // ... // settings for "insertImage" view goes here
        //     //   },
        //     toolbar: [
        //       "resizeImage:25",
        //       "resizeImage:50",
        //       "resizeImage:75",
        //       "resizeImage",
        //       //,
        //       "imageStyle:inline",
        //       "imageStyle:wrapText",
        //       "imageStyle:breakText",
        //       "|",
        //       "toggleImageCaption",
        //       "imageTextAlternative",
        //     ],
        //     resizeUnit: "%",
        //     resizeOptions: [
        //       {
        //         name: "resizeImage:original",
        //         value: null,
        //       },
        //       {
        //         name: "resizeImage:25",
        //         value: "25",
        //         icon: "small",
        //       },
        //       {
        //         name: "resizeImage:50",
        //         value: "50",
        //         icon: "medium",
        //       },
        //       {
        //         name: "resizeImage:75",
        //         value: "75",
        //         icon: "large",
        //       },
        //     ],
        //   },
        // },
      },
    };
  },

  setup(props) {
    console.log("CKEditor.component", CKEditor.component);

    // onUnmounted(() => {
    //   CKEditor.component = {};
    // });

    // console.log("mod dataFile setup");

    // const route = useRoute();
    // // const { loadData } = datas();

    // // const text_data = ref(".. loading ..");

    // const {
    //   loading,
    //   // dataText,
    //   loadData,
    // } = datasFile();

    // watchEffect(() => {
    //   console.log("route.params.module", route.params.module);
    //   loadData(route.params.module);
    // });

    // // let editorData = '';

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

    // let ee = props.editorData1;

    return {
        // editorData: ee
      //   text_data,
      //   editorData,
      //   loading,
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
    onEditorDestroy() {
      console.log("CKEditor.component", 'onEditorDestroy');
    //   console.log("CKEditor.component", CKEditor.component);
    //   console.log("CKEditor", CKEditor);
    // //   console.log("CKEditor editorData", editorData);
    //   console.log("CKEditor editorData1", this.editorData1);
    //   this.editorData1 = '';
    // //   console.dir("CKEditor", CKEditor);
    //   console.log("onEditorDestroy", 11111);
    },
    //   savePage() {
    //     console.log( 'savePage', 11111);
    //   },
    //     initCKEditor() {
    //       console.log(11111);
    //     },
    //     //    summernoteChange(newValue) {
    //     //       console.log("summernoteChange", newValue);
    //     //    },
    //     //     summernoteImageLinkInsert(...args) {
    //     //       console.log("summernoteImageLinkInsert()", args);
    //     //    },
  },
};
</script>
