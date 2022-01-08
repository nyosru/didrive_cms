<template>

  <button
    class="btn btn-info btn-sm xfloat-right"
    v-if="!showThisForm"
    @click="showThisForm = !showThisForm"
  >
    <i class="fas fa-plus"></i> добавить
  </button>

  <button
    class="btn btn-secondary btn-sm xfloat-right"
    v-if="showThisForm"
    @click="showThisForm = !showThisForm"
  >
    <i class="fas fa-plus"></i> скрыть
  </button>

  <div class="container" v-if="showThisForm">
    <div class="row">
      <div class="col-12 offset-md-2 col-md-8">
        <h3>Добавить</h3>

        <form
          xxsubmit.prevent="submitForm"
          id="item_form"
          method="post"
          action="/set-api/save_new_item"
          enctype="multipart/form-data"
        >
          <input type="hidden" name="_token" :value="token" />
          <input type="hidden" name="this_module" :value="now_module" />

          <div v-for="(v, k) in cfg.cfg" :key="k">
            <div class="form-group">
              <label :for="k">{{ v.mod }} / {{ v["name"] }}</label>

              <div v-if="v['type'] == 'img'">
                <input
                  type="file"
                  class="form-control"
                  :name="v.mod"
                  :id="k"
                  @change="onAttachmentChange"
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
                  :name="v.mod"
                  :id="k"
                />
              </div>

              <div v-else>
                <input type="text" class="form-control" :id="k" :name="v.mod" />
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

// import {
//   watchEffect,
// //   // onUpdated ,
// //   //     // onBef
// } from "vue";

// import { useRoute } from "vue-router";


export default {
  props: {
    cfg: { type: Object },
    // showThisForm: { type: Boolean, default: false },
    now_module: { type: String },
  },

  data() {
    return {
      showThisForm: false,
    };
  },

  setup(props) {
    console.log("add form setup add 7");

    // onUpdated(() => {
    // // //   // console.log(3333333333);
    //   this.showThisForm = false;
    // });

    // let showThisForm = false;

    // watchEffect(() => {
    //   //   loadData(route.params.module);
    //   const route = useRoute();
    //   let t = route.params.module;
    //   showThisForm = false;
    // });

    let token = document.head.querySelector('meta[name="csrf-token"]');

    return {
      token: token.content,
      //   showThisForm: false,
    };
  },
};
</script>

<style></style>
