<template>
    <div class="btn-group-vertical">
      <!-- <button class="btn btn-sm">Права доступа:</button> -->

      <button
        @click="status_edit(item.id, 'admin')"
        class="btn btn-sm"
        :class="item.access == 'admin' ? 'btn-success' : 'btn-outline-success'"
      >
        Администратор
      </button>

      <button
        @click="status_edit(item.id, 'moder')"
        class="btn btn-sm"
        :class="item.access == 'moder' ? 'btn-success' : 'btn-outline-success'"
      >
        Модератор
      </button>

      <button
        @click="status_edit(item.id, 'block')"
        class="btn btn-sm"
        :class="
          item.access != 'admin' && item.access != 'moder'
            ? 'btn-danger'
            : 'btn-outline-secondary'
        "
      >
        нет доступа
      </button>
    </div>
</template>

<script>
import axios from "axios";

// import {
// toRef
// } from "vue";

// import items from "./../../modules/items.ts";

import { useRoute } from "vue-router";

export default {
  props: {
    //  itemIndex: { type: Number , default: 0 } ,
    item: { type: Object },
    //  cfg: { type: Object } ,
  },

  data() {
    return {
      //   istatus: this.item.status,
    };
  },

  setup(
    props
    // context
  ) {
    // console.log("props", props);
    // let item_id = props.itemId;
    // console.log( 'cntx' , context.attrs);
    // const itemId = props.itemId;

    // const itemId = toRef(props, "item-id");
    // const itemId = props.item_id;
    // const item = props.item;

    // const itemStatus0 = props.item.status ?? 'x';

    // this.istatus = props.item.status;

    // const route = useRoute();
    // const module = route.params.module;

    // let itemIndex = props.itemIndex;

    const route = useRoute();
    const module = route.params.module;

    return {
      //   item,
      // istatus
      //   itemIndex,
      module,
    };
  },

  // mounted() {
  //     console.log("Component mounted.");
  // }

  methods: {
    // изменяем видимость маленького описания
    status_edit(item_id, new_access) {
      //   if (
      //     new_status != "delete" ||
      //     (new_status == "delete" && confirm("удалить совсем ?"))
      //   ) {
      console.log("new_access", this.module, item_id, new_access);

      // const { items_data } = items();
      // console.log("items_data", items_data);
      // console.log("items_data2", this.itemIndex);
      // console.log("items_data3", items_data.value[itemIndex] );
      // let rr = items_data.value.keys();
      // let rr = items_data.value.find( n => n.id === item_id);
      // console.log("rr", rr);

      // const { getItemsAll ,
      // // items_loading_module
      //  } = items();

      axios
        .post("/set-api/new_access", {
          this_module: this.module,
          item_id: item_id,
          access: new_access,
        })
        .then((response) => {
          console.log(response.data);
          if (response.data.result == true) {
            this.item.access = new_access;
          } else {
            alert("edited error");
          }

          // items_loading_module.value = '';
          // getItemsAll(module);
        })
        .catch((error) => {
          console.log(error);
          alert("error:" + error.message);
          // this.errored = true;
        });

      //   }
    },
  },
};
</script>
