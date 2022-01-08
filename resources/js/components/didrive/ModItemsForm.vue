<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-12 offset-md-2 col-md-8">
          <h3>Добавить</h3>

          <!-- {{ modules }} -->
          <form
            xxsubmit.prevent="submitForm"
            id="item_form"
            method="post"
            action="/set-api/save_new_item"
            enctype="multipart/form-data"
          >
            <input type="hidden" name="_token" :value="token" />
            <input type="hidden" name="this_module" :value="now_module" />

            <div v-for="v in modules.value[now_module]['cfg']" :key="v.mod">
              <div class="form-group">

                <label :for="k">
                  {{ v["name"] }} <sup v-if="v['required']">*</sup>
                </label>

                <div v-if="v['type'] == 'img'">
                  <input
                    type="file"
                    class="form-control"
                    :name="v['mod']"
                    :id="v['mod']"
                    @change="onAttachmentChange"
                    :required="v['required']"
                  />
                </div>

                <div v-else-if="v['type'] == 'sort'">
                  <input
                    type="number"
                    class="form-control"
                    min="0"
                    max="99"
                    step="1"
                    value="50"
                    :name="v['mod']"
                    :id="v['mod']"
                    :required="v['required']"
                  />
                </div>

                <div v-else>
                  <input
                    type="text"
                    class="form-control"
                    :id="v['mod']"
                    :name="v['mod']"
                    :required="v['required']"
                  />
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";

import items from "./../../modules/items.ts";
// import itemsItem from "./ModItemsItem.vue";

// import {
//     // toRef
//     onUpdated,
//     onBeforeUpdate,
//     onMounted
// } from "vue";

import { useRoute } from "vue-router";

export default {
  props: {
    // loop0: Number
    //     itemId: String,
    //     itemStatus: String
  },

  data() {
    console.log("data add 9");

    const { items_modules } = items();
    // const item_cfg = getCfg();

    let token = document.head.querySelector('meta[name="csrf-token"]');

    // if (token) {
    //     axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
    // } else {
    //     console.error(
    //         "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    //     );
    // }

    return {
      // now_module: "x1",
      // loading_data: false,
      // datas: { 1: 2 },
      // wer: {}
      modules: items_modules,
      attachment: "",
      token: token.content,
    };
  },

  setup(
    props
    // context
  ) {
    // const { items_data, items_cfg, getCfg, items_loading } = items();
    // const item_cfg = getCfg();

    console.log("setup add 7");

    // onMounted(() => {
    //     console.log("onMounted add");
    //     // now_module = "x2";
    // });

    // onBeforeUpdate(() => {
    //     console.log("onBeforeUpdate add 9");
    //     // const route = useRoute();
    //     // now_module = route.params.module;
    //     // $route.params.module
    // });

    // onUpdated(() => {
    //     console.log("onUpdated add 9");
    // });

    // let datas = "";

    const route = useRoute();
    const now_module = route.params.module;

    return {
      // module,
      // // itemStatus0
      // datas,
      // items_data,
      // // items_cfg
      // item_cfg,
      // items_loading
      now_module,
    };
  },

  watch: {
    // now_module: function(newMod) {
    //     console.log("новое значение для now_module", newMod);
    //     this.get_datar(newMod);
    // }
  },

  components: {
    // itemsItem
  },

  mounted() {
    //     // console.log("Component mounted 7.", this.$route.params.module);
    console.log("Component mounted add 9.");
    // const route = useRoute();
    // const module = route.params.module;
    // console.log("Component mounted 7 1." , module);
    // // this.now_module = route.params.module;
    // this.get_datar(module);
    // // console.log( 'now_module' , now_module );
    // // console.log("t.now_module", this.now_module);
  },

  beforeUpdate() {
    console.log("beforeUpdate add 9");
    // console.log("beforeUpdate 7 7", this.now_module);
    // const route = useRoute();
    // const module = route.params.module;
    // this.now_module = route.params.module;
    // console.log("beforeUpdate 7 7", this.now_module);
  },

  computed: {
    // wer() {
    //     // console.log("wer", this);
    //     console.log("wer");
    //     // `this` указывает на экземпляр vm
    //     // return this.$route.params.module ?? "xx";
    //     return this.get_datar(this.$route.params.module);
    // }
  },

  methods: {
    submitForm() {
      const { items_modules } = items();

      const config = { "content-type": "multipart/form-data" };

      // let f = document.getElementById('item_form');
      // const formData = new FormData(f);

      const formData = new FormData();

      // // console.log("ddd", this.modules);
      // // console.log("ddd", this.modules.value);

      // // console.log("ddd1", items_modules.value);
      // // console.log("ddd", this.modules.value[this.now_module]["cfg"]);
      // // console.log("ddd3", this);

      const mod = items_modules.value[this.now_module];

      const keys = Object.keys(items_modules.value[this.now_module]["cfg"]);
      keys.forEach((key) => {
        console.log(key);
        // console.log(items_modules.value[key]);
        let q = document.getElementById(key);
        console.log(q);

        console.log("sss", mod["cfg"][key]["type"]);

        if (mod["cfg"][key]["type"] == "img") {
          console.log("log", mod["cfg"][key]["type"], this.attachment);
          // console.log( this.target.files  );

          //   var reader = new FileReader();
          //   // Read file into memory as UTF-16
          //   let r = reader.readAsText(q.value, "UTF-16");

          //                     // let file = new File([q.value], key);
          //                     // formData.append(key, file , q.value );
          // formData.append(key, this[key] , q.value );
          formData.append(key, this.attachment);
          // formData.append(key, this.$refs.file.files[0] );

          // var reader = new FileReader();
          // reader.onload = function(event) {
          //   var dataUri = event.target.result;
          //     // img = document.createElement("img");

          //     console.log( 'img' , dataUri );

          // //   img.src = dataUri;
          // //   document.body.appendChild(img);
          // };

          // reader.onerror = function(event) {
          //   console.error("Файл не может быть прочитан! код " + event.target.error.code);
          // };

          // reader.readAsDataURL(q.value);

          // var reader = new FileReader();
          // reader.onload = function(event) {
          //   var contents = event.target.result;
          //   console.log("Содержимое файла: " + contents);
          // };

          // reader.onerror = function(event) {
          //   console.error("Файл не может быть прочитан! код " + event.target.error.code);
          // };

          // // reader.readAsText(q);
          // reader.readAsArrayBuffer(q);
        } else {
          formData.append(key, q.value);
        }
      });

      // formData.append("name", this.name);
      // formData.append("attachment", this.attachment);

      console.log("formData", formData);

      axios
        .post("/set-api/save_new_item", formData, config)
        .then((response) => console.log(response.data.message))
        .catch((error) => console.log(error));
    },

    //     // изменяем видимость маленького описания
    // get_datar(module) {
    //     const {
    //         items_data,
    //         items_cfg,
    //         items_loading
    //         // items_loading_module ,
    //         // items_now_loading
    //     } = items();
    //     // const route = useRoute();
    //     console.log("грузим");
    //     items_data.value = {};
    //     items_cfg.value = {};
    //     items_loading.value = true;
    //     //         // console.log( 'new_status' , new_status);
    //     axios
    //         .get(
    //             "/get-api/get_data_module/" + module + "/"
    //             // {
    //             //     show_in_cabinet: new_show_in_cabinet,
    //             // }
    //         )
    //         .then(response => {
    //             // console.log("get_datar", response.data);
    //             // items_loading_module.value = items_now_loading.value;
    //             items_data.value = response.data.data;
    //             items_cfg.value = response.data.cfg;
    //             items_loading.value = false;
    //             // return response.data;
    //             // items_loading.value = dfalse
    //         })
    //         .catch(error => {
    //             console.log(error);
    //             // this.errored = true;
    //         });
    //     //         this.itemStatus0 = new_status;
    // }
  },

  onAttachmentChange(e) {
    e.preventDefault();

    // this.attachment = e.target.files[0]
    var files = e.target.files || e.dataTransfer.files;
    if (!files.length) return;
    // this.createImage(files[0]);
    console.log("files", files[0]);
    // this.createImage(files[0]);
  },
};
</script>

<style></style>
