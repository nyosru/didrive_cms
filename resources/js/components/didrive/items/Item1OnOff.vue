<template>
  <div class="btn-group btn-group-sm" role="group" aria-label="...">

    <button
      @click="status_edit(item.id, 'show')"
      class="btn"
      :class="item.status == 'show' ? 'btn-success' : 'btn-secondary'"
    >
      Вкл
    </button>

    <button
      @click="status_edit(item.id, 'hide')"
      class="btn"
      :class="item.status == 'hide' ? 'btn-warning' : 'btn-secondary'"
    >
      Выкл
    </button>

    <button
      @click="status_edit(item.id, 'delete')"
      class="btn"
      :class="item.status == 'delete' ? 'btn-danger' : 'btn-secondary'"
    >
      Удалить
    </button>

  </div>
  <span v-if="loading">
    <br />
    <img src="/img/load.gif" style="width: 90px" />
  </span>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRoute } from "vue-router";

export default {
  props: {
    item: { type: Object },
  },

//   data() {
//     return {
//       //   istatus: this.item.status,
//     };
//   },

  setup(
    props
  ) {

    const route = useRoute();
    const module = route.params.module;
    const loading = ref(false);

    return {
      loading,
      module,
    };
  },

  methods: {
    // изменяем видимость маленького описания
    status_edit(item_id, new_status) {
      if (
        new_status != "delete" ||
        (new_status == "delete" && confirm("удалить совсем ?"))
      ) {
        console.log("new_status", this.module, item_id, new_status);
        this.loading = true;

        axios
          .post("/set-api/new_status_item", {
            this_module: this.module,
            item_id: item_id,
            status: new_status,
          })
          .then((response) => {
            console.log(response.data);
            this.item.status = new_status;
            this.loading = false;
          })
          .catch((error) => {
            console.log(error);
            alert("error:" + error.message);
          });
      }
    },
  },
};
</script>
